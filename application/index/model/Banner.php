<?php
/**
 * Created by PhpStorm.
 * User: 87204
 * Date: 2017/9/21
 * Time: 21:24
 */

namespace app\index\model;


class Banner extends BaseModel
{
    protected $hidden=['delete_time','update_time'];


    public function items(){
        return $this->hasMany('BannerItem','banner_id','id');
    }
//    public function items(){
//        return $this->hasManyThrough('Image','BannerItem','img_id','img_id','banner_id');
//    }
//    public function product(){
//        return $this->hasManyThrough('Product','BannerItem','id','key_word','id');
//    }

    public static function getBannerByID($id){
        $banner = self::with(['items','items.img'])->with(['items.product'])->find($id);
        return $banner;
    }

}