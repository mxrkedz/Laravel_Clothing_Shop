<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orderline extends Model
{
    use HasFactory;

    protected $table = "orderlines";
    protected $primaryKey = "id";
    public $timestamps = false;
    protected $fillable = [
        'quantity',
    ];
    public function order()
    {
        return $this->belongsTo(Order::class, 'orderinfo_id');
    }
    public function items()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
