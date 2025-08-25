<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CarGallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_id',
        'image_path',
        'alt_text',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    /**
     * Relation avec la voiture
     */
    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    /**
     * Obtient l'URL complète de l'image
     */
    public function getImageUrl(): string
    {
        if ($this->image_path && Storage::disk('public')->exists($this->image_path)) {
            return asset('storage/' . $this->image_path);
        }
        
        return asset('images/default-car.jpg');
    }

    /**
     * Scope pour ordonner par sort_order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}