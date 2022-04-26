<?php

namespace App\Http\Controllers;

use App\Models\Needer\Post;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;

class PostController extends Controller
{
    use GeneralTrait;
    public function insertPost(Request $request)
    {
        try {
            $attach = "";
            if ($request->hasFile('attach')) {
                $attach = cloudinary()->upload($request->file('attach')->getRealPath())->getSecurePath();
                // $attach = $this->saveImage($request->attach, 'posts');
            }
            Post::create([
                'user_id' => Auth()->user()->id ?? $request->user_id,
                'content' => $request->content,
                'post_type' => $request->post_type,
                'attach' => $attach
            ]);
            return $this->returnSuccessMessage('success');
        } catch (\Exception $e) {
            return $this->returnError(201, $e->getMessage());
        }
    }

    public function getAlltPosts()
    {
        try {
            $posts = Post::with(['user' => function ($q) {
                $q->select('id', 'name', 'photo');
            }])
                ->latest()
                ->get();
            return $this->returnData('data', $posts);
        } catch (\Exception $e) {
            return $this->returnError(201, $e->getMessage());
        }
    }

    public function getOnlyMytPosts(Request $request)
    {
        try {
            $my_posts = Post::where('user_id', Auth()->user()->id ?? $request->user_id)
                ->latest()
                ->get();
            return $this->returnData('data', $my_posts);
        } catch (\Exception $e) {
            return $this->returnError(201, $e->getMessage());
        }
    }

    public function getOnePost(Request $request)
    {
        try {
            if (!$request->has('post_id')) {
                return $this->returnError(202, 'post_id is required');
            }
            $post = Post::find($request->post_id);
            if (!$post) {
                return $this->returnError(203, 'this post is not exist');
            }
            return $this->returnData('data', $post);
        } catch (\Exception $e) {
            return $this->returnError(201, $e->getMessage());
        }
    }

    public function updatePost(Request $request)
    {
        try {
            if (!$request->has('post_id')) {
                return $this->returnError(202, 'post_id is required');
            }
            $post = Post::find($request->post_id);
            if (!$post) {
                return $this->returnError(203, 'this post is not exist');
            }
            $attach = "";
            if ($request->hasFile('attach')) {
                $attach = cloudinary()->upload($request->file('attach')->getRealPath())->getSecurePath();
                // $attach = $this->saveImage($request->attach, 'posts');
            } else {
                // $photo_len = strlen((isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/images/posts/');
                // $attach = substr($post->attach, $photo_len);
                $attach = $post->attach;
            }
            $post->update([
                'post_type' => $request->post_type ?? $post->post_type,
                'content' => $request->content ?? $post->content,
                'attach' => $attach
            ]);
            return $this->returnSuccessMessage('success');
        } catch (\Exception $e) {
            return $this->returnError(201, $e->getMessage());
        }
    }

    public function deletePost(Request $request)
    {
        try {
            if (!$request->has('post_id')) {
                return $this->returnError(202, 'post_id is required');
            }
            $post = Post::find($request->post_id);
            if (!$post) {
                return $this->returnError(203, 'post is not founded');
            }
            $post->delete();
            return $this->returnSuccessMessage('success');
        } catch (\Exception $e) {
            return $this->returnError(201, $e->getMessage());
        }
    }

    public function filterPosts(Request $request)
    {
        try {
            if (!$request->has('post_type')) {
                return $this->returnError(202, 'post_type is required');
            }
            if ($request->post_type == 'الكل') {
                $posts = Post::with(['user' => function ($q) {
                    $q->select('id', 'name', 'photo');
                }])
                    ->latest()->get();
            } else {
                $posts = Post::where('post_type', $request->post_type)
                    ->with(['user' => function ($q) {
                        $q->select('id', 'name', 'photo');
                    }])
                    ->latest()->get();
            }
            return $this->returnData('data', $posts);
        } catch (\Exception $e) {
            return $this->returnError(201, $e->getMessage());
        }
    }

    public function filterMyPosts(Request $request)
    {
        try {
            if (!$request->has('post_type') || !$request->has('user_id')) {
                return $this->returnError(202, 'post_type and user_id is required');
            }
            if ($request->post_type == 'الكل') {
                $posts = Post::where('user_id', $request->user_id)
                    ->latest()
                    ->get();
            } else {
                $posts = Post::where('user_id', $request->user_id)
                    ->where('post_type', $request->post_type)
                    ->latest()
                    ->get();
            }
            return $this->returnData('data', $posts);
        } catch (\Exception $e) {
            return $this->returnError(201, $e->getMessage());
        }
    }
}
