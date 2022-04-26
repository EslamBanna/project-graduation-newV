<?php

namespace App\Models\Needer;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LostObject extends Model
{
    use HasFactory;

    protected $table = 'lost_objects';
    protected $fillable = [
        'needer_id',
        'type',
        'expected_lost_date',
        'expected_lost_place',
        'description',
        'attach',
        'first_color',
        'second_color',
        'brand',
        'category'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'needer_id', 'id');
    }
    // public function getAttachAttribute($value)
    // {
    //     $actual_link = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
    //     return ($value == null ? '' : $actual_link . 'images/lostes/' . $value);
    // }

    public function getTypeAttribute($value)
    {
        return $value ?? "";
    }
    public function getExpectedLostDateAttribute($value)
    {
        return $value ?? "";
    }
    public function getExpectedLostPlaceAttribute($value)
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
