<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ApiServer\Server;
use App\Services\ApiServer\Error;


class ServerController extends Controller
{
    /**
     * API总入口
     * @return [type] [description]
     */
    public function index()
    {
        $server = new Server(new Error);
        return $server->run();
    }
    /**
     * get company
     * REQUEST: Customers
     * Response: JSON: company_id, name_en, secure
     */
    public function getAll(Request $request)
    {
        $request=$request->input();
        $data = Service::getCompany($request);
        return $data;
//        dd($data);
    }
    /**
     * get company
     * REQUEST: Customers
     * Response: JSON: company_id, name_en, secure
     */
    public function getCompany(Request $request)
    {
        $request=$request->input();
        $data = Service::getCompany($request);
        return $data;
//        dd($data);
    }
//
    /**
     * get locations
     * REQUEST: company_id, user, password
     * Response: JSON: location_id, name_en
     */

   public function getLocation(Request $request)
    {
       $request=$request->input();
       $data = Service::getLocation($request);
        return $data;
//       dd($data);
    }

    /**
     * get monitors
     * REQUEST: location_id, user, password
     * Response: JSON: monitor_id, name_en, reference_mon
     */
    public function getMonitors(Request $request)
    {
        $request=$request->input();
        $data = Service::getMonitors($request);
        return $data;
//        dd($data);
    }

    /**
     * get Latest_Info
     * REQUEST: monitor_id, user, password
     * Response: JSON: monitor_id, reading, temperature, humidity, tvoc, co2, co
     */
    public function getLatest(Request $request)
    {
        $request=$request->input();
        $data = Service::getLatest($request);
        return $data;
//        dd($data);
    }


}
