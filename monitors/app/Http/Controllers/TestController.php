<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class TestController extends Controller
{
    public function index(Request $request)
    {
        //匹配request/*的URL才能继续访问
        if(!$request->is('request/*')){
          abort(404);
       }
        $uri = $request->path();
        $url = $request->url();
        echo $uri;
        echo '<br>';
        echo $url;
    }
}
