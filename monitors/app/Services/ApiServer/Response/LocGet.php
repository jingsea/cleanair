<?php
namespace App\Services\ApiServer\Response;

use App\Models\Compaines;
use App\Models\Locations;


/**
 * api get Location
 */
class LocGet extends BaseResponse implements InterfaceResponse
{
    /**
     * 接口名称
     * @var string
     */
    protected $method = 'LocGet';

    /**
     * 执行接口
     * @param  array &$params 请求参数
     * @return array          
     */
    public function run(&$params)
    {
        $data=null;
        $code = 200;
        $_data=Compaines::where('company_id',$params['company_id'])
            ->select('user','password','company_id')
            ->first();
//        dd($_data);
        if($_data){
            if(!empty($_data->user)){
                if($_data->user==$params['user'] && $_data->password==$params['password']){
                    $data=Locations::where('company_id',$params['company_id'])
                        ->select('location_id','name_en')
                        ->get();
                    $status = true;
                }else{
                    $code=1013;//用户名或密码错误
                    $status = false;
                }
            }else{
                $data=Locations::where('company_id',$params['company_id'])
                    ->select('location_id','name_en')
                    ->get();
                $status = true;
            }
        }else{
            $code = 1014;//company_id 不存在
            $status = false;
        }

        return [
            'status' => $status,
            'code'   => $code,
            'data'   => $data
        ];
    }
}