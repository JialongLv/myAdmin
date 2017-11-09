<?php
/**
 * Created by PhpStorm.
 * User: 87204
 * Date: 2017/11/9
 * Time: 14:12
 */

namespace app\index\controller;


use app\index\model\Business;
use think\Controller;

class Login extends Controller
{
    public function index(){
        if (request()->isPost()) {
            $this->check(input('code'));
            $login = new Business();
            $status = $login->login(input('username'),input('password'));
            if ($status == 1) {
                return $this->success('登录成功，正在跳转！','Index/index');
            }elseif ($status == 2) {
                return $this->error('账号或者密码错误！');
            }else{

                return $this->error('账号不存在');
            }
        }
        return $this->fetch('index');
    }

    public function logout(){
        session(null);
        return $this->success('退出成功！',url('index'));
    }

    // 验证码检测
    public function check($code='')
    {
        if (!captcha_check($code)) {
            $this->error('验证码错误');
        } else {
            return true;
        }
    }


}