<?php
/**
 * Created by PhpStorm.
 * User: 87204
 * Date: 2017/9/21
 * Time: 21:23
 */

namespace app\index\controller;

use app\index\model\BannerItem as BannerItemModel;
use app\index\model\Product as ProductModel;
use app\index\model\Image as ImageModel;
use app\index\validate\Banner as BannerValidate;
use think\Controller;

class Banner extends Base
{
    public function getBanner(){
        $banner = BannerItemModel::getBannerByID($id=1);
        $this->assign('banner',$banner);
        return view('lst');

    }

    public function editBanner($id){
         if (request()->isPost()){
             $data = input('post.');
//             var_dump($_FILES);die;
             BannerItemModel::where('id',$data['id'])->update(['key_word' => $data['product_id']]);
             if ($_FILES['Pimg']['name'] !=null){
                 $imageData = ImageModel::oneUpload();
                 ImageModel::update(['url' =>$imageData,'id'=>$data['img_id']]);
             }

             if ( $data) {
                 $this->success('更新推荐成功！',url('getBanner'));
             }else{
                 $this->error('更新推荐失败');
             }
         }

        $banner = BannerItemModel::getBannerByProduct($id);
        $product = ProductModel::getAllProduct();
//        return json($product);
//        die;
        $this->assign(array(
            'banner'=>$banner,
            'product'=>$product,
        ));
        return view('edit');
    }

    public function readBanner($id){

        $banner = BannerItemModel::getBannerByProduct($id);
        $product = ProductModel::getAllProduct();
//        return json($product);
//        die;
        $this->assign(array(
            'banner'=>$banner,
            'product'=>$product,
        ));
        return view('read');
    }

}