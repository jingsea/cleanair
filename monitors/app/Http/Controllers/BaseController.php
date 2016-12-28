<?php
namespace App\Http\Controllers;

use Illuminate\Session;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

abstract class BaseController extends Controller
{
    protected $_request = [];

    /**
     * 初始化信息
     * @return boolean
     */
    protected function getParameter()
    {
        $this->_request = Request::all();
    }
    /**
     * 获取请求的数据
     */
    protected function request($key, $default = null)
    {
        return isset($this->_request[$key]) ? $this->_request[$key] : $default;
    }
    protected function getApiMsg($code)
    {
        return Lang::get('api.code.'.$code);
    }
    protected function outputData($code, $data = null, $msg = null)
    {
        $info = array(
            'code'  => $code,
            'data'  => $data,
            'msg'   => $msg
        );
        $this->output($info);
    }

    protected function output($info)
    {
        if(intval($info['code']) > 0)
        {
            $info['msg'] = $this->getApiMsg($info['code']);
        }
        unset($info);
        die();
    }



    protected function _outputData($code, $data = null, $msg = null)
    {
        $info = array(
            'code'  => $code,
            'data'  => $data,
            'msg'   => $msg
        );
        $this->_output($info);
    }
    /*
     * 用于session时
     * 由于session时 die()的话 烤session失效
     * */
    protected function _output($info)
    {
        if(intval($info['code']) > 0)
        {
            $info['msg'] = $this->getApiMsg($info['code']);
        }
        echo $_REQUEST['callback'].'('.json_encode($info).')';
        unset($info);
    }


}
