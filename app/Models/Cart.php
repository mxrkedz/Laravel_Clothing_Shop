<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'carts';
    protected $fillable = [
        'user_id',
        'item_id',
        'quantity'
    ];

    public function items()
    {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }

}
