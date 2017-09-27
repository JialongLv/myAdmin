<?php
/**
 * Created by PhpStorm.
 * User: 87204
 * Date: 2017/9/21
 * Time: 21:23
 */

namespace app\index\controller;

use app\index\model\BannerItem as BannerModel;
use app\index\model\Product as ProductModel;
use think\Controller;

class Banner extends Controller
{
    public function getBanner($id){


        $banner = BannerModel::getBannerByID($id=1);

//        return json($banner);die;
//        var_dump($banner);die;
        $this->assign('banner',$banner);
        return view('lst');

    }

    public function editBanner($id){
//        if(request()->isPost()) {
//            $data = input('post.');
//            $banner = BannerModel::editBanner($data);
//
//            if ($banner !== false) {
//                $this->success('修改栏目成功！', url('lst'));
//            } else {
//                $this->error('修改栏目失败！');
//            }
//            return;
//        }
        $banner = BannerModel::getBannerByProduct($id);
        $product = ProductModel::getAll();
//        return json($banner); die;
        $this->assign(array(
            'banner'=>$banner,
            'product'=>$product,
        ));
//        $this->assign('banner',$banner);
        return view('edit');
    }

}