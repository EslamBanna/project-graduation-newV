<?php

namespace App\Models\Common;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToBeApply extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'type', 'post_id', 'accept'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
