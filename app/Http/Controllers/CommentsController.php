<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comments;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $comment = Comments::create(['user_id' => $request->input('user_id'),
            'video_id' => $request->input('user_id'),
            'content' => $request->input('content')]);

        return json_encode(array('success' => true, 'comment_id' => $comment->comment_id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return
     */
    public function show(Request $request)
    {
        $video_id = $request->input('video_id');
        $comments = Comments::all()->where('video_id', '=', $video_id);
        return json_encode(array('success' => true, 'comments' => $comments));
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
        $comment = Comments::find($id);
        if ($comment->isEmpty()) {
            return json_encode(array('success' => false, 'message' => 'Comment not found'));
        }
        if ($comment->user_id == $request->input('user_id')) {
            $data = json_decode($request->input('data'));
            $newContent = $data->content;
            DB::table('comments')
                ->where('comment_id', $id)
                ->update(['content' => $newContent]);
            return json_encode(array('success' => true));
        }
        return json_encode(array('success' => false, 'message' => 'You can not edit this comment'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $comment = Comments::find($id);
        if (!$comment->isEmpty()) {
            if ($comment->user_id != $request->input('user_id')) {
                return json_encode(array('success' => false, 'message' => 'You do not have the permission to delete this comment'));
            }
            $comment->delete();
            return json_encode(array('success' => true));
        }
        return json_encode(array('success' => false, 'message' => 'Comment not found'));


    }
}
