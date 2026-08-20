<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku',
        'name',
        'slug',
        'description',
        'category_id',
        'price',
        'compare_price',
        'cost',
        'stock',
        'stock_status',
        'image_principal',
        'is_featured',
        'is_active'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'compare_price' => 'decimal:2',
        'cost' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    // ========== RELACIONES ==========
    
    /**
     * Un producto pertenece a una categoría
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Un producto tiene muchas imágenes
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * Un producto tiene muchas variantes
     */
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    /**
     * Un producto tiene muchos atributos
     */
    public function attributeValues()
    {
        return $this->hasMany(ProductAttributeValue::class);
    }

    /**
     * Un producto tiene muchos items en pedidos
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}