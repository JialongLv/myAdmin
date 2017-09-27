<?php
/**
 * Created by PhpStorm.
 * User: 87204
 * Date: 2017/9/27
 * Time: 9:30
 */

namespace app\index\controller;


use think\Controller;
use app\index\model\Category as CategoryModel;

class Category extends Controller
{
    public function getCate(){
        $cate = CategoryModel::getCate();
//        return json($cate); die;
        $this->assign('cate',$cate);
        return view('lst');
    }

}