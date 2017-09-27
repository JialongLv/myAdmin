<?php
/**
 * Created by PhpStorm.
 * User: 87204
 * Date: 2017/9/22
 * Time: 16:46
 */

namespace app\index\model;


class Product extends BaseModel
{
    protected $hidden = [
        'delete_time', 'main_img_id', 'pivot', 'from', 'category_id',
        'create_time', 'update_time'];

    public function getMainImgUrlAttr($value,$data){
        return $this->prefixImgUrl($value,$data);
    }

    public function imgs(){
        return $this->hasMany('ProductImage','product_id','id');
    }

    public function properties(){
        return $this->hasMany('ProductProperty','product_id','id');
    }

    public static function getAll(){
        $products = self::all();
        return $products;
    }
}