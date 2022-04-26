<?php

namespace App\Http\Controllers\Needer;

use App\Http\Controllers\Controller;
use App\Models\Helper\FinancialApply;
use App\Models\Needer\FinancialHelp;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FinancialHelpController extends Controller
{
    use GeneralTrait;
    public function insertNeedMoneyHelp(Request $request)
    {
        try {

            $v = Validator::make($request->all(), [
                'type_of_help' => 'required',
                'target_help' => 'required',
                'provide_help_way' => "required"
            ]);
            if ($v->fails()) {
                return $this->returnError(202, $v->errors());
            }
            $attach = "";
            if ($request->hasFile('attach')) {
                $attach = cloudinary()->upload($request->file('attach')->getRealPath())->getSecurePath();
                // $attach = $this->saveImage($request->attach, 'financial_help');
            }
            FinancialHelp::create([
                'needer_id' => Auth()->user()->id ?? $request->user_id,
                'type_of_help' => $request->type_of_help,
                'specific_address' => $request->specific_address,
                'value' => $request->value,
                'target_help' => $request->target_help,
                'another_user_name' => $request->another_user_name,
                'provide_help_way' => $request->provide_help_way,
                'attach' => $attach
            ]);
            return $this->returnSuccessMessage('success');
        } catch (\Exception $e) {
            return $this->returnError(201, $e->getMessage());
        }
    }

    public function getAllMyNeedMoneyPosts(Request $request)
    {
        try {
            $needs_money = FinancialHelp::where('needer_id', Auth()->user()->id ?? $request->user_id)
                ->latest()
                ->get();
            return $this->returnData('data', $needs_money);
        } catch (\Exception $e) {
            return $this->returnError(201, $e->getMessage());
        }
    }

    public function getOneNeedMoneyPost(Request $request)
    {
        try {
            if (!$request->has('post_id')) {
                return $this->returnError(202, 'post_id is required');
            }
            $need_post = FinancialHelp::find($request->post_id);
            if (!$need_post) {
                return $this->returnError(203, 'this post is not exist');
            }
            return $this->returnData('data', $need_post);
        } catch (\Exception $e) {
            return $this->returnError(201, $e->getMessage());
        }
    }

    public function updateNeedMoneyPost(Request $request)
    {
        try {
            if (!$request->has('post_id')) {
                return $this->returnError(202, 'post_id is required');
            }
            $need_post = FinancialHelp::find($request->post_id);
            if (!$need_post) {
                return $this->returnError(203, 'this post is not exist');
            }
            $attach = "";
            if ($request->hasFile('attach')) {
                $attach = cloudinary()->upload($request->file('attach')->getRealPath())->getSecurePath();
                // $attach = $this->saveImage($request->attach, 'financial_help');
            } else {
                // $photo_len = strlen((isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/images/financial_help/');
                // $attach = substr($need_post->attach, $photo_len);
                $attach = $need_post->attach;
            }
            $need_post->update([
                'type_of_help' => $request->type_of_help ?? $need_post->type_of_help,
                'specific_address' => $request->specific_address ?? $need_post->specific_address,
                'value' => $request->value ?? $need_post->value,
                'target_help' => $request->target_help ?? $need_post->target_help,
                'another_user_name' => $request->another_user_name ?? $need_post->another_user_name,
                'provide_help_way' => $request->provide_help_way ?? $need_post->provide_help_way,
                'attach' => $attach
            ]);
            return $this->returnSuccessMessage('success');
        } catch (\Exception $e) {
            return $this->returnError(201, $e->getMessage());
        }
    }

    public function deleteNeedMoneyPost(Request $request)
    {
        try {
            if (!$request->has('post_id')) {
                return $this->returnError(202, 'post_id is required');
            }
            $need_post = FinancialHelp::find($request->post_id);
            if (!$need_post) {
                return $this->returnError(203, 'this post is not exist');
            }
            $need_post->delete();
            return $this->returnSuccessMessage('success');
        } catch (\Exception $e) {
            return $this->returnError(201, $e->getMessage());
        }
    }

    public function getApplyersToNeedMoneyPost(Request $request)
    {
        try {
            if (!$request->has('post_id')) {
                return $this->returnError(202, 'post_id is required');
            }
            $applyers = FinancialApply::with(['helper' => function ($q) {
                $q->select('id', 'name', 'phone');
            }])->where('financial_post_id', $request->post_id)
                ->latest()
                ->get();
            return $this->returnData('data', $applyers);
        } catch (\Exception $e) {
            return $this->returnError(201, $e->getMessage());
        }
    }

    public function acceptApplyersToNeedMoneyPost(Request $request)
    {
        try {
            if (!$request->has('applyer_request_id')) {
                return $this->returnError(202, 'applyer_request_id is required');
            }
            $applyer_request = FinancialApply::find($request->applyer_request_id);
            if (!$applyer_request) {
                return $this->returnError(203, 'this applyer request is not existed');
            }
            $applyer_request->update([
                'status' => 1
            ]);
            $financial_post = FinancialHelp::where('id', $applyer_request['financial_post_id'])->first();
            $financial_post->update([
                'status' => 1
            ]);
            return $this->returnSuccessMessage('success');
        } catch (\Exception $e) {
            return $this->returnError(201, $e->getMessage());
        }
    }

    public function getAcceptApplyerToHelpMoneyPost(Request $request)
    {
        try {
            if (!$request->has('post_id')) {
                return $this->returnError(202, 'post_id is required');
            }
            $post = FinancialHelp::find($request->post_id);
            if (!$post) {
                return $this->returnError(203, 'the post is not exist');
            }
            $acceptances = FinancialApply::with('helper:id,name,phone,main_address')
                ->where('financial_post_id', $request->post_id)
                ->where('status', 1)
                ->latest()
                ->get();
            return $this->returnData('data', $acceptances);
        } catch (\Exception $e) {
            return $this->returnError(201, $e->getMessage());
        }
    }
}
