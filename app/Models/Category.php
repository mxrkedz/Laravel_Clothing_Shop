<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'category_name',
        'img_path',
    ];

    public function items()
    {
        return $this->hasMany(Item::class, 'cat_id');
    }
}
