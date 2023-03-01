<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FilterajaxController extends Controller
{
    public function filteromc(Request $request)
    {
        if($request->search != null){
            $search = $request->search;
            $res = session()->get('DATA');
            $res = collect($res);
                        
            $res = $res->filter(function($item) use ($search) {
                return stripos($item['TtransporterName'],$search) !== false;
            });
    
            $rdata2 = [];
                
            foreach($res as $val){
                array_push($rdata2,$val['TtransporterName']);
            }
            
            $rdata = array_unique($rdata2);
    
            $data = view('common.filterdata.omcdata',compact('rdata'))->render();
    
            $response['data'] = $data;
            return $response;
        }
        
        $res = session()->get('DATA');
        $res = collect($res);


        $cnt = count($res);
        $rdata = [];
            
        for($i=0;$i<$cnt;$i++){
            array_push($rdata,$res[$i]['TtransporterName']);
        }
        
        $rdata = array_unique($rdata);

        $data = view('common.filterdata.omcdata',compact('rdata'))->render();

        $response['data'] = $data;
        return $response;
    }

    public function filtervehiclenum(Request $request)
    {
        if($request->search2 != null){
            $search2 = $request->search2;
            $res2 = session()->get('DATA');
            $res2 = collect($res2);
                        
            $res2 = $res2->filter(function($item) use ($search2) {
                return stripos($item['VehicleNumber'],$search2) !== false;
            });
    
            $rdata2 = [];
                
            foreach($res2 as $val){
                array_push($rdata2,$val['VehicleNumber']);
            }
            
            $rdata2 = array_unique($rdata2);
    
            $data2 = view('common.filterdata.vehiclenum',compact('rdata2'))->render();
    
            $response['data2'] = $data2;
            return $response;
        }
        
        $res2 = session()->get('DATA');
        $res2 = collect($res2);


        $cnt2 = count($res2);
        $rdata2 = [];
            
        for($i=0;$i<$cnt2;$i++){
            array_push($rdata2,$res2[$i]['VehicleNumber']);
        }
        
        $rdata2 = array_unique($rdata2);

        $data2 = view('common.filterdata.vehiclenum',compact('rdata2'))->render();

        $response['data2'] = $data2;
        return $response;
    }

    public function filtertypevehi(Request $request)
    {
        if($request->search3 != null){
            $search3 = $request->search3;
            $res3 = session()->get('DATA');
            $res3 = collect($res3);
                        
            $res3 = $res3->filter(function($item) use ($search3) {
                return stripos($item['AuditType'],$search3) !== false;
            });
    
            $rdata3 = [];
                
            foreach($res3 as $val){
                array_push($rdata3,$val['AuditType']);
            }
            
            $rdata3 = array_unique($rdata3);
    
            $data3 = view('common.filterdata.typevehicle',compact('rdata3'))->render();
    
            $response['data3'] = $data3;
            return $response;
        }
        
        $res3 = session()->get('DATA');
        $res3 = collect($res3);


        $cnt3 = count($res3);
        $rdata3 = [];
            
        for($i=0;$i<$cnt3;$i++){
            array_push($rdata3,$res3[$i]['AuditType']);
        }
        
        $rdata3 = array_unique($rdata3);

        $data3 = view('common.filterdata.typevehicle',compact('rdata3'))->render();

        $response['data3'] = $data3;
        return $response;
    }

    public function filterauditor(Request $request)
    {
        if($request->search4 != null){
            $search4 = $request->search4;
            $res4 = session()->get('DATA');
            $res4 = collect($res4);
                        
            $res4 = $res4->filter(function($item) use ($search4) {
                return stripos($item['OperatorName'],$search4) !== false;
            });
    
            $rdata4 = [];
                
            foreach($res4 as $val){
                array_push($rdata4,$val['OperatorName']);
            }
            
            $rdata4 = array_unique($rdata4);
    
            $data4 = view('common.filterdata.auditorty',compact('rdata4'))->render();
    
            $response['data4'] = $data4;
            return $response;
        }
        
        $res4 = session()->get('DATA');
        $res4 = collect($res4);


        $cnt4 = count($res4);
        $rdata4 = [];
            
        for($i=0;$i<$cnt4;$i++){
            array_push($rdata4,$res4[$i]['OperatorName']);
        }
        
        $rdata4 = array_unique($rdata4);

        $data4 = view('common.filterdata.auditorty',compact('rdata4'))->render();

        $response['data4'] = $data4;
        return $response;
    }
}
