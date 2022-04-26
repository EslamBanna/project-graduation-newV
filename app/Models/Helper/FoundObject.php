<?php

namespace App\Models\Helper;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoundObject extends Model
{
    use HasFactory;

    protected $table = 'found_objects';
    protected $fillable = [
        'helper_id',
        'type',
        'found_date',
        'found_place',
        'description',
        'attach',
        'first_color',
        'second_color',
        'brand',
        'category'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'helper_id', 'id');
    }

    // public function getAttachAttribute($value)
    // {
    //     $actual_link = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
    //     return ($value == null ? '' : $actual_link . 'images/foundest/' . $value);
    // }

    public function getTypeAttribute($value)
    {
        return $value ?? "";
    }
    public function getFoundDateAttribute($value)
    {
        return $value ?? "";
    }
    public function getFoundPlaceAttribute($value)
    {
        return $value ?? "";
    }
    public function getDescriptionAttribute($value)
    {
        return $value ?? "";
    }
    public function getFirstColorAttribute($value)
    {
        return $value ?? "";
    }
    public function getSecondColorAttribute($value)
    {
        return $value ?? "";
    }
    public function getBrandAttribute($value)
    {
        return $value ?? "";
    }
    public function getCategoryAttribute($value)
    {
        return $value ?? "";
    }
}
