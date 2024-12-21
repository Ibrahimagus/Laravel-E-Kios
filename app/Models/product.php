<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Hasmany;
use Illuminate\Support\Str;



class product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'stock',
        'price',
        'is_active',
        'image',
        'barcode',
        'description',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(category::class);
    }

    public static function generateUniqueSlug(string $name): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        while (self::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? url('storage/'. $this->image) : null;
    }

    public function scopeSearch($query, $value)
    {
        $query->where("name", "like", "%{$value}%");
    }

    public function orderProducts()
    {
        return $this->hasmany(OrderProduct::class);
    }
}
