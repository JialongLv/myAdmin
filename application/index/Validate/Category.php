<?php
/**
 * Created by PhpStorm.
 * User: 87204
 * Date: 2017/11/17
 * Time: 10:06
 */

namespace app\index\Validate;


use think\Validate;

class Category extends Validate
{
    protected $rule = [
        'name' => 'unique:category|require|max:25',
    ];

    protected $message = [
        'name.unique' => '分类名称不得重复',
        'name.require' => '分类名称不得为空',
        'name.max' => '分类名称不得大于25个字符'
    ];

}