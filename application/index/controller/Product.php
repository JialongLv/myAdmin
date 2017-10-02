<?php
/**
 * Created by PhpStorm.
 * User: 87204
 * Date: 2017/9/27
 * Time: 9:11
 */

namespace app\index\controller;


use app\index\model\Image;
use app\index\model\ProductImage;
use think\Controller;
use app\index\model\Product as ProductModel;
use app\index\model\Category as CategoryModel;
use app\index\model\ProductProperty as ProductPropertyModel;
use app\index\model\ProductImage as ProductImageModel;

class Product extends Controller
{
    public function getProduct(){
        $product = ProductModel::getAll();
        $this->assign('product',$product);
        return view('lst');
    }

    public function addProduct(){
        if (request()->isPost()) {

            $data=input('post.');
//            var_dump($_FILES);die;
            $Product=new ProductModel();


            $Product->data([
                'name' => $data['name'],
                'price'=> $data['price'],
                'stock'=> $data['stock'],
                'category_id'=> $data['category_id'],
                'main_img_url'=> $_FILES['main_img_url']['name']


            ]);
            $save=$Product->save();

            $ProductProperty = new ProductPropertyModel();
           $list = [
               ['name'=>'品名', 'detail' => $data['Pname'], 'product_id'=>$Product->id],
               ['name'=>'产地', 'detail' => $data['where'], 'product_id'=>$Product->id],
               ['name'=>'净含量', 'detail' => $data['weight'], 'product_id'=>$Product->id],
               ['name'=>'保质期', 'detail' => $data['period'], 'product_id'=>$Product->id],
           ];
            $ProductPropertySave = $ProductProperty->saveAll($list);


                    $imageData = Image::upload();
//                    var_dump($imageData);die;
                    foreach ($imageData as $url) {

                        $Image = new Image();
                        $Image->data(['url'=>$url]);
                        $Image->save();

                        $ProductImage = new ProductImage();
                        $data =(['img_id'=>$Image->id, 'product_id'=>$Product->id]);
                        $ProductImage->save($data);
                    }

            if ($save && $ProductPropertySave  ) {
                $this->success('添加商品成功！',url('getProduct'));
            }else{
                $this->error('添加商品失败');
            }
            return;
        }

        $cate =  new CategoryModel();
        $cateres = $cate->select();
        $this->assign('cateres',$cateres);
        return view('add');
    }

    public function getProductDetail($id=11){
        $product = ProductModel::getProductDetail($id);
        return json($product); die;
    }

    public function del(){
        if (ProductModel::destroy(input('id'))){
            $this->success('删除商品成功',url('getProduct'));
        }else{
            $this->error('删除商品失败');
        }
    }


    public function editProduct($id){
        if (request()->isPost()) {

            $data=input('post.');
//            var_dump($_FILES);die;
            $Product= new ProductModel();
            $save = $Product->where('id',$data['id'])->update([
                'name' => $data['name'],
                'price'=> $data['price'],
                'stock'=> $data['stock'],
                'category_id'=> $data['category_id'],
                ]);



            $ProductProperty = new ProductPropertyModel();
            $ProductPropertyId = $ProductProperty->where('product_id',$data['id'])->select();

            $list = [
                ['id'=>$ProductPropertyId[0]['id'],'name'=>'品名', 'detail' => $data['Pname'],'product_id'=>$data['id']],
                ['id'=>$ProductPropertyId[1]['id'],'name'=>'产地', 'detail' => $data['where'],'product_id'=>$data['id']],
                ['id'=>$ProductPropertyId[2]['id'],'name'=>'净含量', 'detail' => $data['weight'],'product_id'=>$data['id']],
                ['id'=>$ProductPropertyId[3]['id'],'name'=>'保质期', 'detail' => $data['period'],'product_id'=>$data['id']],
            ];

            $ProductPropertySave = $ProductProperty->saveAll($list);


           $imgIds = ProductImageModel::getImgUrl($data['id']);
            $imgUrls = Image::upload();
//            $imgId = (object)$imgUrls;
//            var_dump($imgId);die;
            if ($imgUrls){
                foreach ($imgIds as $key => $id){
                    $Image = Image::get($id);
                    $Image->url = $imgUrls[$key];
                    $Image->save();
                }
            }


            if (($save != null) || ($ProductPropertySave != null) ) {
                $this->success('更新商品成功！',url('getProduct'));
            }else{
                $this->error('更新商品失败');
            }
            return;
        }

        $editProduct = ProductModel::getProductDetail($id);

        $cate =  new CategoryModel();
        $cateres = $cate->select();

        $this->assign(array(
            'editProduct' => $editProduct,
            'cateres' => $cateres
        ));
        return view('edit');
    }

}