<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = "orders";
    protected $primaryKey = "id";

    protected $fillable = [
        'fname',
        'lname',
        'email',
        'phone',
        'country',
        'postcode',
        'city',
        'province',
        'address1',
        'address2',
        'status',
        'message',
    ];

    public function shipper()
    {
        return $this->belongsTo(Shipper::class, 'ship_id', 'id');
    }
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'pm_id', 'id');
    }

}
