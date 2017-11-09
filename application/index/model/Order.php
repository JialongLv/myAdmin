<?php
/**
 * Created by PhpStorm.
 * User: 87204
 * Date: 2017/11/5
 * Time: 16:01
 */

namespace app\index\model;


class Order extends BaseModel
{
    protected $type = [
      'snap_items' => 'json',
      'snap_address' =>  'json',
    ];

}