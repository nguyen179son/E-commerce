<?php

namespace App\Http\Controllers;

use App\Likes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

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
        $parameters = array(
            'user_id' => $request->input('user_id'),
            'video_id' => $request->input('video_id'),
        );
        $validation = Validator::make($parameters, [
            'user_id' => 'required|integer',
            'video_id' => 'required|integer',
        ]);
        if ($validation->fails()) {
            return abort(400, 'Bad Request');
        }
        if (Likes::check_exist($request->input('user_id'), $request->input('video_id'))) {
            return abort(409, 'Conflict');
        }
        $like = Likes::create(['user_id' => $request->input('user_id'),
            'video_id' => $request->input('video_id')]);
        return response()->json([
            'success' => true,
            'like_id' => $like->like_id
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $parameters = array('video_ids' => $request->input('video_ids'));
        $validation = Validator::make($parameters, [
            'video_ids' => 'required|numericArray',
        ]);
        if ($validation->fails()) {
            return abort(400, 'Bad Request');
        }
        $video_id = $request->input('video_id');
        $videos = $request->input('video_ids');
        $videos = array_unique($videos);
            $return_array = [];
        foreach ($videos as $video_id) {
            $likes = \DB::table('likes')->where('video_id', '=', $video_id)->whereNull('deleted_at')->get();
            $likes_array = [];
            foreach ($likes as $like) {
                array_push($likes_array, (array)$like);
            }
            array_push($return_array, ['video_id' => $video_id, 'likes' => $likes_array]);
        }
        return response()->json(
            $return_array
            , 200);
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
     * @throws \Exception
     */
    public function destroy(Request $request)
    {
        $parameters = array('user_id' => $request->input('user_id'),
            'video_id' => $request->input('video_id'),
        );
        $validation = Validator::make($parameters, [
            'user_id' => 'required|integer',
            'video_id' => 'required|integer',
        ]);
        if ($validation->fails()) {
            return abort(400, 'Bad Request');
        }
        $like = Likes::where('user_id', $request->input('user_id'))
            ->where('video_id', $request->input('video_id'))->first();
        if (!$like) {
            return abort(404, 'Resource Not Found');
        }
        $like->delete();
        return response()->json([
            'success' => true
        ], 200);
    }
}
