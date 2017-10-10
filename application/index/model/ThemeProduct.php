<?php
/**
 * Created by PhpStorm.
 * User: 87204
 * Date: 2017/10/10
 * Time: 16:06
 */

namespace app\index\model;


class ThemeProduct extends BaseModel
{
    public static function delProduct($id,$productId){
        $delProduct = self::where('theme_id',$id)->where('product_id',$productId)->delete();
        return $delProduct;
    }

}