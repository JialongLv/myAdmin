<?php
/**
 * Created by PhpStorm.
 * User: 87204
 * Date: 2017/11/9
 * Time: 14:15
 */

namespace app\index\model;


class Business extends BaseModel
{
    public function login($username,$password){
        $admin = self::where('username','=',$username)->find();
//        echo '用户'.$username.'密码'.$password;die;
        if ($admin){
            if ($admin['password'] =$password){
                \think\Session::set('id',$admin['id']);
                \think\Session::set('username',$admin['username']);
                return 1;
            }else{
                return 2;
            }
        }else{
            return 3;
        }
    }

}