<?php

namespace App\Models\Helper;

use App\Models\Common\JobApply;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProvideJop extends Model
{
    use HasFactory;
    protected $table = 'provide_jops';
    protected $fillable = [
        'user_id',
        'required_qualification',
        'required_skills',
        'required_certificates',
        'attach',
        'long',
        'lat',
        'region'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function applyers()
    {
        return $this->hasMany(JobApply::class, 'job_id', 'id');
    }
    public static function boot()
    {
        parent::boot();
        self::deleting(function ($need) {
            $need->applyers()->each(function ($support) {
                $support->delete();
            });
        });
    }
    // public function getAttachAttribute($value)
    // {
    //     $actual_link = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
    //     return ($value == null ? '' : $actual_link . 'images/provide_job/' . $value);
    // }
    public function getRequiredQualificationAttribute($value)
    {
        return $value ?? "";
    }
    public function getRequiredSkillsAttribute($value)
    {
        return $value ?? "";
    }
    public function getRequiredCertificatesAttribute($value)
    {
        return $value ?? "";
    }
}
