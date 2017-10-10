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

    public static function delImgUrl($id){
        $ImgUrl = db('product_image')->where('product_id',$id)->field('img_id')->select();
//        var_dump($ImgUrl);die;
        foreach ($ImgUrl as $value ){
            Image::destroy($value['img_id']);
        }

        $ProductImgDel = db('product_image')->where('product_id',$id)->delete();
        return $ProductImgDel;
    }

}