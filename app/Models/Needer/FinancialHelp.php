<?php

namespace App\Models\Needer;

use App\Models\Helper\FinancialApply;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialHelp extends Model
{
    use HasFactory;

    protected $fillable = [
        'needer_id',
        'type_of_help',
        'specific_address',
        'value',
        'target_help',
        'another_user_name',
        'provide_help_way',
        'status',
        'attach',
        'long',
        'lat',
        'region'
    ];


    // public function getAttachAttribute($value)
    // {
    //     $actual_link = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
    //     return ($value == null ? '' : $actual_link . 'images/financial_help/' . $value);
    // }

    public function user()
    {
        return $this->belongsTo(User::class, 'needer_id', 'id');
    }

    public function applyers()
    {
        return $this->hasMany(FinancialApply::class, 'financial_post_id', 'id');
    }

    public static function boot()
    {
        parent::boot();
        self::deleting(function ($need) {
            $need->applyers()->each(function ($applyer) {
                $applyer->delete();
            });
        });
    }
}
