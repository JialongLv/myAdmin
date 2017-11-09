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
    protected static function init()
    {
        Product::event('before_insert',function($data){

            if ($_FILES['main_img_url']['tmp_name']) {
                $file = request()->file('main_img_url');
                $info = $file->rule('uniqid')->move('C:\wamp64\www\WeChatShop\public\images');
                if ($info) {
                    $main_img_url=$info->getSaveName();
                    $data['main_img_url'] = $main_img_url;
                }
            }
        });

        Product::event('before_update',function($data){
        if($_FILES['main_img_url']['tmp_name']){
            $file = request()->file('main_img_url');
            $info = $file->rule('uniqid')->move('C:\wamp64\www\WeChatShop\public\images');
            if($info){
                $main_img_url=$info->getSaveName();
                $data['main_img_url'] = $main_img_url;
                 return $data;
            }
        }
        });
    }

    public static function upload(){

        if($_FILES['main_img_url']['tmp_name']){
            $file = request()->file('main_img_url');
            $info = $file->move('C:\wamp64\www\WeChatShop\public\images');
            if($info){
                $main_img_url=$info->getSaveName();
                $data = $main_img_url;
                return $data;
            }
        }
    }


    protected $hidden = [
        'delete_time', 'main_img_id', 'pivot', 'from',
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

    public function cate(){
        return $this->belongsTo('Category','category_id','id');
    }

    public static function getProductDetail($id){
        $product = self::with([
            'imgs' => function($query){
                $query->with(['imgUrl'])
                    ->order('id','asc');
            }
        ])
            ->with(['properties'])
            ->find($id);
        return $product;
    }

    public static function getAll(){
        $products = self::with('cate')->order('id desc')->paginate(25);
        return $products;
    }

    public static function getAllProduct(){
        $products = self::with('cate')->order('id desc')->select();
        return $products;
    }


}