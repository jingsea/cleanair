<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 2016/12/13
 * Time: 10:56
 */

namespace App\Services\ApiServer\Response;

use Illuminate\Support\Facades\DB;

class LatGet extends BaseResponse implements InterfaceResponse
{
    /**
     * 接口名称
     * @var string
     */
    protected $method = 'LatGet';

    /**
     * 执行接口
     * @param  array &$params 请求参数
     * @return array
     */
    public function run(&$params)
    {
        $data=null;
        $code = 200;
        $_data=DB::table('monitors')
            ->join('locations','locations.location_id','=','monitors.location_id')
            ->join('companies','locations.company_id','=','companies.company_id')
            ->select('monitors.monitor_id','companies.user','companies.password')
            ->where('monitor_id',$params['monitor_id'])
            ->first();
        if($_data){
            if(!empty($_data->user)){
                if($_data->user==$params['user'] && $_data->password==$params['password']){
                    $data=DB::table('readings_latest')
                        ->where('monitor_id',$params['monitor_id'])
                        ->select('monitor_id','reading','temperature','humidity','tvoc','co2','co')
                        ->orderBy('date_reading','desc')
                        ->first();
                    $status = true;
                }else{
                    $code=1013;//用户名或密码错误
                    $status = false;
                }
            }else{
                $data=DB::table('readings_latest')
                    ->where('monitor_id',$params['monitor_id'])
                    ->select('monitor_id','reading','temperature','humidity','tvoc','co2','co')
                    ->orderBy('date_reading','desc')
                    ->first();
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