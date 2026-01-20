<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'condition_id',
        'name',
        'price',
        'description',
        'image_path',
        'brand_name',
        'is_sold',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }
    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     *
     * * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<\App\Models\User>
     */
    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes', 'product_id', 'user_id')->withTimestamps();
    }

    public function scopeKeywordSearch($query, $keyword)
    {
        if (!empty($keyword)) {
            $query->where('name', 'like', "%{$keyword}%");
        }
        return $query;
    }

    public function getImageUrlAttribute()
    {
        $path = $this->image_path;

        if (!$path) {
            return asset('images/no-image.png'); // 画像がない時の保険
        }

        if (str_starts_with($path, 'http')) {
            return $path;
        }

        if (str_starts_with($path, 'images/sample/')) {
            return asset($path);
        }

        return asset('storage/' . $path);
    }
}
