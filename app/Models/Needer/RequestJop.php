<?php

namespace App\Models\Needer;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestJop extends Model
{
    use HasFactory;
    protected $table = 'request_jops';
    protected $fillable = [
        'user_id',
        'qualification',
        'skills',
        'certificates',
        'summary_about_you',
        'attach'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    // public function getAttachAttribute($value)
    // {
    //     $actual_link = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
    //     return ($value == null ? '' : $actual_link . 'images/request_job/' . $value);
    // }
    public function getQualificationAttribute($value)
    {
        return $value ?? "";
    }
    public function getSkillsAttribute($value)
    {
        return $value ?? "";
    }
    public function getCertificatesAttribute($value)
    {
        return $value ?? "";
    }
    public function getSummaryAboutYouAttribute($value)
    {
        return $value ?? "";
    }
}
