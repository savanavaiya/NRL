<?php

namespace App\Http\Controllers;

use App\Exports\MonthlybillingExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;

class MonthlybillingController extends Controller
{
    public function monthlybilling()
    {
        $response_data = session()->get('DATA');
        $data = session()->get('DATA');
        $cnt = count($response_data);

        for ($i = 0; $i < $cnt; $i++) {
            $response_data[$i]['AuditStartDate'] = date('d-m-Y', strtotime($data[$i]['AuditStartDate']));
        }

        $response_data = collect($response_data)->groupBy('AuditStartDate');
        session()->put('MONTHLYBILLINGEX',$response_data);

        $i = 1;
        return view('monthlybilling', compact('response_data', 'i'));
    }

    public function monthbillfiltrsub(Request $request)
    {
        if ($request->startdate == null && $request->enddate == null) {
            return redirect()->route('monthlybilling')->with('ERROR', 'PLease Select Date');;
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

            $TOTCHEMO = count($data);
            session()->put('TOTCHEMO',$TOTCHEMO);

            $data3 = [];
            for($i=0;$i<$TOTCHEMO;$i++){
                if($data[$i]['ManualApproved'] == '1'){
                    array_push($data3,$response_data[$i]);
                }
            }

            $APPRMO = count($data3);
            session()->put('APPRMO',$APPRMO);

            $REJEMO = $TOTCHEMO - $APPRMO;
            session()->put('REJEMO',$REJEMO);

            $response_data2 = $data;

            $cnt2 = count($response_data2);

            for ($i = 0; $i < $cnt2; $i++) {
                $response_data2[$i]['AuditStartDate'] = date('d-m-Y', strtotime($data[$i]['AuditStartDate']));
            }

            $response_data2 = collect($response_data2)->groupBy('AuditStartDate');
        }

        session()->put('MONTHLYBILLINGEX',$response_data2);

        $i = 1;

        $daterange = date('d/m/Y', strtotime($request->startdate))." - ".date('d/m/Y', strtotime($request->enddate));

        return view('monthlybilling', compact('response_data2','i','startdate','enddate','daterange'));
    }

    public function monthlybillingexxls()
    {
        return Excel::download(new MonthlybillingExport, 'Monthlybilling.xls');
    }

    public function monthlybillingex()
    {
        return Excel::download(new MonthlybillingExport, 'Monthlybilling.csv');
    }

    public function monthlybillingexpdf()
    {
        $response_data = session()->get('MONTHLYBILLINGEX');
        $i = 1;

        $pdf = Pdf::loadView('exports.monthlybillingex',compact('response_data','i'));
        
        return $pdf->download('Monthlybilling.pdf');
    }

    public function monthlybillingmailsub(Request $request)
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
            return redirect()->route('monthlybilling')->with('ERROR','Please Select One Option');
        }


        if($request->checkbox1['0'] == 'csv'){
            Excel::store(new MonthlybillingExport, 'Monthlybilling.csv');

            $file = storage_path('app/public/Monthlybilling.csv');

            Mail::send('emails.mymail', $data, function($message)use($data, $file) {
                $message->to($data["email"])
                        ->subject($data["title"]);

                        $message->attach($file);          
            });

            File::delete($file);
        }

        if($request->checkbox1['0'] == 'xls'){
            Excel::store(new MonthlybillingExport, 'Monthlybilling.xls');

            $file = storage_path('app/public/Monthlybilling.xls');

            Mail::send('emails.mymail', $data, function($message)use($data, $file) {
                $message->to($data["email"])
                        ->subject($data["title"]);

                        $message->attach($file);          
            });

            File::delete($file);
        }

        if($request->checkbox1['0'] == 'pdf'){
            $response_data = session()->get('MONTHLYBILLINGEX');
            $i = 1;

            $pdf = Pdf::loadView('exports.monthlybillingex',compact('response_data','i'));

            Mail::send('emails.mymail', $data, function($message)use($data, $pdf) {
                $message->to($data["email"], $data["email"])->subject($data["title"])->attachData($pdf->output(),'Monthlybilling.pdf');
            });
        }

        return redirect()->route('monthlybilling');
    }
}
