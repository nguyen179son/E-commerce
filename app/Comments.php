<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    protected $table = "comments";
    protected $user_id;
    protected $video_id;
    protected $content;
    protected  $primaryKey = 'comment_id';
    protected $fillable = ['user_id','video_id','content'];
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

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }


    public static function returnObject(Comments $comments, $user_id, $video_id, $content)
    {
        $comments->setUserId($user_id);
        $comments->setVideoId($video_id);
        $comments->setContent($content);
        return $comments;
    }

}
