<?php

namespace App\Http\Controllers\Needer;

use App\Http\Controllers\Controller;
use App\Models\Common\JobApply;
use App\Models\Helper\ProvideJop;
use App\Models\Needer\RequestJop;
use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NeedJobContoller extends Controller
{
    use GeneralTrait;
    public function createNeedJopPost(Request $request)
    {
        try {
            DB::beginTransaction();
            $attach = '';
            if ($request->hasFile('attach')) {
                $attach = cloudinary()->upload($request->file('attach')->getRealPath())->getSecurePath();
                // $attach  = $this->saveImage($request->attach, 'request_job');
            }
            RequestJop::where('user_id', Auth()->user()->id ?? $request->user_id)->delete();
            $long = null;
            $lat = null;
            $region = null;
            if ($request->has('user_id')) {
                $user_data = User::find($request->user_id);
                $long = $user_data['long'];
                $lat = $user_data['lat'];
                $region = $user_data['region'];
            }
            RequestJop::create([
                'user_id' => Auth()->user()->id ?? $request->user_id,
                'qualification' => $request->qualification,
                'skills' => $request->skills,
                'certificates' => $request->certificates,
                'summary_about_you' => $request->summary_about_you,
                'attach' => $attach,
                'long' => Auth()->user()->long ?? $long,
                'lat' => Auth()->user()->long ?? $lat,
                'region' => Auth()->user()->long ?? $region
            ]);
            DB::commit();
            return $this->returnSuccessMessage('success');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->returnError('201', $e->getMessage());
        }
    }

    public function getMyNeedJob(Request $request)
    {
        try {
            $need_job = RequestJop::where('user_id', Auth()->user()->id ?? $request->user_id)
                ->latest()
                ->first();
            return $this->returnData('data', $need_job);
        } catch (\Exception $e) {
            return $this->returnError('201',  $e->getMessage());
        }
    }
    public function getProvideJobs(Request $request)
    {
        try {
            $provide_jobs = ProvideJop::whereDoesntHave('applyers', function ($q) use ($request) {
                $q->where('user_id', Auth()->user()->id ?? $request->user_id);
            })
                ->latest()
                ->get();
            return $this->returnData('data', $provide_jobs);
        } catch (\Exception $e) {
            return $this->returnError('201',  $e->getMessage());
        }
    }

    public function applyToProvideJob(Request $request)
    {
        try {
            if (!$request->has('job_id')) {
                return $this->returnError('202', 'fail');
            }
            $job = ProvideJop::find($request->job_id);
            if (!$job) {
                return $this->returnError('203', 'fail');
            }
            JobApply::create([
                'user_id' => Auth()->user()->id ?? $request->user_id,
                'job_id' => $request->job_id
            ]);
            return $this->returnSuccessMessage('success');
        } catch (\Exception $e) {
            return $this->returnError('201', $e->getMessage());
        }
    }

    public function deleteNeedJob(Request $request)
    {
        try {
            if (!$request->has('job_id')) {
                return $this->returnError('202', 'fail');
            }
            $job_post = RequestJop::find($request->job_id);
            if (!$job_post) {
                return $this->returnError('203', 'fail');
            }

            // if ($job_post->user_id != Auth()->user()->id) {
            //     return $this->returnError('204', 'fail');
            // }
            $job_post->delete();
            return $this->returnSuccessMessage('success');
        } catch (\Exception $e) {
            return $this->returnError('201', $e->getMessage());
        }
    }

    public function updateNeedJob(Request $request)
    {
        try {
            if (!$request->has('job_id')) {
                return $this->returnError('202', 'fail');
            }
            $job_post = RequestJop::find($request->job_id);
            if (!$job_post) {
                return $this->returnError('203', 'fail');
            }
            // if ($job_post->user_id != Auth()->user()->id) {
            //     return $this->returnError('204', 'fail');
            // }
            $attach = $job_post->attach;
            if ($request->hasFile('attach')) {
                $attach = cloudinary()->upload($request->file('attach')->getRealPath())->getSecurePath();
                // $attach  = $this->saveImage($request->attach, 'request_job');
            }
            $job_post->update([
                'qualification' => $request->qualification ?? $job_post->qualification,
                'skills' => $request->skills ?? $job_post->skills,
                'certificates' => $request->certificates ?? $job_post->certificates,
                'summary_about_you' => $request->summary_about_you ?? $job_post->summary_about_you,
                'attach' => $attach
            ]);
            return $this->returnSuccessMessage('success');
        } catch (\Exception $e) {
            return $this->returnError('201', $e->getMessage());
        }
    }

    public function getMatchesForNeedJob(Request $request)
    {
        try {
            if (!$request->has('post_id')) {
                return $this->returnError(202, 'the post_id field is required');
            }
            $request_job = RequestJop::find($request->post_id);
            if (!$request_job) {
                return $this->returnError(203, 'this need job post is not exist');
            }
            $provide_jobs = ProvideJop::whereDoesntHave('applyers', function ($q) use ($request) {
                $q->where('user_id', Auth()->user()->id ?? $request->user_id);
            })
            ->with('user:id,name,phone,main_address')
                ->where('required_qualification', 'like', '%' . $request_job['qualification'] . '%')
                ->where('required_skills', 'like', '%' . $request_job['skills'] . '%')
                ->where('required_certificates', 'like', '%' . $request_job['certificates'] . '%')
                ->latest()
                ->get();
            return $this->returnData('data', $provide_jobs);
        } catch (\Exception $e) {
            return $this->returnError('201', $e->getMessage());
        }
    }


    public function getAllMyApplyingForProvideJobs(Request $request)
    {
        try {
            $posts = JobApply::with('job')
                ->where('user_id', Auth()->user()->id ?? $request->user_id)
                ->where('response', 'wait_list')
                ->latest()
                ->get();
            return $this->returnData('data', $posts);
        } catch (\Exception $e) {
            return $this->returnError('201', $e->getMessage());
        }
    }

    public function getAllAcceptMyApplyingForProvideJobs(Request $request)
    {
        try {
            $posts = JobApply::with('job')
                ->where('user_id', Auth()->user()->id ?? $request->user_id)
                ->where('response', 'accept')
                ->latest()
                ->get();
            return $this->returnData('data', $posts);
        } catch (\Exception $e) {
            return $this->returnError('201', $e->getMessage());
        }
    }
}
