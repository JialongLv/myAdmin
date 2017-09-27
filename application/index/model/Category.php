<?php
/**
 * Created by PhpStorm.
 * User: 87204
 * Date: 2017/9/27
 * Time: 9:24
 */

namespace app\index\model;


class Category extends BaseModel
{
    public function img(){
        return $this->belongsTo('Image','topic_img_id','id');
    }

    public static function getCate(){
        $cateres=self::with('img')->select();
        return $cateres;
    }

}