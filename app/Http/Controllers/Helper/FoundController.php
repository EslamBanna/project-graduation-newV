<?php

namespace App\Http\Controllers\Helper;

use App\Http\Controllers\Controller;
use App\Models\Helper\FoundObject;
use App\Models\Needer\LostObject;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Validator;

// use Validator;

class FoundController extends Controller
{
    use GeneralTrait;
    public function makeFound(Request $request)
    {
        try {
            $rules = [
                'type' => 'required',
                'found_date' => 'required',
                'found_place' => 'required',
                'description' => 'required'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            $attach = "";
            if ($request->hasFile('attach')) {
                // $attach  = $this->saveImage($request->attach, 'foundest');
                $attach = cloudinary()->upload($request->file('attach')->getRealPath())->getSecurePath();
            }
            // return $attach;
            FoundObject::create([
                'helper_id' => auth()->user()->id ?? $request->user_id,
                'type' => $request->type,
                'found_date' => $request->found_date,
                'found_place' => $request->found_place,
                'description' => $request->description,
                'attach' => $attach,
                'first_color' => $request->first_color,
                'second_color' => $request->second_color,
                'brand' => $request->brand,
                'category' => $request->category
            ]);
            return $this->returnSuccessMessage('success');
        } catch (\Exception $e) {
            return $this->returnError('201', $e->getMessage());
        }
    }

    public function getAllMyFounds(Request $request)
    {
        try {
            $founds = FoundObject::where('helper_id', Auth()->user()->id ?? $request->user_id)->latest()->get();
            return $this->returnData('data', $founds);
        } catch (\Exception $e) {
            return $this->returnError('201', $e->getMessage());
        }
    }
    public function getoneFound(Request $request)
    {
        try {
            if (!$request->has('found_id')) {
                return $this->returnError(202, 'the found_id field is required');
            }
            $found = FoundObject::find($request->found_id);
            if (!$found) {
                return $this->returnError(203, 'this lost is not exist');
            }
            return $this->returnData('data', $found);
        } catch (\Exception $e) {
            return $this->returnError('201', $e->getMessage());
        }
    }

    public function updateFound(Request $request)
    {
        try {
            if (!$request->has('found_id')) {
                return $this->returnError(202, 'the found_id field is required');
            }
            $found = FoundObject::find($request->found_id);
            if (!$found) {
                return $this->returnError(203, 'this lost is not exist');
            }
            $attach = "";
            if ($request->hasFile('attach')) {
                $attach = cloudinary()->upload($request->file('attach')->getRealPath())->getSecurePath();
                // $attach = $this->saveImage($request->attach, 'lostes');
            } else {
                // $photo_len = strlen((isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/images/foundest/');
                // $attach = substr($found->attach, $photo_len);
                $attach = $found->attach;
            }
            $found->update([
                'type' => $request->type ?? $found->type,
                'found_date' => $request->found_date ?? $found->found_date,
                'found_place' => $request->found_place ?? $found->found_place,
                'description' => $request->description ?? $found->description,
                'attach' => $attach,
                'first_color' => $request->first_color ?? $found->first_color,
                'second_color' => $request->second_color ?? $found->second_color,
                'brand' => $request->brand ?? $found->brand,
                'category' => $request->category ?? $found->category
            ]);
            return $this->returnSuccessMessage('success');
        } catch (\Exception $e) {
            return $this->returnError('201', $e->getMessage());
        }
    }

    public function deleteFound(Request $request)
    {
        try {
            if (!$request->has('found_id')) {
                return $this->returnError(202, 'the found_id field is required');
            }
            $found = FoundObject::find($request->found_id);
            if (!$found) {
                return $this->returnError(203, 'this lost is not exist');
            }
            $found->delete();
            return $this->returnSuccessMessage('success');
        } catch (\Exception $e) {
            return $this->returnError('201', $e->getMessage());
        }
    }

    public function getMatchesForFound(Request $request)
    {
        try {
            if (!$request->has('post_id')) {
                return $this->returnError(202, 'the post_id field is required');
            }
            $found = FoundObject::find($request->post_id);
            if (!$found) {
                return $this->returnError(203, 'this lost is not exist');
            }
            $lostes = LostObject::with('user:id,name,phone,main_address')
                ->where('brand', 'like', '%' . $found['brand'] . '%')
                ->where('category', 'like', '%' . $found['category'] . '%')
                ->where('first_color', 'like', '%' . $found['first_color'] . '%')
                ->where('second_color', 'like', '%' . $found['second_color'] . '%')
                ->where('type', 'like', '%' . $found['type'] . '%')
                ->where('expected_lost_date', '<=', $found['found_date'])
                ->where('expected_lost_place', 'like', '%' . $found['found_place'] . '%')
                ->orWhere([
                    ['brand', 'like', '%' . $found['brand'] . '%'],
                    ['category', 'like', '%' . $found['category'] . '%'],
                    ['first_color', 'like', '%' . $found['first_color'] . '%'],
                    ['second_color', 'like', '%' . $found['second_color'] . '%'],
                    ['type', 'like', '%' . $found['type'] . '%'],
                    ['expected_lost_date', '<=', $found['found_date']],
                    ['expected_lost_place', 'like', '%' . $found['found_place'] . '%'],
                    ['description', 'like', '%' . $found['description'] . '%']
                ])
                ->latest()
                ->get();
            return $this->returnData('data', $lostes);
        } catch (\Exception $e) {
            return $this->returnError('201', $e->getMessage());
        }
    }
}
