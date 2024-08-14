<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Post extends Model
{
    use HasFactory, HasTranslations;

    protected $table = 'posts';

    protected $primaryKey = 'id';

    protected $fillable = [
        'lang',
        'user_id',
        'name',
        'image',
        'summary',
        'description',
        'slug',
        'tag',
        'meta_title',
        'meta_keyword',
        'meta_description',
        'meta_robots',
        'rel',
        'target',
        'view',
        'status',
    ];

    public $translatable = [
        'name',
        'meta_title',
        'meta_keyword',
        'meta_description',
        'summary',
        'description',
    ];

    public function categories()
    {
        return $this->belongsToMany(PostCategory::class, 'post_category_relation', 'post_id', 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
