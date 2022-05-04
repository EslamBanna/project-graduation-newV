<?php

namespace App\Http\Controllers\Needer;

use App\Http\Controllers\Controller;
use App\Models\Needer\LostObject;
use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

// use Validator;

class LostController extends Controller
{
    use GeneralTrait;
    public function makeLost(Request $request)
    {
        try {
            $rules = [
                'type' => 'required',
                'expected_lost_date' => 'required',
                'expected_lost_place' => 'required',
                'description' => 'required'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            $attach = null;
            if ($request->hasFile('attach')) {
                $attach = cloudinary()->upload($request->file('attach')->getRealPath())->getSecurePath();
                // $attach  = $this->saveImage($request->attach, 'lostes');
            }
            $long = null;
            $lat = null;
            $region = null;
            if ($request->has('user_id')) {
                $user_data = User::find($request->user_id);
                $long = $user_data['long'];
                $lat = $user_data['lat'];
                $region = $user_data['region'];
            }
            LostObject::create([
                'needer_id' => auth()->user()->id ?? $request->user_id,
                'type' => $request->type,
                'expected_lost_date' => $request->expected_lost_date,
                'expected_lost_place' => $request->expected_lost_place,
                'description' => $request->description,
                'attach' => $attach,
                'first_color' => $request->first_color,
                'second_color' => $request->second_color,
                'brand' => $request->brand,
                'category' => $request->category,
                'long' => Auth()->user()->long ?? $long,
                'lat' => Auth()->user()->long ?? $lat,
                'region' => Auth()->user()->long ?? $region
            ]);
            return $this->returnSuccessMessage('success');
        } catch (\Exception $e) {
            return $this->returnError('201', $e->getMessage());
        }
    }

    public function getAllMyLostes(Request $request)
    {
        try {
            $lostes = LostObject::where('needer_id', Auth()->user()->id ?? $request->user_id)
            ->latest()
            ->get();
            return $this->returnData('data', $lostes);
        } catch (\Exception $e) {
            return $this->returnError('201', $e->getMessage());
        }
    }

    public function getOneLost(Request $request)
    {
        try {
            if (!$request->has('lost_id')) {
                return $this->returnError(202, 'lost_id field is required');
            }
            $lost = LostObject::find($request->lost_id);
            if (!$lost) {
                return $this->returnError(203, 'this is not exist lost');
            }
            return $this->returnData('data', $lost);
        } catch (\Exception $e) {
            return $this->returnError('201', $e->getMessage());
        }
    }

    public function updateLost(Request $request)
    {
        try {
            if (!$request->has('lost_id')) {
                return $this->returnError(202, 'lost_id field is required');
            }
            $lost = LostObject::find($request->lost_id);
            if (!$lost) {
                return $this->returnError(203, 'this is not exist lost');
            }
            $attach = "";
            if ($request->hasFile('attach')) {
                $attach = cloudinary()->upload($request->file('attach')->getRealPath())->getSecurePath();
                // $attach = $this->saveImage($request->attach, 'lostes');
            } else {
                // $photo_len = strlen((isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/images/lostes/');
                // $attach = substr($lost->attach, $photo_len);
                $attach = $lost->attach;
            }
            $lost->update([
                'type' => $request->type ?? $lost->type,
                'expected_lost_date' => $request->expected_lost_date ?? $lost->expected_lost_date,
                'expected_lost_place' => $request->expected_lost_place ?? $lost->expected_lost_place,
                'description' => $request->description ?? $lost->description,
                'attach' => $attach,
                'first_color' => $request->first_color ?? $lost->first_color,
                'second_color' => $request->second_color ?? $lost->second_color,
                'brand' => $request->brand ?? $lost->brand,
                'category' => $request->category ?? $lost->category
            ]);
            return $this->returnSuccessMessage('success');
        } catch (\Exception $e) {
            return $this->returnError('201', $e->getMessage());
        }
    }

    public function deleteLost(Request $request)
    {
        try {
            if (!$request->has('lost_id')) {
                return $this->returnError(202, 'lost_id field is required');
            }
            $lost = LostObject::find($request->lost_id);
            if (!$lost) {
                return $this->returnError(203, 'this is not exist lost');
            }
            $lost->delete();
            return $this->returnSuccessMessage('success');
        } catch (\Exception $e) {
            return $this->returnError('201', $e->getMessage());
        }
    }
}
