<?php
/**
 * Created by PhpStorm.
 * User: 87204
 * Date: 2017/11/17
 * Time: 10:08
 */

namespace app\index\Validate;


use think\Validate;

class Product extends Validate
{
    protected $rule = [
        'name' => 'unique:product|require|max:55',
        'price' => 'require|number|>=:0.01',
        'stock' => 'require|number|>=:1'
    ];

    protected $message = [
        'name.unique' => '商品名称不得重复',
        'name.require' => '商品名称不得为空',
         'name.max' => '商品名称不得大于55个字符',
        'price.number'=> '请输入正确的商品价格',
        'price.require'=> '商品价格不得为空',
        'price'=> '请输入大于0.01的商品价格',
        'stock'=> '库存应大于1',
        'stock.require' => '商品库存不得为空',
        'stock.number' => '请输入正确的商品库存'
    ];

}