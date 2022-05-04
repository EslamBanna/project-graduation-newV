<?php

namespace App\Http\Controllers\Helper;

use App\Http\Controllers\Controller;
use App\Models\Common\JobApply;
use App\Models\Helper\ProvideJop;
use App\Models\Needer\RequestJop;
use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;

class ProvideJobContoller extends Controller
{
    use GeneralTrait;
    public function createProvideJopPost(Request $request)
    {
        try {
            $attach = '';
            if ($request->hasFile('attach')) {
                $attach = cloudinary()->upload($request->file('attach')->getRealPath())->getSecurePath();
                // $attach  = $this->saveImage($request->attach, 'provide_job');
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
            ProvideJop::create([
                'user_id' => Auth()->user()->id ?? $request->user_id,
                'required_qualification' => $request->required_qualification,
                'required_skills' => $request->required_skills,
                'required_certificates' => $request->required_certificates,
                'attach' => $attach,
                'long' => Auth()->user()->long ?? $long,
                'lat' => Auth()->user()->long ?? $lat,
                'region' => Auth()->user()->long ?? $region
            ]);
            return $this->returnSuccessMessage('success');
        } catch (\Exception $e) {
            return $this->returnError('201', $e->getMessage());
        }
    }

    public function getNeedJobs()
    {
        try {
            $need_jobs = RequestJop::latest()->get();
            return $this->returnData('data', $need_jobs);
        } catch (\Exception $e) {
            return $this->returnError('201', $e->getMessage());
        }
    }

    public function getAllMyProvideJopPosts(Request $request)
    {
        try {
            $provied_jobs = ProvideJop::where('user_id', Auth()->user()->id ?? $request->user_id)->latest()->get();
            return $this->returnData('data', $provied_jobs);
        } catch (\Exception $e) {
            return $this->returnError('201', $e->getMessage());
        }
    }

    public function getProvideJopApplyers(Request $request)
    {
        try {
            if (!$request->has('job_id')) {
                return $this->returnError('202', 'job_id is required');
            }
            $applyers = JobApply::with(['user' => function ($q) {
                $q->select('id', 'name', 'phone', 'main_address');
            }])->select('id', 'user_id')
                ->where('job_id', $request->job_id)
                ->where('response', 'wait_list')
                ->latest()
                ->get();
            return $this->returnData('data', $applyers);
        } catch (\Exception $e) {
            return $this->returnError('201', $e->getMessage());
        }
    }
    public function responseProvideJopApplyer(Request $request)
    {
        try {
            if (!$request->has('apply_post_id') || !$request->has('response')) {
                return $this->returnError(202, 'the apply_post_id field is required');
            }
            $jopApply = JobApply::find($request->apply_post_id);
            if (!$jopApply) {
                return $this->returnError(203, 'thos job apply does not exist');
            }
            $jopApply->update([
                'response' => ($request->response == "yes" ? 'accept' : 'not_accepted')
            ]);
            return $this->returnSuccessMessage('success');
        } catch (\Exception $e) {
            return $this->returnError('201', $e->getMessage());
        }
    }

    public function deleteProvideJob(Request $request)
    {
        try {
            if (!$request->has('job_id')) {
                return $this->returnError('202', 'fail');
            }
            $job_post = ProvideJop::find($request->job_id);
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
    public function updateProvideJob(Request $request)
    {
        try {
            if (!$request->has('job_id')) {
                return $this->returnError('202', 'fail');
            }
            $job_post = ProvideJop::find($request->job_id);
            if (!$job_post) {
                return $this->returnError('203', 'fail');
            }
            // if ($job_post->user_id != Auth()->user()->id) {
            //     return $this->returnError('204', 'fail');
            // }
            $attach =  $job_post->attach;
            if ($request->hasFile('attach')) {
                $attach = cloudinary()->upload($request->file('attach')->getRealPath())->getSecurePath();
                // $attach  = $this->saveImage($request->attach, 'provide_job');
            }
            $job_post->update([
                'required_qualification' => $request->required_qualification ?? $job_post->required_qualification,
                'required_skills' => $request->required_skills ?? $job_post->required_skills,
                'required_certificates' => $request->required_certificates ?? $job_post->required_certificates,
                'attach' => $attach
            ]);
            return $this->returnSuccessMessage('success');
        } catch (\Exception $e) {
            return $this->returnError('201', $e->getMessage());
        }
    }

    public function getOneProvideJob(Request $request)
    {
        try {
            if (!$request->has('job_id')) {
                return $this->returnError('202', 'fail');
            }

            $provide_job = ProvideJop::find($request->job_id);
            if (!$provide_job) {
                return $this->returnError('203', 'fail');
            }
            // if ($provide_job->user_id != Auth()->user()->id) {
            //     return $this->returnError('204', 'fail');
            // }
            return $this->returnData('data', $provide_job);
        } catch (\Exception $e) {
            return $this->returnError('201', $e->getMessage());
        }
    }

    public function getMatchesForProvideJob(Request $request)
    {
        try {
            if (!$request->has('post_id')) {
                return $this->returnError(202, 'the post_id field is required');
            }
            $provide_job = ProvideJop::find($request->post_id);
            if (!$provide_job) {
                return $this->returnError(203, 'this provide job post is not exist');
            }
            $request_jobs = RequestJop::with('user:id,name,phone,main_address')
                ->where('qualification', 'like', '%' . $provide_job['required_qualification'] . '%')
                ->where('skills', 'like', '%' . $provide_job['required_skills'] . '%')
                ->where('certificates', 'like', '%' . $provide_job['required_certificates'] . '%')
                ->latest()
                ->get();
            return $this->returnData('data', $request_jobs);
        } catch (\Exception $e) {
            return $this->returnError('201', $e->getMessage());
        }
    }

    public function getAcceptanceForProvideJob(Request $request)
    {
        try {
            if (!$request->has('post_id')) {
                return $this->returnError(202, 'the post_id field is required');
            }
            $provide_job = ProvideJop::find($request->post_id);
            if (!$provide_job) {
                return $this->returnError(203, 'this provide job post is not exist');
            }
            $acceptances = JobApply::with('user:id,name,phone,main_address')
                ->where('job_id', $request->post_id)
                ->where('response', 'accept')
                ->latest()
                ->get();
            return $this->returnData('data', $acceptances);
        } catch (\Exception $e) {
            return $this->returnError('201', $e->getMessage());
        }
    }
}
