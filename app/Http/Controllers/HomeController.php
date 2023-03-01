<?php

namespace App\Http\Controllers;

use App\Exports\DashboardExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    public function dashboardpage()
    {
        $response_data = session()->get('DATA');

        $response_data = collect($response_data)->groupBy('TtransporterName');
        
        $re = [];
        foreach($response_data as $res_data){
            array_push($re,$res_data->groupBy('AuditType'));
        }
        
        $response_data = $re;
        
        $cnt = count($response_data);

        $s = 1;
        $a = 1;
        $m = 1;
        $c = 1;
        session()->put('DASHBOARDEX',$response_data);
        
        return view('dashboardpage',compact('response_data','s','a','cnt','m','c'));
    }

    public function dashfiltsub(Request $request)
    {
        if ($request->startdate == null && $request->enddate == null) {
            return redirect()->route('dashboard')->with('ERROR', 'PLease Select Date');;
        } else {
            $startdate = date('d-m-Y H:i:s', strtotime($request->startdate));
            $enddate = date('d-m-Y H:i:s', strtotime($request->enddate));

            $response_data = session()->get('DATA');

            $data = [];
            $cnt = count($response_data);

            for ($i = 0; $i < $cnt; $i++) {
                if (strtotime($request->startdate) < strtotime($response_data[$i]['AuditStartDate']) && strtotime($request->enddate) > strtotime($response_data[$i]['AuditStartDate']) || strtotime($request->startdate) < strtotime($response_data[$i]['AuditEndDate']) && strtotime($request->enddate) > strtotime($response_data[$i]['AuditEndDate'])) {
                    array_push($data, $response_data[$i]);
                }
            }

            $TOTCHE = count($data);
            session()->put('TOTCHE',$TOTCHE);

            $data3 = [];
            for($i=0;$i<$TOTCHE;$i++){
                if($data[$i]['ManualApproved'] == '1'){
                    array_push($data3,$response_data[$i]);
                }
            }

            $APPR = count($data3);
            session()->put('APPR',$APPR);

            $REJE = $TOTCHE - $APPR;
            session()->put('REJE',$REJE);

            $response_data2 = collect($data)->groupBy('TtransporterName');

            $re2 = [];
            foreach($response_data2 as $res_data){
                array_push($re2,$res_data->groupBy('AuditType'));
            }
            
            $response_data2 = $re2;
        }

        session()->put('DASHBOARDEX',$response_data2);
        $s = 1;
        $a = 1;
        $m = 1;
        $c = 1;

        $daterange = date('d/m/Y', strtotime($request->startdate))." - ".date('d/m/Y', strtotime($request->enddate));

        return view('dashboardpage', compact('response_data2','s','a','m','c','startdate','enddate','daterange'));
    }

    public function dashboardexportxls()
    {
        return Excel::download(new DashboardExport, 'Dashboard.xls');
    }

    public function dashboardexport()
    {
        return Excel::download(new DashboardExport, 'Dashboard.csv');
    }

    public function dashboardexportpdf()
    {
        $response_data = session()->get('DASHBOARDEX');
        $s = 1;
        $a = 1;

        $pdf = Pdf::loadView('exports.dashboardex',compact('response_data','s','a'));
        
        return $pdf->download('Dashboard.pdf');
    }

    public function dashboardmailsub(Request $request)
    {
        $validate = $request->validate([
            'emailid' => 'required',
            'checkbox1' => 'required',
        ]);

        $data["email"] = $request->emailid;
        $data["title"] = "From nrlttsafety.locanix.net";
        $data["body"] = "Export Data";
        
        $cnt = count($request->checkbox1);
        if($cnt != '1'){
            return redirect()->route('dashboard')->with('ERROR','Please Select One Option');
        }

        if($request->checkbox1['0'] == 'csv'){
            Excel::store(new DashboardExport, 'Dashboard.csv');

            $file = storage_path('app/public/Dashboard.csv');

            Mail::send('emails.mymail', $data, function($message)use($data, $file) {
                $message->to($data["email"])
                        ->subject($data["title"]);

                        $message->attach($file);          
            });

            File::delete($file);
        }

        if($request->checkbox1['0'] == 'xls'){
            Excel::store(new DashboardExport, 'Dashboard.xls');

            $file = storage_path('app/public/Dashboard.xls');

            Mail::send('emails.mymail', $data, function($message)use($data, $file) {
                $message->to($data["email"])
                        ->subject($data["title"]);

                        $message->attach($file);          
            });

            File::delete($file);
        }

        if($request->checkbox1['0'] == 'pdf'){
            $response_data = session()->get('DASHBOARDEX');
            $s = 1;
            $a = 1;

            $pdf = Pdf::loadView('exports.dashboardex',compact('response_data','s','a'));

            Mail::send('emails.mymail', $data, function($message)use($data, $pdf) {
                $message->to($data["email"], $data["email"])->subject($data["title"])->attachData($pdf->output(),'Dashboard.pdf');
            });
        }

        return redirect()->route('dashboard');

    }
}
