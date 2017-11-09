<?php
/**
 * Created by PhpStorm.
 * User: 87204
 * Date: 2017/11/9
 * Time: 14:11
 */

namespace app\index\controller;


use think\Controller;

class Base extends Controller
{
    public function _initialize()
    {
        if (!session('id')) {
            $this->error('请先登录系统！',url('Login/index'));
        }
    }
}