<?php

namespace App\Http\Controllers;

use App\Exports\AnomalyreportExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File; 

class AnomalyreportController extends Controller
{
    public function anomalyreport()
    {

        return view('anomalyreport');
    }

    public function anomalyreportfiltsub(Request $request)
    {
        if($request->startdate == null && $request->enddate == null ){
            return redirect()->route('anomalyreport')->with('ERROR','PLease Select Date');
        }else{
            $startdate = date('d-m-Y H:i:s', strtotime($request->startdate));
            $enddate = date('d-m-Y H:i:s', strtotime($request->enddate));

            $response_datamain = session()->get('DATA');
            $response_data = session()->get('DATAANOMALYAPI');
            
            $data = [];
            $cnt = count($response_data);
            
            for($i=0;$i<$cnt;$i++){
                if(strtotime($request->startdate) < strtotime($response_data[$i]['AuditStartDate']) && strtotime($request->enddate) > strtotime($response_data[$i]['AuditStartDate']) || strtotime($request->startdate) < strtotime($response_data[$i]['AuditEndDate']) && strtotime($request->enddate) > strtotime($response_data[$i]['AuditEndDate'])){
                    array_push($data,$response_data[$i]);
                }
            }

            $response_data = $data;
        }

        $data2 = [];
        if($request->checkbox != null){
            $cnt2 = count($request->checkbox);
            for($i=0;$i<$cnt2;$i++){
                $cnt3 = count($response_data);
                for($j=0;$j<$cnt3;$j++){
                    if($request->checkbox[$i] == $response_data[$j]['TtransporterName']){
                        array_push($data2,$response_data[$j]);
                    }
                }
            }

            $response_data = $data2;
        }

        $data3 = [];
        if($request->checkbox2 != null){
            $cnt3 = count($request->checkbox2);
            for($i=0;$i<$cnt3;$i++){
                $cnt4 = count($response_data);
                for($j=0;$j<$cnt4;$j++){
                    if($request->checkbox2[$i] == $response_data[$j]['AuditType']){
                        array_push($data3,$response_data[$j]);
                    }
                }
            }

            $response_data = $data3;
        }

        $i = 1;
        session()->put('ANOMALYEX',$response_data);

        $DATERANGE = date('d/m/Y', strtotime($request->startdate))." - ".date('d/m/Y', strtotime($request->enddate));
        session()->put('DATERANGE',$DATERANGE);

        $rescheckomc = [];
        $rescheckomc = $request->checkbox;

        $reschecktypevehi = [];
        $reschecktypevehi = $request->checkbox2;

        return view('anomalyreport',compact('response_data','i','response_datamain','startdate','enddate','DATERANGE','rescheckomc','reschecktypevehi'));

    }

    public function anomalyexportxls()
    {
        return Excel::download(new AnomalyreportExport, 'Anomalyreport.xls');
    }

    public function anomalyexport()
    {
        return Excel::download(new AnomalyreportExport, 'Anomalyreport.csv');
    }

    public function anomalyexportpdf()
    {
        $response_data = session()->get('ANOMALYEX');
        $response_datamain = session()->get('DATA');
        $daterange = session()->get('DATERANGE');
        $i = 1;

        $pdf = Pdf::loadView('exports.anomalyreportexpdf',compact('response_data','response_datamain','daterange','i'))->setPaper('a4', 'landscape');
        $pdf->getDomPDF()->set_option("enable_php", true);
        
        return $pdf->download('Anomalyreport.pdf');
    }

    public function anomalymailsub(Request $request)
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
            return redirect()->route('anomalyreport')->with('ERROR','Please Select One Option');
        }

        if($request->checkbox1['0'] == 'csv'){
            Excel::store(new AnomalyreportExport, 'Anomalyreport.csv');

            $file = storage_path('app/public/Anomalyreport.csv');

            Mail::send('emails.mymail', $data, function($message)use($data, $file) {
                $message->to($data["email"])
                        ->subject($data["title"]);

                        $message->attach($file);          
            });

            File::delete($file);
        }

        if($request->checkbox1['0'] == 'xls'){
            Excel::store(new AnomalyreportExport, 'Anomalyreport.xls');

            $file = storage_path('app/public/Anomalyreport.xls');

            Mail::send('emails.mymail', $data, function($message)use($data, $file) {
                $message->to($data["email"])
                        ->subject($data["title"]);

                        $message->attach($file);          
            });

            File::delete($file);
        }

        if($request->checkbox1['0'] == 'pdf'){
            $response_data = session()->get('ANOMALYEX');
            $response_datamain = session()->get('DATA');
            $daterange = session()->get('DATERANGE');
            $i = 1;

            $pdf = Pdf::loadView('exports.anomalyreportexpdf',compact('response_data','response_datamain','daterange','i'))->setPaper('a4', 'landscape');
            $pdf->getDomPDF()->set_option("enable_php", true);

            Mail::send('emails.mymail', $data, function($message)use($data, $pdf) {
                $message->to($data["email"], $data["email"])->subject($data["title"])->attachData($pdf->output(),'Anomalyreport.pdf');
            });
        }

        return redirect()->route('anomalyreport');
    }
}
