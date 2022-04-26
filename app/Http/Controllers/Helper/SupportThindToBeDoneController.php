<?php

namespace App\Http\Controllers\Helper;

use App\Http\Controllers\Controller;
use App\Models\Common\ToBeApply;
use App\Models\Helper\SupportThingsToBeDone;
use App\Models\Needer\ThingsToBeDone;
use Illuminate\Http\Request;

class SupportThindToBeDoneController extends Controller
{
    public function insertSupportThingToBeDone(Request $request)
    {
        try {
            SupportThingsToBeDone::create([
                'user_id' => Auth()->user()->id ?? $request->user_id,
                'from_place' => $request->from_place,
                'to_place' => $request->to_place,
                'date' => $request->date,
                'note' => $request->note
            ]);
            return $this->returnSuccessMessage('inserted successfully');
        } catch (\Exception $e) {
            return $this->returnError(201, $e->getMessage());
        }
    }

    public function getAllThingsToBeDone(Request $request)
    {
        try {
            $things_to_be_done = ThingsToBeDone::whereDoesntHave('supportApllyers', function ($q) use ($request) {
                $q->where('user_id', Auth()->user()->id ?? $request->user_id);
            })
            ->where('user_id', '!=', Auth()->user()->id ?? $request->user_id)
                ->with(['needer' => function ($q) {
                    $q->select('id', 'name', 'phone');
                }])
                ->latest()
                ->get();
            return $this->returnData('data', $things_to_be_done);
        } catch (\Exception $e) {
            return $this->returnError(201, $e->getMessage());
        }
    }

    public function applyToThingToDone(Request $request)
    {
        try {
            if (!$request->has('post_id')) {
                return $this->returnError(202, 'you must enter the support_id');
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

    public function getSupportAllMyThingsToBeDone(Request $request)
    {
        try {
            $supports_thing_to_be_done = SupportThingsToBeDone::where('user_id', Auth()->user()->id ?? $request->user_id)
                ->latest()
                ->get();
            return $this->returnData('data', $supports_thing_to_be_done);
        } catch (\Exception $e) {
            return $this->returnError(201, $e->getMessage());
        }
    }

    public function deleteSupportThingToBeDone(Request $request)
    {
        try {
            if (!$request->has('post_id')) {
                return $this->returnError(202, 'you must enter the post_id');
            }
            $support_thing_to_be_done = SupportThingsToBeDone::find($request->post_id);
            if (!$support_thing_to_be_done) {
                return $this->returnError(203, 'you enterd invalid post');
            }
            $support_thing_to_be_done->delete();
            return $this->returnSuccessMessage('deleted suuccessfully');
        } catch (\Exception $e) {
            return $this->returnError(201, $e->getMessage());
        }
    }

    public function getSupportThingToBeDone(Request $request)
    {
        try {
            if (!$request->has('post_id')) {
                return $this->returnError(202, 'you must enter the post_id');
            }
            $support_thing_to_be_done = SupportThingsToBeDone::find($request->post_id);
            if (!$support_thing_to_be_done) {
                return $this->returnError(203, 'you enterd invalid post');
            }
            return $this->returnData('data', $support_thing_to_be_done);
        } catch (\Exception $e) {
            return $this->returnError(201, $e->getMessage());
        }
    }

    public function updateSupportThingToBeDone(Request $request)
    {
        try {
            if (!$request->has('post_id')) {
                return $this->returnError(202, 'you must enter the post_id');
            }
            $support_thing_to_be_done = SupportThingsToBeDone::find($request->post_id);
            if (!$support_thing_to_be_done) {
                return $this->returnError(203, 'you enterd invalid post');
            }
            $support_thing_to_be_done->update([
                'from_place' => $request->from_place ?? $support_thing_to_be_done->from_place,
                'to_place' => $request->to_place ?? $support_thing_to_be_done->to_place,
                'date' => $request->date ?? $support_thing_to_be_done->date,
                'note' => $request->note ?? $support_thing_to_be_done->note
            ]);
            return $this->returnSuccessMessage('updated successfully');
        } catch (\Exception $e) {
            return $this->returnError(201, $e->getMessage());
        }
    }

    public function getSupportApplyersThingToBeDone(Request $request)
    {
        try {
            if (!$request->has('post_id')) {
                return $this->returnError(202, 'you must enter the post_id');
            }
            $support_thing_to_be_done = SupportThingsToBeDone::find($request->post_id);
            if (!$support_thing_to_be_done) {
                return $this->returnError(203, 'you enterd invalid post');
            }
            $needApllyers = ToBeApply::with(['user' => function ($q) {
                $q->select('id', 'name', 'phone');
            }])->where('post_id', $request->post_id)
                ->where('type', 'need')
                ->where('accept', 'wait list')
                ->select('id', 'user_id')
                ->latest()
                ->get();
            return $this->returnData('data', $needApllyers);
        } catch (\Exception $e) {
            return $this->returnError(201, $e->getMessage());
        }
    }
    public function responseToApplyersSupportThingToBeDone(Request $request)
    {
        try {
            if (!$request->has('response')) {
                return $this->returnError(202, 'you must enter the response');
            }
            if (!$request->has('needer_post_id')) {
                return $this->returnError(203, 'you must enter the needer_post_id');
            }
            $to_be_apply = ToBeApply::find($request->needer_post_id);
            if (!$to_be_apply) {
                return $this->returnError(204, 'this is invalid needer post');
            }
            $to_be_apply->update([
                'accept' => $request->response
            ]);
            return $this->returnSuccessMessage('success');
        } catch (\Exception $e) {
            return $this->returnError(201, $e->getMessage());
        }
    }

    public function getMatchesToSupportToBeDone(Request $request)
    {
        try {
            if (!$request->has('post_id')) {
                return $this->returnError(202, 'the post_id filed is required');
            }
            $suport_thing = SupportThingsToBeDone::find($request->post_id);
            if (!$suport_thing) {
                return $this->returnError(203, 'this post is not exist');
            }
            $things_to_be_posts = ThingsToBeDone::whereDoesntHave('supportApllyers', function ($q) use ($request) {
                $q->where('user_id', Auth()->user()->id ?? $request->user_id);
            })->with('needer:id,name,phone,main_address')
                ->where('from_place', 'like', '%' . $suport_thing['from_place'] . '%')
                ->where('to_place', 'like', '%' . $suport_thing['to_place'] . '%')
                ->where('from_date', '<=', $suport_thing['date'])
                ->where('to_date', '>=', $suport_thing['date'])
                ->latest()
                ->get();
            return $this->returnData('data', $things_to_be_posts);
        } catch (\Exception $e) {
            return $this->returnError(201, $e->getMessage());
        }
    }

    public function getAcceptanceToSupportToBeDone(Request $request)
    {
        try {
            if (!$request->has('post_id')) {
                return $this->returnError(202, 'the post_id filed is required');
            }
            $suport_thing = SupportThingsToBeDone::find($request->post_id);
            if (!$suport_thing) {
                return $this->returnError(203, 'this post is not exist');
            }
            $acceptances = ToBeApply::with('user:id,name,phone,main_address')
                ->where('post_id', $request->post_id)
                ->where('type', 'need')
                ->where('accept', 'yes')
                ->latest()
                ->get();
            return $this->returnData('data', $acceptances);
        } catch (\Exception $e) {
            return $this->returnError(201, $e->getMessage());
        }
    }
}
