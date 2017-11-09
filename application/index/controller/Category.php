<?php
/**
 * Created by PhpStorm.
 * User: 87204
 * Date: 2017/9/27
 * Time: 9:30
 */

namespace app\index\controller;


use app\index\model\Image;
use think\Controller;
use app\index\model\Category as CategoryModel;

class Category extends Base
{
    public function getCate(){
        $cate = CategoryModel::getCate();
        $this->assign('cate',$cate);
        return view('lst');
    }

    public function addCate(){
        if (request()->isPost()){
            $imageData = Image::oneUpload();
            $data = input('post.');
            $name = $data['name'];
            $save = CategoryModel::addCate($name,$imageData);
            if ($save) {
                $this->success('添加分类成功！',url('getCate'));
            }else{
                $this->error('添加分类成功');
            }
            return;
        }
        return view('add');
    }

    public function editCate($id){
        $editCate = CategoryModel::getCateDetail($id);
        $imgId = $editCate['img']['id'];
        $this->assign('editCate',$editCate);
        if (request()->isPost()){
            $data = input('post.');
            if ($_FILES['Pimg']['name'] !=null){
                $image = new Image();
                $imageData = Image::oneUpload();
                $image::update(['url' =>$imageData,'id'=>$imgId]);
            }
            $save = CategoryModel::editCate($data['id'],$data['name']);
            if ($save) {
                $this->success('更新分类成功！',url('getCate'));
            }else{
                $this->error('更新分类失败');
            }
            return;
        }
        return view('edit');
    }

    public function delCate($id){
     $Category = CategoryModel::get($id);
     $delImage = Image::destroy($Category['topic_img_id']);
      $del = CategoryModel::delCate($id);
      if ($del && $delImage){
          $this->success('删除分类成功！',url('getCate'));
      }else{
          $this->error('删除分类失败');
      }
    }


}