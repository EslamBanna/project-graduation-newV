<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    use GeneralTrait;
    public function makeComment(Request $request)
    {
        try {
            $rules = [
                'post_id' => 'required',
                'post_type' => 'required|string'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $attach = "";
            if ($request->hasFile('attach')) {
                $attach = cloudinary()->upload($request->file('attach')->getRealPath())->getSecurePath();
            }
            Comment::create([
                'user_id' => Auth()->user()->id ?? $request->user_id,
                'post_id' => $request->post_id,
                'post_type' => $request->post_type,
                'comment' => $request->comment,
                'attach' => $attach
            ]);
            return $this->returnSuccessMessage('success');
        } catch (\Exception $e) {
            return $this->returnError('201', $e->getMessage());
        }
    }

    public function getComment(Request $request)
    {
        try {
            $rules = [
                'post_id' => 'required',
                'post_type' => 'required|string'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $comments = Comment::with('user:id,name,photo')
                ->where('post_id', $request->post_id)
                ->where('post_type', $request->post_type)
                ->get();
            return $this->returnData('data', $comments);
        } catch (\Exception $e) {
            return $this->returnError('201', $e->getMessage());
        }
    }
}
