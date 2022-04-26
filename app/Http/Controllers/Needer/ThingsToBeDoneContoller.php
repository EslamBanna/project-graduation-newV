<?php

namespace App\Http\Controllers\Needer;

use App\Http\Controllers\Controller;
use App\Models\Common\ToBeApply;
use App\Models\Helper\SupportThingsToBeDone;
use App\Models\Needer\ThingsToBeDone;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;

class ThingsToBeDoneContoller extends Controller
{
    use GeneralTrait;
    public function insertThingToBeDone(Request $request)
    {
        try {
            $attach = '';
            if ($request->hasFile('attach')) {
                $attach = cloudinary()->upload($request->file('attach')->getRealPath())->getSecurePath();
                // $attach = $this->saveImage($request->attach, 'toBeDone');
            }
            ThingsToBeDone::create([
                'user_id' => Auth()->user()->id ?? $request->user_id,
                'type_of_service' => $request->type_of_service,
                'from_place' => $request->from_place,
                'to_place' => $request->to_place,
                'attach' => $attach,
                'opposite' => $request->opposite,
                'from_date' => $request->from_date,
                'to_date' => $request->to_date,
                'note' => $request->note
            ]);
            return $this->returnSuccessMessage('inserted suuccessfully');
        } catch (\Exception $e) {
            return $this->returnError(201, $e->getMessage());
        }
    }

    public function getAllSupportsToBeDone(Request $request)
    {
        try {
            $supports = SupportThingsToBeDone::whereDoesntHave('applayers', function($q) use ($request){
                $q->where('user_id', Auth()->user()->id ?? $request->user_id);
            })
            ->with(['helper' => function ($q) {
                $q->select('id', 'name', 'phone');
            }])
                ->latest()
                ->get();
            return $this->returnData('data', $supports);
        } catch (\Exception $e) {
            return $this->returnError(201, $e->getMessage());
        }
    }

    public function applyToSupportThing(Request $request)
    {
        try {
            if (!$request->has('post_id')) {
                return $this->returnError(202, 'you must enter the post_id');
            }
            ToBeApply::create([
                'user_id' => Auth()->user()->id ?? $request->user_id,
                'type' => 'need',
                'post_id' => $request->post_id
            ]);
            return $this->returnSuccessMessage('inserted suuccessfully');
        } catch (\Exception $e) {
            return $this->returnError(201, $e->getMessage());
        }
    }

    public function getAllMyThingsToBeDone(Request $request)
    {
        try {
            $things_to_be_done = ThingsToBeDone::where('user_id', Auth()->user()->id ?? $request->user_id)->latest()->get();
            return $this->returnData('data', $things_to_be_done);
        } catch (\Exception $e) {
            return $this->returnError(201, $e->getMessage());
        }
    }

    public function deleteThingToBeDone(Request $request)
    {
        try {
            if (!$request->has('post_id')) {
                return $this->returnError(202, 'you must enter the post_id');
            }
            $thing_to_be_done = ThingsToBeDone::find($request->post_id);
            if (!$thing_to_be_done) {
                return $this->returnError(203, 'you enterd invalid post');
            }
            $thing_to_be_done->delete();
            return $this->returnSuccessMessage('deleted suuccessfully');
        } catch (\Exception $e) {
            return $this->returnError(201, $e->getMessage());
        }
    }

    public function getThingToBeDone(Request $request)
    {
        try {
            if (!$request->has('post_id')) {
                return $this->returnError(202, 'you must enter the post_id');
            }
            $thing_to_be_done = ThingsToBeDone::find($request->post_id);
            if (!$thing_to_be_done) {
                return $this->returnError(203, 'you enterd invalid post');
            }
            return $this->returnData('data', $thing_to_be_done);
        } catch (\Exception $e) {
            return $this->returnError(201, $e->getMessage());
        }
    }

    public function updateThingToBeDone(Request $request)
    {
        try {
            if (!$request->has('post_id')) {
                return $this->returnError(202, 'you must enter the post_id');
            }
            $thing_to_be_done = ThingsToBeDone::find($request->post_id);
            if (!$thing_to_be_done) {
                return $this->returnError(203, 'you enterd invalid post');
            }
            $attach = $thing_to_be_done->attach;
            if ($request->hasFile('attach')) {
                $attach = cloudinary()->upload($request->file('attach')->getRealPath())->getSecurePath();
            }
            $thing_to_be_done->update([
                'type_of_service' => $request->type_of_service ?? $thing_to_be_done->type_of_service,
                'from_place' => $request->from_place ?? $thing_to_be_done->from_place,
                'to_place' => $request->to_place ?? $thing_to_be_done->to_place,
                'opposite' => $request->opposite ?? $thing_to_be_done->opposite,
                'from_date' => $request->from_date ?? $thing_to_be_done->from_date,
                'to_date' => $request->to_date ?? $thing_to_be_done->to_date,
                'note' => $request->note ?? $thing_to_be_done->note,
                'attach' => $attach
            ]);
            return $this->returnSuccessMessage('updated suuccessfully');
        } catch (\Exception $e) {
            return $this->returnError(201, $e->getMessage());
        }
    }

    public function getApplyersThingToBeDone(Request $request)
    {
        try {
            if (!$request->has('post_id')) {
                return $this->returnError(202, 'you must enter the post_id');
            }
            $thing_to_be_done = ThingsToBeDone::find($request->post_id);
            if (!$thing_to_be_done) {
                return $this->returnError(203, 'you enterd invalid post');
            }
            $supportApllyers = ToBeApply::with(['user' => function ($q) {
                $q->select('id', 'name', 'phone');
            }])->where('post_id', $request->post_id)
                ->where('type', 'help')
                ->where('accept', 'wait list')
                ->select('id', 'user_id')
                ->latest()
                ->get();
            return $this->returnData('data', $supportApllyers);
        } catch (\Exception $e) {
            return $this->returnError(201, $e->getMessage());
        }
    }

    public function responseToApplyersThingToBeDone(Request $request)
    {
        try {
            if (!$request->has('response')) {
                return $this->returnError(202, 'you must enter the response');
            }
            if (!$request->has('applyer_post_id')) {
                return $this->returnError(203, 'you must enter the applyer_post_id');
            }
            $to_be_apply = ToBeApply::find($request->applyer_post_id);
            if (!$to_be_apply) {
                return $this->returnError(204, 'this is invalid applyer post');
            }
            $to_be_apply->update([
                'accept' => $request->response
            ]);
            return $this->returnSuccessMessage('success');
        } catch (\Exception $e) {
            return $this->returnError(201, $e->getMessage());
        }
    }

    public function getAcceptanceForThingToBeDone(Request $request)
    {
        try {
            if (!$request->has('post_id')) {
                return $this->returnError(202, 'the post_id filed is required');
            }
            $post = ThingsToBeDone::find($request->post_id);
            if (!$post) {
                return $this->returnError(203, 'this post is not exist');
            }
            $acceptances = ToBeApply::with('user:id,name,phone,main_address')
                ->where('post_id', $request->post_id)
                ->where('type', 'help')
                ->where('accept', 'yes')
                ->latest()
                ->get();
            return $this->returnData('data', $acceptances);
        } catch (\Exception $e) {
            return $this->returnError(201, $e->getMessage());
        }
    }

    public function getMatchesForThingToBeDone(Request $request)
    {
        try {
            if (!$request->has('post_id')) {
                return $this->returnError(202, 'the post_id filed is required');
            }
            $thing_to_be = ThingsToBeDone::find($request->post_id);
            if (!$thing_to_be) {
                return $this->returnError(203, 'this post is not exist');
            }
            $supplies_posts_to_be = SupportThingsToBeDone::with('helper:id,name,phone,main_address')
                ->where('from_place', 'like', '%' . $thing_to_be['from_place'] . '%')
                ->where('to_place', 'like', '%' . $thing_to_be['to_place'] . '%')
                ->where('date', '>=', $thing_to_be['from_date'])
                ->where('date', '<=', $thing_to_be['to_date'])
                ->latest()
                ->get();
            return $this->returnData('data', $supplies_posts_to_be);
        } catch (\Exception $e) {
            return $this->returnError(201, $e->getMessage());
        }
    }
}
