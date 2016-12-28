<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 2016/12/12
 * Time: 17:48
 */

namespace App\Services\ApiServer\Response;

use Illuminate\Support\Facades\DB;
/**
 * api get Monitors
 */
class MonGet extends BaseResponse implements InterfaceResponse
{
    /**
     * 接口名称
     * @var string
     */
    protected $method = 'MonGet';

    /**
     * 执行接口
     * @param  array &$params 请求参数
     * @return array
     */
    public function run(&$params)
    {
        $data=null;
        $code = 200;
        $_data=DB::table('locations')
            ->join('companies','locations.company_id','=','companies.company_id')
            ->select('locations.location_id','companies.user','companies.password')
            ->where('location_id',$params['location_id'])
            ->first();
        if($_data){
            if(!empty($_data->user)){
                if($_data->user==$params['user'] && $_data->password==$params['password']){
                    $data=DB::table('monitors')
                        ->where('location_id',$params['location_id'])
                        ->select('monitor_id','name_en','reference_mon')
                        ->get();
                    $status = true;
                }else{
                    $code=1013;//用户名或密码错误
                    $status = false;
                }
            }else{
                $data=DB::table('monitors')
                    ->where('location_id',$params['location_id'])
                    ->select('monitor_id','name_en','reference_mon')
                    ->get();
                $status = true;
            }
        }else{
            $code = 1014;//Location_id 不存在
            $status = false;
        }

        return [
            'status' => $status,
            'code'   => $code,
            'data'   => $data
        ];
    }
}