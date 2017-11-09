<?php
/**
 * Created by PhpStorm.
 * User: 87204
 * Date: 2017/9/21
 * Time: 22:40
 */

namespace app\index\model;


class Image extends BaseModel
{


   public static function upload(){
       $files = request()->file('Pimg');
       $data = array();
       foreach($files as $file){
           $info = $file->rule('uniqid')->move('C:\wamp64\www\WeChatShop\public\images');
           if ($info){
                     $url=$info->getSaveName();
                     $data[]=$url;
           }
       }
       return $data;
   }

    public static function oneUpload(){
        $file = request()->file('Pimg');
        $info = $file->rule('uniqid')->move('C:\wamp64\www\WeChatShop\public\images');
            if ($info){
                $url=$info->getSaveName();
                $data =$url;
            }
            return $data;
    }

    public static function topicUpload(){
        $file = request()->file('topic_img');
        $info = $file->rule('uniqid')->move('C:\wamp64\www\WeChatShop\public\images');
        if ($info){

            $url=$info->getSaveName();
            $data=$url;
        }
        return $data;
    }

    public static function headUpload(){
        $file = request()->file('head_img');
        $info = $file->rule('uniqid')->move('C:\wamp64\www\WeChatShop\public\images');
        if ($info){

            $url=$info->getSaveName();
            $data=$url;
        }
        return $data;
    }



    public function getUrlAttr($value,$data){
        return $this->prefixImgUrl($value,$data);
    }



}