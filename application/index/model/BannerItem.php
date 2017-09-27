<?php
/**
 * Created by PhpStorm.
 * User: 87204
 * Date: 2017/9/21
 * Time: 22:38
 */

namespace app\index\model;


class BannerItem extends BaseModel
{
    protected $hidden=['img_id','banner_id','delete_time','update_time'];
    public function img(){
        return $this->belongsTo('Image','img_id','id');
    }

    public function product(){
        return $this->belongsTo('Product','key_word','id');
    }

    public static function getBannerByID($id){
        $banner = self::with('img')->with('product')->where('banner_id',$id)->select();
        return $banner;
    }
    public static function getBannerByProduct($id){
        $banner = self::with('img')->with('product')->where('key_word',$id)->find();
        return $banner;
    }

    public static function editBanner($data){
       $banneres = self::with('img')->with('product')->save(($data),['id' =>$data['id'] ]);
       return $banneres;
    }

}