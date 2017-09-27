<?php
/**
 * Created by PhpStorm.
 * User: 87204
 * Date: 2017/9/27
 * Time: 12:39
 */

namespace app\index\controller;


use think\Controller;
use app\index\model\Theme as ThemeModel;

class Theme extends Controller
{
    public function getTheme(){
        $theme = ThemeModel::getTheme();
        $this->assign('theme',$theme);
        return view('lst');
    }

}