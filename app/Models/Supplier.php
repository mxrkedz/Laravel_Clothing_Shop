<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'suppliers';

    protected $fillable = [
        'sup_name',
        'sup_contact',
        'sup_address',
        'sup_email',
        'img_path',
    ];
    public function items()
    {
        return $this->hasMany(Item::class, 'sup_id');
    }
}
