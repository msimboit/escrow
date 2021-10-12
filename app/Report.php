<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'transaction_id',
        'transaction_initiation_time',
        'transaction_completion_time',
        'tariff',
        'goods_price',
        'buyer_sent_amount',
        'buyer_sent_mpesa_code',
        'sms_count',
        'vendor_received_amount',
        'buyer_received_amount',
        'escrow_sent_mpesa_code',
        'mpesa_charge',
        'escrow_fee',
        'transaction_status',
    ];

}
