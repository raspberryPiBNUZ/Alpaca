<?php

namespace core;


class Router
{
    public $url_query;
    public $url_type;
    public $route_url=[];

    function __construct()
    {
        $this->url_query = parse_url($_SERVER['REQUEST_URI']);
        $this->route_url['module']=Config::get('default_module');
        $this->route_url['controller']=Config::get('default_controller');
        $this->route_url['action']=Config::get('default_action');
    }
    public function setUrlType($url_type=2){
        if ($url_type >0 && $url_type<3){
            $this->url_type = $url_type;
        }else{
            exit('Specifies the URL does not exist!');
        }
    }
    public function getUrlArray(){
        $this->makeUrl();
        return $this->route_url;
    }
    public function makeUrl(){
        switch ($this->url_type){
            case 1:
                $this->queryToArray();
                break;
            case 2:
                $this->pathinfoToArray();
                break;
        }
    }
    public function queryToArray(){
        $arr = !empty($this->url_query['query'])?explode('&',$this->url_query['query']):[];
        $array = $tmp = [];
        if (count($arr)>0){
            foreach ($arr as $item){
                $tmp = explode('=',$item);
                $array[$tmp[0]]=$tmp[1];
            }
            var_dump($array);
            if (isset($array['module'])){
                $this->route_url['module']=$array['module'];
                unset($array['module']);
            }
            if (isset($array['controller'])){
                $this->route_url['controller']=$array['controller'];
                unset($array['controller']);
            }
            if (isset($array['action'])){
                $this->route_url['action']=$array['action'];
                unset($array['action']);
            }

            if (isset($this->route_url['action'])&& strpos($this->route_url['action'],'.')){
                if (explode('.',$this->route_url['action'])[1]!=Config::get('url_html_suffix')){
                    exit('Suffix error');
                }else{
                    $this->route_url['action']=explode('.',$this->route_url['action'])[0];
                }
            }
        }else{
            $this->route_url= [];
        }
    }
    public function pathinfoToArray(){
        if(strpos($this->url_query['path'],"index.php")){
            $this->url_query['path']=strstr($this->url_query['path'],'index.php');
            $arr = !empty($this->url_query['path']) ? explode('/',$this->url_query['path']) : [];
            if (count($arr) > 0) {
                if ($arr[0] == 'index.php') {   //以 'localhost:8080/index.php'开始
                    if (isset($arr[1]) && !empty($arr[1])) {
                        $this->route_url['module'] = $arr[1];
                    }
                    if (isset($arr[2]) && !empty($arr[2])) {
                        $this->route_url['controller'] = $arr[2];
                    }
                    if (isset($arr[3]) && !empty($arr[3])) {
                        $this->route_url['action'] = $arr[3];
                    }
                    //判断url后缀名

                    if (isset($this->route_url['action']) && strpos($this->route_url['action'],'.')) {
                        if (explode('.',$this->route_url['action'])[1] != Config::get('url_html_suffix')) {
                            exit('Incorrect URL suffix');
                        } else {
                            $this->route_url['action'] = explode('.',$this->route_url['action'])[0];
                        }
                    }
                } else {                        //直接以 'localhost:8080'开始
                    if (isset($arr[1]) && !empty($arr[1])) {
                        $this->route_url['module'] = $arr[1];
                    }
                    if (isset($arr[2]) && !empty($arr[2])) {
                        $this->route_url['controller'] = $arr[2];
                    }
                    if (isset($arr[3]) && !empty($arr[3])) {
                        $this->route_url['action'] = $arr[3];
                    }
                }

            } else {
                $this->route_url = [];
            }
        }else{

        }



    }
}