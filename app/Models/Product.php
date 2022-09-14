<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title', 'category_id', 'price', 'document_path',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
}
