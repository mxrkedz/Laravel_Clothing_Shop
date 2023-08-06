<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $table = 'stocks';

    protected $primaryKey = "id";
    public function item()
    {
        return $this->belongsTo(Item::class, 'id');
    }

    protected $fillable = [
        'quantity'
    ];

    
}
