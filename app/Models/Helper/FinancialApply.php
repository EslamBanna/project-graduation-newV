<?php

namespace App\Models\Helper;

use App\Models\Needer\FinancialHelp;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialApply extends Model
{
    use HasFactory;
    protected $fillable = [
        'financial_post_id',
        'helper_id',
        'status'
    ];

    public function post()
    {
        return $this->belongsTo(FinancialHelp::class, 'financial_post_id');
    }

    public function helper()
    {
        return $this->belongsTo(User::class, 'helper_id');
    }
}
