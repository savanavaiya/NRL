<?php

namespace App\Http\Controllers;

use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;

class LoginController extends Controller
{
    public function loginpage()
    {
        return view('loginpage');
    }

    public function loginsub(Request $request)
    {
        // dd($request->all());
        
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){

            $client = new Client();

            $res = $client->request('GET', 'https://apps2.locanix.net/custom/tt-safety/api/safetyaudit/get-audit-repot',['headers' => ['token' => 'eyJBcHBJZCI6MCwiQ3JlYXRlZERhdGUiOiIyMDIyLTAzLTE1VDE0OjU1OjQyLjk5OTYyNDYrMDU6MzAiLCJHZ3NUb2tlbiI6IiIsIlVzZXJuYW1lIjoiODg4ODg4ODgtMTIzIn0=']]);

            if ($res->getStatusCode() == 200) { // 200 OK
                $response_data = json_decode($res->getBody(),true);
                $response_data = $response_data['Data'];
                // dd($response_data['0']['Id']);
            }

            $c = count($response_data);
            for($i=0;$i<$c;$i++){
                $dt = new DateTime($response_data[$i]['AuditStartDate']);

                $tz = new DateTimeZone('Asia/Kolkata');
    
                $dt->setTimezone($tz);
                
                $response_data[$i]['AuditStartDate'] = $dt->format('Y-m-d H:i:s');
                
                
                
                $dt = new DateTime($response_data[$i]['AuditEndDate']);

                $tz = new DateTimeZone('Asia/Kolkata');
    
                $dt->setTimezone($tz);
                
                $response_data[$i]['AuditEndDate'] = $dt->format('Y-m-d H:i:s');
            }


            $TOTALCHECK = count($response_data);
            session()->put('TOTALCHECK',$TOTALCHECK);

            $data = [];
            for($i=0;$i<$TOTALCHECK;$i++){
                if($response_data[$i]['ManualApproved'] == '1'){
                    array_push($data,$response_data[$i]);
                }
            }

            $APPROVE = count($data);
            session()->put('APPROVE',$APPROVE);

            $REJECT = $TOTALCHECK - $APPROVE;
            session()->put('REJECT',$REJECT);

            $i = 1;

            session()->put('DATA',$response_data);


            $client2 = new Client();

            $res2 = $client2->request('GET', 'https://apps2.locanix.net/custom/tt-safety/api/safetyaudit/get-anomaly-report',['headers' => ['token' => 'eyJBcHBJZCI6MCwiQ3JlYXRlZERhdGUiOiIyMDIyLTAzLTE1VDE0OjU1OjQyLjk5OTYyNDYrMDU6MzAiLCJHZ3NUb2tlbiI6IiIsIlVzZXJuYW1lIjoiODg4ODg4ODgtMTIzIn0=']]);

            if ($res2->getStatusCode() == 200) { // 200 OK
                $response_dataanomalyapi = json_decode($res2->getBody(),true);
                $response_dataanomalyapi = $response_dataanomalyapi['Data'];
            }


            $cn2 = count($response_dataanomalyapi);
            for($i=0;$i<$cn2;$i++){
                $dt2 = new DateTime($response_dataanomalyapi[$i]['AuditStartDate']);

                $tz2 = new DateTimeZone('Asia/Kolkata');
    
                $dt2->setTimezone($tz2);
                
                $response_dataanomalyapi[$i]['AuditStartDate'] = $dt2->format('Y-m-d H:i:s');
                
                
                
                $dt2 = new DateTime($response_dataanomalyapi[$i]['AuditEndDate']);

                $tz2 = new DateTimeZone('Asia/Kolkata');
    
                $dt2->setTimezone($tz2);
                
                $response_dataanomalyapi[$i]['AuditEndDate'] = $dt2->format('Y-m-d H:i:s');
            }

            session()->put('DATAANOMALYAPI',$response_dataanomalyapi);



            return redirect()->route('dashboard');
        }else{
            return redirect()->back();
        }

    }

    public function logout()
    {
        session()->flush();
        Auth::logout();

        return redirect()->route('login');
    }
}
