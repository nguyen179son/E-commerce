<?php

namespace App\Http\Controllers;

use App\Likes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LikesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Likes::check_exist($request->input('user_id'), $request->input('video_id'))) {
            return json_encode(array('success' => false, 'message' => 'You liked this video'));
        }
        $like = Likes::create(['user_id' => $request->input('user_id'),
            'video_id' => $request->input('user_id')]);

        return json_encode(array('success' => true, 'like_id' => $like->likes_id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $video_id = $request->input('video_id');
        $likes = Likes::all()->where('video_id', '=', $video_id);
        return json_encode(array('success' => true, 'likes' => $likes));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $like = Likes::where('user_id', $request->input('user_id'))
            ->where('video_id', $request->input('video_id'))->first();
        if (!$like) {
            return json_encode(array('success' => false, 'message' => 'Content not found'));
        }
        $like->delete();
        return json_encode(array('success' => true));
    }
}
