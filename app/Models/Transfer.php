<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Transfer extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->transfer_code = Purchase::transferCode();
        });
    }

    public static function transferCode()
    {
        $data = Purchase::select('transfer_code')
            ->where(DB::raw("YEAR(created_at)"), date('Y'))
            ->where(DB::raw("MONTH(created_at)"), date('m'))
            ->orderBy('transfer_code', 'DESC')
            ->first();

        $lastPart = (isset($data)) ? intval(substr($data->transfer_code, 5)) : 0;

        $number = '4';
        $number .= date('ym');
        $number .= substr("0000", 0, -strlen($lastPart + 1));
        $number .= $lastPart + 1;
        return $number;
    }

    public function transferItems()
    {
        return $this->morphMany(PurchaseItem::class, 'purchasable');
    }

    public function fromWarehouse()
    {
        return $this->belongsTo(Warehouse::class, 'from_warehouse_id', 'id');
    }

    public function toWarehouse()
    {
        return $this->belongsTo(Warehouse::class, 'to_warehouse_id', 'id');
    }
}
