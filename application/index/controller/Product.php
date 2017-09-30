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

class Product extends Controller
{
    public function getProduct(){
        $product = ProductModel::getAll();
//        return json($product);die;
        $this->assign('product',$product);
        return view('lst');
    }

    public function addProduct(){
        if (request()->isPost()) {

            $data=input('post.');
//            var_dump($_FILES);die;
//            $save=ProductModel::addProduct($data);
            $Product=new ProductModel();
//            $Product->with('properties')->data($data);
//             return json($data); die;
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
               ['name'=>'口味', 'detail' => $data['Flavor'], 'product_id'=>$Product->id],
               ['name'=>'产地', 'detail' => $data['where'], 'product_id'=>$Product->id],
               ['name'=>'净含量', 'detail' => $data['weight'], 'product_id'=>$Product->id],
               ['name'=>'保质期', 'detail' => $data['period'], 'product_id'=>$Product->id],
           ];
            $ProductPropertySave = $ProductProperty->saveAll($list);

            $Image = new Image();
            $data = array();
            for ($i=0; $i < count($_FILES['Pimg']['name']); $i++){
                if(isset($_FILES['Pimg']['name'][$i]) && $_FILES['Pimg']['error'][$i] == 0){
                    $data[] = ['url'=>$_FILES['Pimg']['name'][$i]];
//                    var_dump($_FILES['Pimg']['name'][$i]);die;
                }

            }
            $list = $data;
//            var_dump($list);die;
//            $data = (['url'=>$_FILES['Pimg']['name']]


            $ImageSave  = $Image->saveAll($list);


//           $ProductImage = new ProductImage();
//            $data = (['img_id'=>$Image->id,'product_id'=>$Product->id]
//            )
//            ;
//            $ProductImageSave = $ProductImage->save($data);


            if ($save && $ProductPropertySave && $ImageSave  ) {
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


    public function editProduct(){

    }

}