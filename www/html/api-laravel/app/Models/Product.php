<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 *
 * @property int $id
 * @property string $category_name
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 */
class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_category_id',
        'product_name',
        'product_value'
    ];

    public function ProductCategory()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }
}
