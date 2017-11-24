<?php
/**
 * Created by PhpStorm.
 * User: 87204
 * Date: 2017/9/27
 * Time: 12:39
 */

namespace app\index\controller;


use think\Controller;
use app\index\model\Theme as ThemeModel;
use app\index\model\Image as ImageModel;
use app\index\model\ThemeProduct as ThemeProductModel;
use app\index\model\Product as ProductModel;

class Theme extends Base
{
    public function getTheme(){
        $theme = ThemeModel::getTheme();
        $this->assign('theme',$theme);
        return view('lst');
    }

    public function getThemeDetail($id){
        $themes = ThemeModel::getThemeDetail($id);
        $this->assign('themes',$themes);
        return view('ProductLst');
    }

    public function editTheme($id){
        $themes = ThemeModel::getThemeDetail($id);
        $this->assign('themes',$themes);
        if (request()->isPost()){
            $data = input('post.');
            if ($data){
               ThemeModel::where('id', $id)
                    ->update(['description' => $data['description']]);
            }

            if ($_FILES['topic_img']['name'] != null){
              $Topic = ImageModel::topicUpload();
              $TopicImage = new ImageModel();
              $TopicImage::update(['url' =>$Topic,'id'=>$themes['topic_img_id']]);
            }
            if ($_FILES['head_img']['name']  != null){
              $Head = ImageModel::headUpload();
                $HeadImage = new ImageModel();
                $HeadImage::update(['url' =>$Head,'id'=>$themes['head_img_id']]);
            }
           $data = input('post.');

            if ( $data ||$_FILES['topic_img']['name'] || $_FILES['head_img']['name']) {
                    $this->success('更新分类成功！',url('getTheme'));
             }else{
                    $this->error('更新分类失败');
            }

        }
        return view('edit');
    }

    public function delProduct($id,$productId){
      $del = ThemeProductModel::delProduct($id,$productId);
      if ($del){

          $this->success('移除商品成功！',url('getThemeDetail',['id' =>$id]));
      }else{
          $this->error('移除商品失败');
      }
    }

    public function addProduct($id){
        $ThemeProduct = new ThemeProductModel();
        $ThemeProduct = $ThemeProduct->where('theme_id',$id)->select();
        $product = array();
        foreach ($ThemeProduct as $k =>$value){
            $product[] = $value['product_id'];
        }
        if (request()->isPost()){
            $data = input('post.');
            $product_id = $data['product_id'];
            if (in_array($product_id,$product)){
                $this->error('添加的商品已经存在');
            }else{
                ThemeProductModel::create([
                    'theme_id'  =>  $id,
                    'product_id' =>$product_id
                ]);
                $this->success('添加商品成功',url('getThemeDetail',['id' =>$id]));
            }
        }
        $product = ProductModel::All();
        $this->assign(array(
            'id'=>$id,
            'product'=>$product,
        ));
        return view('add');
    }

}