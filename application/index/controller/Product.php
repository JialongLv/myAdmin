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

class Product extends Base
{
    public function getProduct(){
        $product = ProductModel::getAll();
        $this->assign('product',$product);
        return view('lst');
    }

    public function addProduct(){
        if (request()->isPost()) {

            $data=input('post.');
            $validate = \think\Loader::validate('Product');
            if(!$validate->check($data)){
                $this->error($validate->getError());
            }
            $Product=new ProductModel();
            $data['create_time'] = date("Y-m-d");
            $Product->data([
                'name' => $data['name'],
                'price'=> $data['price'],
                'stock'=> $data['stock'],
                'category_id'=> $data['category_id'],
                'main_img_url'=> $_FILES['main_img_url']['name'],
                'create_time' => $data['create_time']
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



    public function del(){
        $ProductDel = ProductModel::destroy(input('id'));
        $ProductPropertyDel = ProductPropertyModel::destroy(['product_id' =>input('id')]);
        $ProductImage = ProductImageModel::delImgUrl(input('id'));
        if ($ProductDel && $ProductPropertyDel ){
            $this->success('删除商品成功',url('getProduct'));
        }else{
            $this->error('删除商品失败');
        }
    }


    public function editProduct($id){
        if (request()->isPost()) {
            $data=input('post.');
            $validate = \think\Loader::validate('Product');
            if(!$validate->check($data)){
                $this->error($validate->getError());
            }
//            var_dump($data);die;
//             return json($data['category_id']);die;
            $Product = new ProductModel();
            $save = $Product::update(['id'=>$data['id'],'name' => $data['name'],
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
//            $ProductProperty = new ProductPropertyModel();
//            $list = [
//                ['name'=>'品名', 'detail' => $data['Pname'], 'product_id'=>$data['id']],
//                ['name'=>'产地', 'detail' => $data['where'], 'product_id'=>$data['id']],
//                ['name'=>'净含量', 'detail' => $data['weight'], 'product_id'=>$data['id']],
//                ['name'=>'保质期', 'detail' => $data['period'], 'product_id'=>$data['id']],
//            ];
//            $ProductPropertySave = $ProductProperty->saveAll($list);
           $imgIds = ProductImageModel::getImgUrl($data['id']);
            $imgUrls = Image::upload();
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