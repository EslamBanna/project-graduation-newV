<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use App\Mail\ForgetPasswordMail;
use App\Models\PasswordReset;
use App\Models\User;
use App\Traits\GeneralTrait;
// use App\Traits\GeneralTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Validator;
// use Auth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, GeneralTrait;

    public function registeration(Request $request)
    {
        try {
            $rules = [
                'email' => 'required|email',
                'password' => 'required',
                'phone' => 'required',
                'name' => 'required',
                // 'date_of_birth' => 'required',
                'id_number' => 'required',
                // 'job' => 'required',
                // 'gender' => 'required|boolean',
                'main_address' => 'required',
                // 'id_photo' => 'required'
            ];
            $validator = FacadesValidator::make($request->all(), $rules);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            $photo = "";
            $id_photo = "";
            if ($request->hasFile('photo')) {
                // $photo  = $this->saveImage($request->photo, 'users');
                $photo = cloudinary()->upload($request->file('photo')->getRealPath())->getSecurePath();
            }

            if ($request->hasFile('id_photo')) {
                // $id_photo  = $this->saveImage($request->id_photo, 'id_photos');
                $id_photo = cloudinary()->upload($request->file('id_photo')->getRealPath())->getSecurePath();
            }
            User::create([
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'phone' => $request->phone,
                'name' => $request->name,
                'date_of_birth' => $request->date_of_birth,
                'id_number' => $request->id_number,
                'job' => $request->job,
                'gender' => $request->gender,
                'main_address' => $request->main_address,
                'id_photo' => $id_photo,
                'photo' => $photo
            ]);
            return $this->returnSuccessMessage('success');
        } catch (\Exception $e) {
            return $this->returnError('201', 'fail');
        }
    }

    public function login(Request $request)
    {
        try {
            $loginType = 'phone';
            $rules = [
                'phone' => 'required|exists:users,phone',
                'password' => 'required'
            ];
            if ($request->has('email')) {
                $loginType = 'email';
                $rules = [
                    'email' => 'required|email|exists:users,email',
                    'password' => 'required'
                ];
            }
            $validator = FacadesValidator::make($request->all(), $rules);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $cardintions = $request->only([$loginType, 'password']);
            $token = Auth::guard('api-user')->attempt($cardintions);
            if (!$token) {
                return $this->returnError('E001', 'fail');
            }
            $user = Auth::guard('api-user')->user();
            $user->token = $token;
            return $this->returnSuccessMessage($user);
        } catch (\Exception $e) {
            return $this->returnError('201', 'fail');
        }
    }


    public function me()
    {
        return response()->json(auth()->user());
    }

    public function getUserInfo(Request $request)
    {
        try {
            if (!$request->has('user_id')) {
                return $this->returnError(202, 'user_id filed is required');
            }
            $user = User::find($request->user_id);
            if (!$user) {
                return $this->returnError(203, 'user not founded');
            }
            return $this->returnData('data', $user);
        } catch (\Exception $e) {
            return $this->returnError('201', $e->getMessage());
        }
    }
    public function updateUserInfo(Request $request)
    {
        try {
            $user = User::find(Auth()->user()->id ?? $request->user_id);
            if (!$user) {
                return $this->returnError(202, 'this user is not existed');
            }
            $photo = "";
            if ($request->hasFile('photo')) {
                $photo = cloudinary()->upload($request->file('photo')->getRealPath())->getSecurePath();
                // $photo = $this->saveImage($request->photo, 'users');
            } else {
                // $photo_len = strlen((isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/images/users/');
                // $photo = substr($user->photo, $photo_len);
                $photo = $user->photo;
            }
            $password = $user->password;
            if ($request->has('password')) {
                $password = bcrypt($request->password);
            }
            $user->update([
                'email' => $request->email ?? $user->email,
                // 'password' => $password,
                'phone' => $request->phone ?? $user->phone,
                'name' => $request->name ?? $user->name,
                'date_of_birth' => $request->date_of_birth ?? $user->date_of_birth,
                'id_number' => $request->id_number ?? $user->id_number,
                'job' => $request->job ?? $user->job,
                'gender' => $request->gender ?? $user->gender,
                'main_address' => $request->main_address ?? $user->main_address,
                'id_photo' => $id_photo ?? $user->id_photo,
                'photo' => $photo
            ]);
            return $this->returnSuccessMessage('success');
        } catch (\Exception $e) {
            return $this->returnError('201', $e->getMessage());
        }
    }

    public function forgetPassword(Request $request)
    {
        try {
            $rules = [
                'email' => 'required|email'
            ];
            $validator = FacadesValidator::make($request->all(), $rules);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return $this->returnError(202, 'this email is invalid');
            }
            $token = Str::random(6);
            PasswordReset::create([
                'email' => $request->email,
                'token' => $token
            ]);
            Mail::to($request->email)->send(new ForgetPasswordMail($token, $user->name, $request->email));
            return $this->returnSuccessMessage('mail send successfully');
        } catch (\Exception $e) {
            return $this->returnError('201', $e->getMessage());
        }
    }

    public function changePasswordWithVerification(Request $request)
    {
        try {
            DB::beginTransaction();
            $rules = [
                'token' => 'required|min:5|max:6',
                'new_password' => "required|string"
            ];
            $validator = FacadesValidator::make($request->all(), $rules);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $reset_request = PasswordReset::where('token', $request->token)->latest()->first();
            if (!$reset_request) {
                return $this->returnError(202, 'this token is invalid');
            }
            $user = User::where('email', $reset_request['email'])->first();
            if (!$user) {
                return $this->returnError(203, 'this user is invalid');
            }
            $user->update([
                'password' => bcrypt($request->new_password)
            ]);
            $reset_request->delete();
            PasswordReset::where('email', $reset_request['email'])->delete();
            DB::commit();
            return $this->returnSuccessMessage('success');
        } catch (\Exception $e) {
            DB::rollback();
            return $this->returnError('201', $e->getMessage());
        }
    }

    public function contactUs(Request $request){
        try{
            $rules = [
                'email' => 'required|email',
                'message' => "required|string"
            ];
            $validator = FacadesValidator::make($request->all(), $rules);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            Mail::to(env('ADMIN_MAIL'))->send(new ContactMail($request->message, $request->email));
            return $this->returnSuccessMessage('success');
        } catch (\Exception $e) {
            return $this->returnError('201', $e->getMessage());
        }
    }
}
