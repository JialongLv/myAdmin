<?php
/**
 * Created by PhpStorm.
 * User: 87204
 * Date: 2017/9/21
 * Time: 22:40
 */

namespace app\index\model;


class Image extends BaseModel
{
    protected $hidden = ['from','delete_time','update_time'];

    public function getUrlAttr($value,$data){
        return $this->prefixImgUrl($value,$data);
    }

}