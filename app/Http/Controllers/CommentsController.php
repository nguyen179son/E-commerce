<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comments;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

class CommentsController extends Controller
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
        $parameters = array('user_id' => $request->input('user_id'),
            'video_id' => $request->input('video_id'));
        $validation = Validator::make($parameters, [
            'user_id' => 'required|integer',
            'video_id' => 'required|integer',
        ]);
        if ($validation->fails()) {
            return abort(400,'Bad Request');
        }
        $data = $request->input('data');
        $comment = Comments::create(['user_id' => $request->input('user_id'),
            'video_id' => $request->input('video_id'),
            'content' => $data['content']]);
        return response()->json([
            'success' => true,
            'comment_id' => $comment->comment_id
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return
     */
    public function show(Request $request)
    {
        $parameters = array('video_id' => $request->input('video_id'));
        $validation = Validator::make($parameters, [
            'video_id' => 'required|integer'
        ]);
        if ($validation->fails()) {
            return abort(400,'Bad Request');
        }
        $video_id = $request->input('video_id');
        $comments = Comments::all()->where('video_id', '=', $video_id);
        return response()->json([
            'success' => true,
            'comment' => $comments
        ], 200);
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
        $parameters = array('user_id' => $request->input('user_id'),
            'comment_id' => $id);
        $validation = Validator::make($parameters, [
            'user_id' => 'required|integer',
            'comment_id' => 'required|integer'
        ]);
        if ($validation->fails()) {
            return abort(400,'Bad Request');
        }
        $comment = Comments::find($id);
        if (!$comment) {
            return abort(404, 'Resource Not Found');
        }
        if ($comment->user_id == $request->input('user_id')) {
            $data = $request->input('data');
            $newContent = $data['content'];
            DB::table('comments')
                ->where('comment_id', $id)
                ->update(['content' => $newContent]);
            return response()->json([
                'success' => true
            ], 200);
        }
        return abort(403, 'Permission Denied');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request, $id)
    {
        $parameters = array('user_id' => $request->input('user_id'),
            'comment_id' => $id);
        $validation = Validator::make($parameters, [
            'user_id' => 'required|integer',
            'comment_id' => 'required|integer'
        ]);
        if ($validation->fails()) {
            return abort(400,'Bad Request');
        }
        $comment = Comments::find($id);
        if ($comment) {
            if ($comment->user_id != $request->input('user_id')) {
                return abort(403, 'Permission Denied');
            }
            $comment->delete();
            return response()->json([
                'success' => true
            ], 200);
//            return json_encode(array('success' => true));
        }
        return abort(404, 'Resource Not Found');


    }
}
