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

    public static function getImgUrl($id){
        $ImgUrl = db('product_image')
            ->alias('p')
            ->join('image i','p.img_id=i.id')
            ->where('product_id',$id)
            ->field('i.id')
            ->select();
        //$ImgUrl0 = self::with('imgUrl')->field(imgUrl.url)->where('product_id',$id)->select();
        return $ImgUrl;
    }

}