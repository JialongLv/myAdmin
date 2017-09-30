<?php
/**
 * Created by PhpStorm.
 * User: 87204
 * Date: 2017/9/27
 * Time: 19:57
 */

namespace app\index\model;


class ProductImage extends BaseModel
{

    public function imgUrl()
    {
        return $this->belongsTo('Image', 'img_id', 'id');
    }

}