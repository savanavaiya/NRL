<?php

namespace App\Http\Controllers;

use App\Exports\VehiclehistoryExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;

class VehiclehistoryController extends Controller
{
    public function vehiclehistory()
    {
        return view('vehiclehistory');
    }

    public function vehiclehisfilsub(Request $request)
    {

        if($request->checkbox1 == null){
            return redirect()->route('vehiclehistory')->with('ERROR','Please Select Option');
        }else{
            $c = count($request->checkbox1);
            if($c != 1){
                return redirect()->route('vehiclehistory')->with('ERROR','Please Select One Vehicle Number');
            }

            $response_data = session()->get('DATA');
            if($request->checkbox1 != null){
                $data = [];
                $cnt = count($request->checkbox1);
                for($i=0;$i<$cnt;$i++){
                    $cnt1 = count($response_data);
                    for($j=0;$j<$cnt1;$j++){
                        if($request->checkbox1[$i] == $response_data[$j]['VehicleNumber']){
                            array_push($data,$response_data[$j]);
                        }
                    }
                }

                $response_data = $data;
            }

            if($request->checkbox != null){
                $data2 = [];
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
        }

        session()->put('VEHICLEHISEX',$response_data);

        $i = 1;
        $response_data = collect($response_data);

        //heading columns
        $vehinum = $request->checkbox1['0'];
        $client = new Client();

        $res = $client->request('GET', 'https://apps2.locanix.net/custom/tt-safety/api/safetyaudit/get-last-audit?vehicleNumber='.$vehinum,['headers' => ['token' => 'eyJBcHBJZCI6MCwiQ3JlYXRlZERhdGUiOiIyMDIyLTAzLTE1VDE0OjU1OjQyLjk5OTYyNDYrMDU6MzAiLCJHZ3NUb2tlbiI6IiIsIlVzZXJuYW1lIjoiODg4ODg4ODgtMTIzIn0=']]);

        if ($res->getStatusCode() == 200) { // 200 OK
            $responseapi2 = json_decode($res->getBody(),true);
            $responseapi2 = $responseapi2['Data'];
            // dd($response_data['0']['Id']);
        }

        $lastcheckedon = $responseapi2['CreatedOn'];
        $lastcheckedon = date('d M y', strtotime($lastcheckedon));

        $nextdueondate = date('d M y', strtotime($lastcheckedon.' + 45 days'));
        $currentdata = date('d M y');
        
        if($currentdata < $nextdueondate){
            if($responseapi2['Status'] == 'Approved'){
                $status = 'Valid';
            }else{
                $status = 'Invalid';
                $nextdueondate = 'Immediate';
            }
        }else{
            $status = 'Invalid';
            $nextdueondate = 'Immediate';
        }

        $restcheckvehiclenum = [];
        $restcheckvehiclenum = $request->checkbox1;

        $restcheckomc = [];
        $restcheckomc = $request->checkbox;


        return view('vehiclehistory',compact('response_data','i','lastcheckedon','nextdueondate','status','restcheckvehiclenum','restcheckomc'));
    }

    public function exportvehiclhistxls()
    {
        return Excel::download(new VehiclehistoryExport, 'Vehiclehistory.xls');
    }

    public function exportvehiclhist()
    {
        return Excel::download(new VehiclehistoryExport, 'Vehiclehistory.csv');
    }

    public function exportvehiclhistpdf()
    {
        $response_data = session()->get('VEHICLEHISEX');
        $i = 1;

        $pdf = Pdf::loadView('exports.vehiclehistoryex',compact('response_data','i'))->setPaper('a4', 'landscape');
        
        return $pdf->download('Vehiclehistory.pdf');
    }

    public function vehiclehistmailsub(Request $request)
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
            return redirect()->route('vehiclehistory')->with('ERROR','Please Select One Option');
        }

        if($request->checkbox1['0'] == 'csv'){
            Excel::store(new VehiclehistoryExport, 'Vehiclehistory.csv');

            $file = storage_path('app/public/Vehiclehistory.csv');

            Mail::send('emails.mymail', $data, function($message)use($data, $file) {
                $message->to($data["email"])
                        ->subject($data["title"]);

                        $message->attach($file);          
            });

            File::delete($file);
        }

        if($request->checkbox1['0'] == 'xls'){
            Excel::store(new VehiclehistoryExport, 'Vehiclehistory.xls');

            $file = storage_path('app/public/Vehiclehistory.xls');

            Mail::send('emails.mymail', $data, function($message)use($data, $file) {
                $message->to($data["email"])
                        ->subject($data["title"]);

                        $message->attach($file);          
            });

            File::delete($file);
        }

        if($request->checkbox1['0'] == 'pdf'){
            $response_data = session()->get('VEHICLEHISEX');
            $i = 1;

            $pdf = Pdf::loadView('exports.vehiclehistoryex',compact('response_data','i'))->setPaper('a4', 'landscape');

            Mail::send('emails.mymail', $data, function($message)use($data, $pdf) {
                $message->to($data["email"], $data["email"])->subject($data["title"])->attachData($pdf->output(),'Vehiclehistory.pdf');
            });
        }

        return redirect()->route('vehiclehistory');
    }
}
