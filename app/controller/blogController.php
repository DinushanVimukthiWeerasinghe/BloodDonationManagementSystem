<?php

namespace App\controller;

use App\model\Blog\Blog;
use Core\Controller;
use Core\Request;
use Core\Response;

class blogController extends Controller
{
    public function __construct()
    {
//        TODO Add Admin Privilege
    }

    public function AddBlog(Request $request,Response $response)
    {
        if ($request->isPost()){
            $Blog=new Blog();
            $Blog->setBlogTitle($request->getBody()['Blog_Title']);
            $Blog->setBlogContent($request->getBody()['Blog_Content']);
            $BlogImage=$request->getBody()['Blog_Image'];
            $BlogImage->setPathPrefix('Blog');
            $BlogImage->generateFileName('Blog_');
            $Blog->setBlogImage($BlogImage->getFileName());
            if ($Blog->save()){
                $BlogImage->saveFile();
                return json_encode(['status' => true, 'message' => 'Blog Added Successfully']);
            }else{
                return json_encode(['status' => false, 'message' => 'Blog Added Failed']);
            }
        }
    }

    public function DeleteBlog(Request $request,Response $response)
    {
        if ($request->isPost()){
            $BlogID=$request->getBody()['Blog_ID'];
            if (Blog::DeleteOne(['Blog_ID'=>$BlogID])){
                return json_encode(['status' => true, 'message' => 'Blog Deleted Successfully']);
            }else{
                return json_encode(['status' => false, 'message' => 'Blog Deleted Failed']);
            }
        }
    }

    public function UpdateBlog(Request $request,Response $response)
    {
        if ($request->isPost()){
            $BlogID=$request->getBody()['Blog_ID'];
            $Blog=new Blog();
            $Blog->setBlogTitle($request->getBody()['Blog_Title']);
            $Blog->setBlogContent($request->getBody()['Blog_Content']);
            $BlogImage=$request->getBody()['Blog_Image'];
            $BlogImage->setPathPrefix('Blog');
            $BlogImage->generateFileName('Blog_');
            $Blog->setBlogImage($BlogImage->getFileName());
            if ($Blog->update(['Blog_ID'=>$BlogID])){
                $BlogImage->saveFile();
                return json_encode(['status' => true, 'message' => 'Blog Updated Successfully']);
            }else{
                return json_encode(['status' => false, 'message' => 'Blog Updated Failed']);
            }
        }
    }

}