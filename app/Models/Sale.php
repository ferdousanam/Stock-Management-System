<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sale extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->sale_code = Purchase::saleCode();
        });
    }

    public static function saleCode()
    {
        $data = Purchase::select('sale_code')
            ->where(DB::raw("YEAR(created_at)"), date('Y'))
            ->where(DB::raw("MONTH(created_at)"), date('m'))
            ->orderBy('sale_code', 'DESC')
            ->first();

        $lastPart = (isset($data)) ? intval(substr($data->sale_code, 5)) : 0;

        $number = '2';
        $number .= date('ym');
        $number .= substr("0000", 0, -strlen($lastPart + 1));
        $number .= $lastPart + 1;
        return $number;
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }
}
