<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Purchase extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->purchase_code = Purchase::purchaseCode();
        });
    }

    public static function purchaseCode()
    {
        $data = Purchase::select('purchase_code')
            ->where(DB::raw("YEAR(created_at)"), date('Y'))
            ->where(DB::raw("MONTH(created_at)"), date('m'))
            ->orderBy('purchase_code', 'DESC')
            ->first();

        $lastPart = (isset($data)) ? intval(substr($data->purchase_code, 5)) : 0;

        $number = '2';
        $number .= date('ym');
        $number .= substr("0000", 0, -strlen($lastPart + 1));
        $number .= $lastPart + 1;
        return $number;
    }

    public function purchaseItems()
    {
        return $this->hasMany(PurchaseItem::class);
    }
}
