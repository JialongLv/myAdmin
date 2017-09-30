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
                $info = $file->move('C:\wamp64\www\WeChatShop\public\images');
                if ($info) {
                    $main_img_url=$info->getSaveName();
                    $data['main_img_url'] = $main_img_url;
                }
            }

//            if ($_FILES['main_img_url']['tmp_name']) {
//                $file = request()->file('main_img_url');
//                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
//                if ($info) {
//                    $main_img_url='/WeChatShop/'. 'public' . DS . 'images' .'/'.$info->getSaveName();
//                    $data['main_img_url'] = $main_img_url;
//                }
//            }
        });
    }

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

    public function cate(){
        return $this->belongsTo('Category','category_id','id');
    }

    public static function getProductDetail($id){
        $product = self::with([
            'imgs' => function($query){
                $query->with(['imgUrl'])
                    ->order('order','asc');
            }
        ])
            ->with(['properties'])
            ->find($id);
        return $product;
    }

    public static function getAll(){
        $products = self::with('cate')->select();
        return $products;
    }

//    public static function addProduct($data){
//
//      $product = self::create($data);
//
//        if ($products){
//            return true;
//        }else{
//            return false;
//        }
//    }


}