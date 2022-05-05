<?php

namespace App\Http\Controllers\Helper;

use App\Http\Controllers\Controller;
use App\Models\Helper\FinancialApply;
use App\Models\Needer\FinancialHelp;
use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isNull;

class FinancialProvideController extends Controller
{
    use GeneralTrait;
    public function getAllFinancialNeed(Request $request)
    {
        try {
            $_all_financial_need = null;
            if ($request->has('user_id')) {
                $user_data = User::find($request->user_id);
                $region = $user_data['region'];
            } else {
                $region = Auth()->user()->region;
            }
            if ($request->has('type_of_help')) {
                if ($request->has('provide_help_way')) {
                    $_all_financial_need = FinancialHelp::whereDoesntHave('applyers', function ($q) use ($request) {
                        $q->where('helper_id', Auth()->user()->id ?? $request->user_id);
                    })
                        ->where('status', 0)
                        ->where('type_of_help', $request->type_of_help)
                        ->where('provide_help_way', $request->provide_help_way)
                        ->where('needer_id', '!=', Auth()->user()->id ?? $request->user_id)
                        // ->where('region', $region)
                        ->latest()
                        ->get();
                } else {
                    $_all_financial_need = FinancialHelp::whereDoesntHave('applyers', function ($q) use ($request) {
                        $q->where('helper_id', Auth()->user()->id ?? $request->user_id);
                    })
                        ->where('status', 0)
                        ->where('type_of_help', $request->type_of_help)
                        ->where('needer_id', '!=', Auth()->user()->id ?? $request->user_id)
                        // ->where('region', $region)
                        ->latest()
                        ->get();
                }
            } elseif ($request->has('provide_help_way')) {
                $_all_financial_need = FinancialHelp::whereDoesntHave('applyers', function ($q) use ($request) {
                    $q->where('helper_id', Auth()->user()->id ?? $request->user_id);
                })->where('status', 0)
                    ->where('provide_help_way', $request->provide_help_way)
                    ->where('needer_id', '!=', Auth()->user()->id ?? $request->user_id)
                    // ->where('region', $region)
                    ->latest()
                    ->get();
            } else {
                $_all_financial_need = FinancialHelp::whereDoesntHave('applyers', function ($q) use ($request) {
                    $q->where('helper_id', Auth()->user()->id ?? $request->user_id);
                })->where('status', 0)
                    ->where('needer_id', '!=', Auth()->user()->id ?? $request->user_id)
                    // ->where('region', $region)
                    ->latest()
                    ->get();
            }
            return $this->returnData('data', $_all_financial_need);
        } catch (\Exception $e) {
            return $this->returnError(201, $e->getMessage());
        }
    }

    public function provideFinancialHelp(Request $request)
    {
        try {
            if (!$request->has('financial_post_id')) {
                return $this->returnError(202, 'financial_post_id field is required');
            }
            FinancialApply::create([
                'financial_post_id' => $request->financial_post_id,
                'helper_id' => Auth()->user()->id ?? $request->user_id,
            ]);
            return $this->returnSuccessMessage('success');
        } catch (\Exception $e) {
            return $this->returnError(201, $e->getMessage());
        }
    }

    public function getAllMyProvideFinancialHelps(Request $request)
    {
        try {
            $helped_posts = FinancialApply::with('post')
                ->where('helper_id', Auth()->user()->id ?? $request->user_id)
                ->latest()
                ->get();
            return $this->returnData('data', $helped_posts);
        } catch (\Exception $e) {
            return $this->returnError(201, $e->getMessage());
        }
    }

    public function deleteAllMyProvideFinancialHelp(Request $request)
    {
        try {
            if (!$request->has('apply_id')) {
                return $this->returnError(202, 'apply_id is required');
            }
            $apply_post = FinancialApply::find($request->apply_id);
            if (!$apply_post) {
                return $this->returnError(202, 'this apply post is not exist');
            }
            $apply_post->delete();
            return $this->returnSuccessMessage('success');
        } catch (\Exception $e) {
            return $this->returnError(201, $e->getMessage());
        }
    }
}
