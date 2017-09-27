<?php
/**
 * Created by PhpStorm.
 * User: 87204
 * Date: 2017/9/21
 * Time: 22:30
 */

namespace app\index\model;


use think\Model;

class BaseModel extends Model
{
    protected function prefixImgUrl($value,$data){
        $finalUrl = $value;
        if ($data['from'] == 1){
            $finalUrl = config('setting.img_prefix').$finalUrl;
        }

        return $finalUrl;
    }

}