<?php
/**
 * Created by PhpStorm.
 * User: 87204
 * Date: 2017/11/5
 * Time: 15:58
 */

namespace app\index\controller;


use think\Controller;
use app\index\model\Order as OrderModel;
use think\Db;

class Order extends Base
{
    public function GetAllOrder(){
        $OrderModel = new OrderModel();
        $AllOrder = $OrderModel->order('id desc')->paginate(25);
        $this->assign('AllOrder',$AllOrder);
        return view('lst');
    }

    public function getOrderDetail($id)
    {
        $Order = OrderModel::find($id);
        $Product = $Order['snap_items'];
        $this->assign(array(
            'Product'=>$Product,
            'Order'=>$Order,
        ));
        return view('product');
    }

    public function OrderStatus($id){
        if (request()->isPost()){
            $data=input('post.');
            $OrderStatus = OrderModel::get($data['id']);
            $OrderStatus->status = $data['status'];
            $save = $OrderStatus->save();

            if ($save) {
                $this->success('订单状态修改成功',url('GetAllOrder'));
            }else{
                $this->error('订单状态修改失败');
            }
            return;
        }
    }


}