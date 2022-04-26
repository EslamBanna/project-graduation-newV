<?php

namespace App\Models\Common;

use App\Models\Helper\ProvideJop;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class JobApply extends Model
{
    use HasFactory;
    protected $table = 'jop_applies';
    protected $fillable = [
        'user_id',
        'job_id',
        'response'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function job()
    {
        return $this->belongsTo(ProvideJop::class, 'job_id', 'id');
    }
}
