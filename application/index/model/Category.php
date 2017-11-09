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
    protected static function init()
    {
        Product::event('before_insert', function ($data) {
            if ($_FILES['Pimg']) {
                $file = request()->file('Pimg');
                $info = $file->move('C:\wamp64\www\WeChatShop\public\images');
                if ($info) {
                    $imgUrl = $info->getSaveName();
                    $data['url'] = $imgUrl;
                }
            }
        });
    }

    public function img(){
        return $this->belongsTo('Image','topic_img_id','id');
    }

    public static function getCate(){
        $cateres=self::with('img')->select();
        return $cateres;
    }

    public static function getCateDetail($id){
        $cateres=self::with('img')->find($id);
        return $cateres;
    }

    public static function addCate($name,$imageData){
       $image = new Image();
        $image = $image::create(['url'=>$imageData]);
       $cate = self::create(['name'=>$name,'topic_img_id'=>$image->id]);
       return $cate;
    }

    public static function editCate($id,$name){
        $cate = self::update(['name'=>$name,'id'=>$id]);
        return $cate;
    }

    public static function delCate($id){
        $cateres=self::with('img')->delete($id);
        return $cateres;
    }



}