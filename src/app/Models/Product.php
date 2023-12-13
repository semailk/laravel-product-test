<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $article
 * @property string $name
 * @property string $status
 * @property array $data
 * @property int $id
 */
class Product extends Model
{
    use HasFactory, SoftDeletes;

    public const PRODUCT_STATUS_AVAILABLE = 'available', PRODUCT_STATUS_UNAVAILABLE = 'unavailable';

    public const
        PRODUCT_ID = 'id',
        PRODUCT_CREATED_AT = 'created_at',
        PRODUCT_UPDATED_AT = 'updated_at',
        PRODUCT_ARTICLE = 'article',
        PRODUCT_NAME = 'name',
        PRODUCT_STATUS = 'status',
        PRODUCT_DATA = 'data';

    protected $fillable = [
        self::PRODUCT_ARTICLE,
        self::PRODUCT_NAME,
        self::PRODUCT_STATUS,
        self::PRODUCT_DATA
    ];

    protected $casts = [self::PRODUCT_DATA => 'json'];

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function canEditArticle($user)
    {
        if ($user->role === config('products.role')) {
            return true;
        }
        return false;
    }
}
