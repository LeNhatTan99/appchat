<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/** 
 * class Category 
 *  @property integer   $id
 *  @property string   $name
 *  @property integer   $parent_id
 *  @property timestamp   $created_at
 *  @property timestamp   $updated_at
 */

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'parent_id',
    ];

  /**
     *  get category parent
     */
    public function parentId()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     *  get category children
     */
    public function childrenId()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }


/**
 * Get all of the products for the Category
 *
 * @return \Illuminate\Database\Eloquent\Relations\HasMany
 */
public function products()
{
    return $this->hasMany(Product::class);
}
}


