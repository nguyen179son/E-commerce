<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Likes extends Model
{
    use SoftDeletes;
    protected $table = "likes";
    protected $user_id;
    protected $video_id;
    protected $primaryKey = "likes_id";
    protected $fillable = ['user_id','video_id'];

    protected $dates = ['deleted_at'];
    /**
     * @return mixed
     */
    public function getUserId()
        {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getVideoId()
    {
        return $this->video_id;
    }

    /**
     * @param mixed $video_id
     */
    public function setVideoId($video_id)
    {
        $this->video_id = $video_id;
    }

    public static function check_exist($user_id,$video_id) {
        if (DB::table('likes')->where('user_id',$user_id)->where('video_id',$video_id))
            return true;
        return false;
    }
}
