<?php

namespace App\controller;

use Core\Controller;
use Core\Request;
use Core\Response;

class fileController extends Controller
{
    public function upload(Request $request, Response $response): string
    {
        if($request->isPost())
        {
            $file=$request->getFile('file');
            $file->saveFile();
        }
        return '';
    }

}