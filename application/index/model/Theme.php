<?php
/**
 * Created by PhpStorm.
 * User: 87204
 * Date: 2017/9/27
 * Time: 12:40
 */

namespace app\index\model;


class Theme extends BaseModel
{
    public function img(){
        return $this->belongsTo('Image','topic_img_id','id');
    }

    public function himg(){
        return $this->belongsTo('Image','head_img_id','id');
    }

    public static function getTheme(){
        $theme = self::with('img')->with('himg')->select();
        return $theme;

}

}