<?php
/**
 * Created by PhpStorm.
 * User: 87204
 * Date: 2017/9/27
 * Time: 9:11
 */

namespace app\index\controller;


use think\Controller;
use app\index\model\Product as ProductModel;

class Product extends Controller
{
    public function getProduct(){
        $product = ProductModel::getAll();
        $this->assign('product',$product);
        return view('lst');
    }

}