<?php

namespace App\Http\Controllers;

use App\Exports\DetailauditExport;
use App\Exports\UsersExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;

class DetailauditController extends Controller
{
    public function detailedaudit()
    {

        $response_data = session()->get('DATA');

        session()->put('DETAILAUDITEX',$response_data);
        $i = 1;

        return view('detailedaudit',compact('response_data','i'));
    }

    public function detailauditfiltsub(Request $request)
    {
        if($request->startdate == null && $request->enddate == null ){
            return redirect()->route('detailedaudit')->with('ERROR','PLease Select Date');;
        }else{
            $startdate = date('d-m-Y H:i:s', strtotime($request->startdate));
            $enddate = date('d-m-Y H:i:s', strtotime($request->enddate));

            $response_data2 = session()->get('DATA');
            
            $data = [];
            $cnt = count($response_data2);
            
            for($i=0;$i<$cnt;$i++){
                if(strtotime($request->startdate) < strtotime($response_data2[$i]['AuditStartDate']) && strtotime($request->enddate) > strtotime($response_data2[$i]['AuditStartDate']) || strtotime($request->startdate) < strtotime($response_data2[$i]['AuditEndDate']) && strtotime($request->enddate) > strtotime($response_data2[$i]['AuditEndDate']) ){
                    array_push($data,$response_data2[$i]);
                }
            }

            $response_data2 = $data;
        }

        $data2 = [];
        if($request->checkbox != null){
            $cnt2 = count($request->checkbox);
            for($i=0;$i<$cnt2;$i++){
                $cnt3 = count($response_data2);
                for($j=0;$j<$cnt3;$j++){
                    if($request->checkbox[$i] == $response_data2[$j]['TtransporterName']){
                        array_push($data2,$response_data2[$j]);
                    }
                }
            }

            $response_data2 = $data2;
        }

        $i = 1;

        session()->put('DETAILAUDITEX',$response_data2);

        $rescheckomc = [];
        $rescheckomc = $request->checkbox;

        $daterange = date('d/m/Y', strtotime($request->startdate))." - ".date('d/m/Y', strtotime($request->enddate));

        return view('detailedaudit',compact('response_data2','i','startdate','enddate','rescheckomc','daterange'));
    }

    public function xlsexportdetaudit()
    {
        return Excel::download(new DetailauditExport, 'Detailaudit.xls');
    }

    public function exportdetaudit()
    {
        return Excel::download(new DetailauditExport, 'Detailaudit.csv');
    }

    public function pdfexportdetaudit()
    {
        $response_data = session()->get('DETAILAUDITEX');
        $i = 1;

        $pdf = Pdf::loadView('exports.detailauditex',compact('response_data','i'))->setPaper('a4', 'landscape');
        
        return $pdf->download('Detailaudit.pdf');
    }

    public function detailauditmailsub(Request $request)
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
            return redirect()->route('detailedaudit')->with('ERROR','Please Select One Option');
        }

        if($request->checkbox1['0'] == 'csv'){
            Excel::store(new DetailauditExport, 'Detailaudit.csv');

            $file = storage_path('app/public/Detailaudit.csv');

            Mail::send('emails.mymail', $data, function($message)use($data, $file) {
                $message->to($data["email"])
                        ->subject($data["title"]);

                        $message->attach($file);          
            });

            File::delete($file);
        }

        if($request->checkbox1['0'] == 'xls'){
            Excel::store(new DetailauditExport, 'Detailaudit.xls');

            $file = storage_path('app/public/Detailaudit.xls');

            Mail::send('emails.mymail', $data, function($message)use($data, $file) {
                $message->to($data["email"])
                        ->subject($data["title"]);

                        $message->attach($file);          
            });

            File::delete($file);
        }

        if($request->checkbox1['0'] == 'pdf'){
            $response_data = session()->get('DETAILAUDITEX');
            $i = 1;

            $pdf = Pdf::loadView('exports.detailauditex',compact('response_data','i'))->setPaper('a4', 'landscape');

            Mail::send('emails.mymail', $data, function($message)use($data, $pdf) {
                $message->to($data["email"], $data["email"])->subject($data["title"])->attachData($pdf->output(),'Detailaudit.pdf');
            });
        }

        return redirect()->route('detailedaudit');
    }

    public function viewaspdfdetailaudit()
    {
        $response_data = session()->get('DETAILAUDITEX');
        $i = 1;

        $pdf = Pdf::loadView('exports.detailauditex',compact('response_data','i'))->setPaper('a4', 'landscape');
        
        return $pdf->stream();
    }
}
