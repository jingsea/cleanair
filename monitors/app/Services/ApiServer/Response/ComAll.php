<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 2016/12/12
 * Time: 16:28
 */

namespace App\Services\ApiServer\Response;

use App\Models\Compaines;

class ComAll extends BaseResponse implements InterfaceResponse
{
    /**
     * 接口名称
     * @var string
     */
    protected $method = 'ComAll';

    /**
     * 执行接口
     * @param  array &$params 请求参数
     * @return array
     */
    public function run(&$params)
    {
        $data=Compaines::select('company_id','name_en','secure')->get();
        return [
            'status' => true,
            'code'   => '200',
            'data'   => $data
        ];
    }
}