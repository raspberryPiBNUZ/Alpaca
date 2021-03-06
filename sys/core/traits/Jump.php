<?php

namespace core\traits;


trait Jump
{
    public static function success($msg='',$url='',$data=''){
        $code =1;
        if (is_numeric($msg)){
            $code =$msg;
            $msg='';
        }
        if (is_null($url)&& isset($_SERVER['HTTP_REFERER'])){
            $url=$_SERVER['HTTP_REFERER'];
        }
        $result=[
            'code'  =>  $code,
            'msg'   =>  $msg,
            'data'  =>  $data,
            'url'   =>  $url
        ];
        $output = "code:{$result['code']}\nmsg:{$result['msg']}\ndata:{$result['data']}\n";
        echo "<script>alert('$output');location.href='".$result['url']."'</script>";
        exit();
    }
    public static function error($msg='',$url='',$data=''){
        $code =0;
        if (is_numeric($msg)){
            $code =$msg;
            $msg='';
        }
        if (is_null($url)&& isset($_SERVER['HTTP_REFERER'])){
            $url=$_SERVER['HTTP_REFERER'];
        }
        $result=[
            'code'  =>  $code,
            'msg'   =>  $msg,
            'data'  =>  $data,
            'url'   =>  $url
        ];
        $output = "code:{$result['code']}\nmsg:{$result['msg']}\ndata:{$result['data']}\n";
        echo "<script>alert('$output');location.href='".$result['url']."'</script>";
        exit();
    }
}