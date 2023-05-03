<?php
namespace Core;
class   Request
{
    public function getPath()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($path, '?');
        if($position !== false) {
            return $path = substr($path, 0, $position);
        }
        return $path;
    }

    public function getDeviceIP()
    {
        return $_SERVER['REMOTE_ADDR'];

    }

    public function method()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }
    public function isGet()
    {
        return $this->method() === 'get';
    }
    public function isPost()
    {
        return $this->method() === 'post';
    }

    public function getIP()
    {
        return $_SERVER['REMOTE_ADDR'];
    }

    private function is_Json($string) {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }
    public function getBody()
    {
        $body=[];
        if($this->method()=='get'){
            foreach ($_GET as $key => $value) {
                $body[$key]=filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        if($this->method()=='post'){

            foreach ($_POST as $key => $value) {
                if(is_array($value)){
                    $body[$key]=filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                }
                elseif (is_array(json_decode($value, true))){
                    foreach (json_decode($value, true) as $key1 => $value1) {
                        $body[$key][$key1]=$value1;
                    }
                }
                else {
                    $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }
            if (!empty($_FILES)){
                foreach ($_FILES as $key => $value) {
                    $body[$key]=new File($value);
                }
            }
//
//            if (isset($_FILES['file'])) {
//                $body['file'] =new File($_FILES['file']);
//            }
        }
        return $body;
    }

    public function getFile(string $string): File
    {
        return new File($_FILES[$string]);
    }


}