<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Books extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'author',
        'category_id',
        'description',
        'image',
    ];

    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }
}
