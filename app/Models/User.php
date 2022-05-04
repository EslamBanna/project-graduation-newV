<?php

namespace App\Models;

use App\Models\Common\JobApply;
use App\Models\Common\ToBeApply;
use App\Models\Helper\FinancialApply;
use App\Models\Helper\FoundObject;
use App\Models\Helper\ProvideJop;
use App\Models\Helper\SupportThingsToBeDone;
use App\Models\Needer\FinancialHelp;
use App\Models\Needer\LostObject;
use App\Models\Needer\Post;
use App\Models\Needer\RequestJop;
use App\Models\Needer\ThingsToBeDone;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends  Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'date_of_birth',
        'id_number',
        'job',
        'gender',
        'main_address',
        'id_photo',
        'photo',
        'long',
        'lat',
        'region'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    // public function getPhotoAttribute($value)
    // {
    //     $actual_link = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
    //     return ($value == null ? '' : $actual_link . 'images/users/' . $value);
    // }

    // public function getIdPhotoAttribute($value)
    // {
    //     $actual_link = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
    //     return ($value == null ? '' : $actual_link . 'images/id_photos/' . $value);
    // }


    ############# Relations #############
    public function lostes()
    {
        return $this->hasMany(LostObject::class, 'needer_id', 'id');
    }

    public function foundest()
    {
        return $this->hasMany(FoundObject::class, 'helper_id', 'id');
    }
    // ####
    public function financialHelp()
    {
        return $this->hasMany(FinancialHelp::class, 'needer_id', 'id');
    }
    public function financialApplies()
    {
        return $this->hasMany(FinancialApply::class, 'helper_id', 'id');
    }
    // ####
    public function jobApplies()
    {
        return $this->hasMany(JobApply::class, 'user_id', 'id');
    }
    public function provideJops()
    {
        return $this->hasMany(ProvideJop::class, 'user_id', 'id');
    }
    public function requestJops()
    {
        return $this->hasMany(RequestJop::class, 'user_id', 'id');
    }
    // ####
    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id', 'id');
    }
    // ####
    public function supportThingsToBeDones()
    {
        return $this->hasMany(SupportThingsToBeDone::class, 'user_id', 'id');
    }
    public function thingsToBeDones()
    {
        return $this->hasMany(ThingsToBeDone::class, 'user_id', 'id');
    }
    public function toBeApplies()
    {
        return $this->hasMany(ToBeApply::class, 'user_id', 'id');
    }
    // ###
    // boot #####################
    public static function boot()
    {
        parent::boot();
        self::deleting(function ($need) {
            $need->lostes()->each(function ($support) {
                $support->delete();
            });
            $need->foundest()->each(function ($support) {
                $support->delete();
            });
            $need->financialHelp()->each(function ($support) {
                $support->delete();
            });
            $need->financialApplies()->each(function ($support) {
                $support->delete();
            });
            $need->jobApplies()->each(function ($support) {
                $support->delete();
            });
            $need->provideJops()->each(function ($support) {
                $support->delete();
            });
            $need->requestJops()->each(function ($support) {
                $support->delete();
            });
            $need->posts()->each(function ($support) {
                $support->delete();
            });
            $need->supportThingsToBeDones()->each(function ($support) {
                $support->delete();
            });
            $need->thingsToBeDones()->each(function ($support) {
                $support->delete();
            });
            $need->toBeApplies()->each(function ($support) {
                $support->delete();
            });
        });
    }
}
