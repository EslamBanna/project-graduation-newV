<?php

namespace App\Models\Helper;

use App\Models\Common\ToBeApply;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportThingsToBeDone extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'from_place',
        'to_place',
        'date',
        'note',
        'long',
        'lat',
        'region'
    ];

    public function helper()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function applayers(){
        return $this->hasMany(ToBeApply::class,'post_id', 'id')->where('type', 'need');
    }

    public static function boot()
    {
        parent::boot();
        self::deleting(function ($help) {
            $help->applayers()->each(function ($support) {
                $support->delete();
            });
        });
    }
}
