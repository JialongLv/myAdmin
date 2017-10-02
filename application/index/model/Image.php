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
//
//        public function upload(){
//
//             $files = request()->file('Pimg');
////                    var_dump($files);die;
//            $data = array();
//            foreach($files as $file){
//////                var_dump($file);die;
////                $file = $files[];
//                $info = $file->rule('uniqid')->move('C:\wamp64\www\WeChatShop\public\images');
////                $data['url'] = $info ;
//                if ($info) {
////                     $data = array();
//                     $url=$info->getSaveName();
//                     $data[]=$url;
//
//                }
//            }
//
//           return $data;
//        };




    public function getUrlAttr($value,$data){
        return $this->prefixImgUrl($value,$data);
    }

}