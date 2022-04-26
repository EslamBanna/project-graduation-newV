<?php

namespace App\Models\Needer;

use App\Models\Common\ToBeApply;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThingsToBeDone extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'type_of_service', 'from_place', 'to_place', 'attach', 'opposite', 'from_date', 'to_date', 'note'];

    // public function getAttachAttribute($value)
    // {
    //     $actual_link = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
    //     return ($value == null ? '' : $actual_link . 'images/toBeDone/' . $value);
    // }

    public function supportApllyers()
    {
        return $this->hasMany(ToBeApply::class, 'post_id', 'id')->where('type', 'help');
    }

    public function needer(){
        return $this->belongsTo(User::class,'user_id', 'id');
    }

    public static function boot()
    {
        parent::boot();
        self::deleting(function ($need) {
            $need->supportApllyers()->each(function ($support) {
                $support->delete();
            });
        });
    }
}
