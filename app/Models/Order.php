<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $primaryKey = 'id';

    protected $fillable = [
        'transaction_code',
        'name',
        'gender',
        'email',
        'phone',
        'address',
        'message',
        'method_payment',
        'content',
        'total',
        'unit_payment',
        'ip',
        'proxy',
        'status',
        'order_status'
    ];

    public static function genCode($id)
    {
        $now = Carbon::now();
        $orderCode = 'DH' . $now->format('YmdHis') . $id;
        return $orderCode;
    }
}
