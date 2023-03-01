<?php

namespace App\Http\Controllers;

use App\Exports\AuditorreportExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;

class AuditorController extends Controller
{
    public function auditor()
    {
        return view('auditor');
    }

    public function auditorfiltsub(Request $request)
    {
        if($request->startdate == null && $request->enddate == null ){
            return redirect()->route('auditor')->with('ERROR','PLease Select Date');;
        }else{
            $startdate = date('d-m-Y H:i:s', strtotime($request->startdate));
            $enddate = date('d-m-Y H:i:s', strtotime($request->enddate));

            $response_data = session()->get('DATA');
            
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
                    if($request->checkbox[$i] == $response_data[$j]['OperatorName']){
                        array_push($data2,$response_data[$j]);
                    }
                }
            }

            $response_data = $data2;
        }

        $i = 1;
        $response_data = collect($response_data);

        session()->put('AUDITOREX',$response_data);

        $rescheckauditor = [];
        $rescheckauditor = $request->checkbox;

        $daterange = date('d/m/Y', strtotime($request->startdate))." - ".date('d/m/Y', strtotime($request->enddate));

        return view('auditor',compact('response_data','i','startdate','enddate','rescheckauditor','daterange'));
    }

    public function auditorexportxls()
    {
        return Excel::download(new AuditorreportExport, 'Auditorreport.xls');
    }

    public function auditorexport()
    {
        return Excel::download(new AuditorreportExport, 'Auditorreport.csv');
    }

    public function auditorexportpdf()
    {
        $response_data = session()->get('AUDITOREX');
        $i = 1;

        $pdf = Pdf::loadView('exports.auditorreportex',compact('response_data','i'));
        
        return $pdf->download('Auditorreport.pdf');
    }

    public function auditormailsub(Request $request)
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
            return redirect()->route('auditor')->with('ERROR','Please Select One Option');
        }

        if($request->checkbox1['0'] == 'csv'){
            Excel::store(new AuditorreportExport, 'Auditorreport.csv');

            $file = storage_path('app/public/Auditorreport.csv');

            Mail::send('emails.mymail', $data, function($message)use($data, $file) {
                $message->to($data["email"])
                        ->subject($data["title"]);

                        $message->attach($file);          
            });

            File::delete($file);
        }

        if($request->checkbox1['0'] == 'xls'){
            Excel::store(new AuditorreportExport, 'Auditorreport.xls');

            $file = storage_path('app/public/Auditorreport.xls');

            Mail::send('emails.mymail', $data, function($message)use($data, $file) {
                $message->to($data["email"])
                        ->subject($data["title"]);

                        $message->attach($file);          
            });

            File::delete($file);
        }

        if($request->checkbox1['0'] == 'pdf'){
            $response_data = session()->get('AUDITOREX');
            $i = 1;

            $pdf = Pdf::loadView('exports.auditorreportex',compact('response_data','i'));

            Mail::send('emails.mymail', $data, function($message)use($data, $pdf) {
                $message->to($data["email"], $data["email"])->subject($data["title"])->attachData($pdf->output(),'Auditorreport.pdf');
            });
        }

        return redirect()->route('auditor');
    }
}
