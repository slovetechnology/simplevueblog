<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Love;
use App\Models\Post;
use App\Models\Reply;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DashboardController extends Controller
{
    public function allusers()
    {
        return User::where('id', '!=', auth()->user()->id)->orderBy('created_at', 'DESC')->get();
    }
    public function allposts()
    {
        return Post::orderBy('created_at', 'DESC')->with('user')->get();
    }
    public function posttextonly(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
        ]);
        $post = new Post;
        $post->user_id = auth()->user()->id;
        $post->content = $request->content;
        $post->save();
    }
    public function addPostwithImage(Request $request)
    {
        $request->validate([
            'post' => 'required|string',
            'media' => 'required|mimes:png,jpg,jpeg,gif,mp4,mp3,jffif,txt,webp|max:60032'
        ]);
        $post = new Post;
        $post->user_id = auth()->user()->id;
        $post->content = $request->post;
        if($request->hasFile('media')){
            $file = $request->file('media');
            $ext = $file->getClientOriginalExtension();
            $filename = 'post'.time().'.'.$ext;
            $file->move('assets/posts/', $filename);
            $post->media = $filename;
            $post->ext = $ext;
        }
        $post->save();
        return 'file successfully saved';
    }
    public function updateprofile(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);
        $user = User::findOrFail(auth()->user()->id);
        if($user) {
            $user->name = $request->name;
            if($request->hasFile('photo')) {
                $path = 'assets/profiles/'.$user->profile;
                if(File::exists($path)) {
                    File::delete($path);
                }
                $file = $request->file('photo');
                $ext = $file->getClientOriginalExtension();
                $filename = time().'.'.$ext;
                $file->move('assets/profiles/', $filename);
            }
            (empty($request->file('photo'))) ? $image = $user->profile : $image = $filename;
            $user->profile = $image;
            $user->save();
        }
    }
    public function deleteaccount()
    {
        $user = User::findOrFail(auth()->user()->id);
        if($user) {
            $path = 'assets/profiles/'.$user->profile;
            if(File::exists($path)){
                File::delete($path);
            }
            $user->delete();
        }
    }
    public function likepost(Request $request, $id)
    {
        $like = Like::where('user_id', auth()->user()->id)->where('post_id', $id)->exists();
        if(!$like) {
            $likeme = new Like;
            $likeme->user_id = auth()->user()->id;
            $likeme->post_id = $id;
            $likeme->save();
            return response()->json([
                'status' => 200,
                'msg' => auth()->user()->id.'//'.$id
            ]);
        }else{
            return response()->json([
                'status' => 400,
            ]);
        }
    }
    public function unlikepost(Request $request, $id)
    {
        $like = Like::where('user_id', auth()->user()->id)->where('post_id', $id)->get();
        if($like) {
            $like[0]->delete();
        }
    }
    public function checklike($id) {
        $like = Like::where('post_id', $id)->get();
        if($like->count() > 0) {
            return $like->count();
        }else{
            return 0;
        }
    }
    public function likebyuser($id)
    {
        $user = Like::where('user_id', auth()->user()->id)->where('post_id', $id)->exists();
        if(!$user) {
            return response('post not liked by user', 201);
        }else{
            return response('user liked post', 200);
        }
    }
    public function getloves($id)
    {
        $love = Love::where('post_id', $id)->get();
        if($love->count() > 0){
            return $love->count();
        }else{
            return 0;
        }
    }
    public function postlove(Request $request, $id)
    {
        $love = Love::where('user_id', auth()->user()->id)->where('post_id', $id)->exists();
        if(!$love) {
            $loveme = new Love;
            $loveme->user_id = auth()->user()->id;
            $loveme->post_id = $id;
            $loveme->save();
        }else{
            return response()->json(['status' => 400]);
        }
    }
    public function lovebyuser($id)
    {
        $user = Love::where('user_id', auth()->user()->id)->where('post_id', $id)->exists();
        if(!$user) {
            return response('post not liked by user', 201);
        }else{
            return response('user liked post', 200);
        }
    }
    public function deletelove(Request $request, $id)
    {
        $love = Love::where('user_id', auth()->user()->id)->where('post_id', $id)->get();
        if($love) {
            $love[0]->delete();
        }
    }
    public function submitReply(Request $request, $id)
    {
        $request->validate([
            'reply' => 'required|string',
        ]);
        $chat = new Reply();
        $chat->user_id = auth()->user()->id;
        $chat->post_id = $id;
        $chat->msg = $request->reply;
        $chat->save();
    }
    public function getsingles($id)
    {
        $post = Post::where('id', $id)->with('user')->get();
        if($post) {
            return $post[0];
        }
    }
    public function getpostcount($id)
    {
        $post = Reply::where('post_id', $id)->get();
        if($post->count() > 0) {
            return $post->count();
        }else{
            return 0;
        }
    }
    public function getreplys($id)
    {
        $reply = Reply::where('post_id', $id)->with('user')->get();
        if($reply->count() > 0) {
            return $reply;
        }else{
            return 'Be the first to reply to this post';
        }
    }
    public function singleuser($id)
    {
        $user = Post::where('user_id', $id)->with('user')->get();
        if($user) {
            return $user[0];
        }
    }
    public function getuserreplies($id)
    {
        $reply = Reply::where('user_id', $id)->get();
        if($reply->count() > 0){
            return $reply->count();
        }else{
            return 0;
        }
    }
    public function postsbyuser($id)
    {
        $reply = Post::where('user_id', $id)->get();
        if($reply->count() > 0){
            return $reply->count();
        }else{
            return 0;
        }
    }
    public function getUserPosts($id)
    {
        $post = Post::where('user_id', $id)->get();
        if($post){
            return $post;
        }else{
            return 'No Post found for User';
        }
    }
    public function userliked($id)
    {
        $reply = Like::where('user_id', $id)->get();
        if($reply->count() > 0){
            return $reply->count();
        }else{
            return 0;
        }
    }
    public function userloved($id)
    {
        $reply = Love::where('user_id', $id)->get();
        if($reply->count() > 0){
            return $reply->count();
        }else{
            return 0;
        }
    }
}
