<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RejectDelivery extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'details', 'clientName', 'clientNumber', 'clientEmail', 'vendorName', 'vendorNumber', 'vendorEmail', 'orderId', 'orderdate', 'transdetail', 'quantity', 'subtotal', 'tariff', 'total', 'deliveryfee',
    ];
}
