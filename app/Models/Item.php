<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    use Searchable;
    public function toSearchableArray()
    {
        // Define the searchable attributes for the model
        return [
            'id' => $this->id,
            'item_name' => $this->item_name,
        ];
    }

    protected $table = 'items';

    protected $fillable = [
        'item_name',
        'sellprice',
        'img_path',
        'sup_id',
        'cat_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'cat_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'sup_id');
    }
}
