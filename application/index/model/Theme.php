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
    public function products(){
        return $this->belongsToMany('Product','theme_product','product_id','theme_id');
    }

    public function topicImg(){
        return $this->belongsTo('Image','topic_img_id','id');
    }

    public function product(){
        return $this->hasMany('Product','product_id','id');
    }

    public function himg(){
        return $this->belongsTo('Image','head_img_id','id');
    }

    public static function getTheme(){
        $theme = self::with('img')->with('himg')->select();
        return $theme;
    }

    public static function getThemeDetail($id){
        $themes = self::with('products,topicImg,himg')
            ->find($id);
        return $themes;
//        $themeProduct = self::with('product')->where('theme_id',$id)->select();
//        return $themeProduct;
    }



}