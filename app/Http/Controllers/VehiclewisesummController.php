<?php

namespace App\Http\Controllers;

use App\Exports\VehiclewisesummExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;

class VehiclewisesummController extends Controller
{
    public function vehiclewisesum()
    {
        if(session()->has('daterange') || session()->has('rescheckvehinum') || session()->has('reschecktypevehi') || session()->has('rescheckomc') ){
            session()->forget('daterange');
            session()->forget('rescheckvehinum');
            session()->forget('reschecktypevehi');
            session()->forget('rescheckomc');
        }

        return view('vehiclewisesum');
    }


    public function vehiclewisesumajax()
    {
        $response_data = session()->get('DATA');
        $response_data = collect($response_data);
        $response_data = $response_data->unique('VehicleNumber');


        session()->put('VEHICLEWISESUMMEX',$response_data);

        $res = session()->get('DATA');

        $res = collect($res);
        $i = 1;

        session()->put('VEHICLEWISESUMMEX2',$res);

        $datares = view('datavehiclewise',compact('response_data','i','res'))->render();
        $response['datares'] = $datares;
        return $response;

        // return view('vehiclewisesum',compact('response_data','i','res'));
    }

    public function vehiclewisesummfilsub(Request $request)
    {
        if($request->startdate == null && $request->enddate == null ){
            return redirect()->route('vehiclewisesum')->with('ERROR','PLease Select Date');;
        }else{
            $startdate = date('d-m-Y', strtotime($request->startdate));
            $enddate = date('d-m-Y', strtotime($request->enddate));

            $response_data2 = session()->get('DATA');
            
            $data = [];
            
            foreach($response_data2 as $res){
                if(strtotime($request->startdate) < strtotime($res['AuditStartDate']) && strtotime($request->enddate) > strtotime($res['AuditStartDate']) || strtotime($request->startdate) < strtotime($res['AuditEndDate']) && strtotime($request->enddate) > strtotime($res['AuditEndDate'])){
                    array_push($data,$res);
                }
            }

            $response_data2 = $data;


            if($request->checkbox2 != null){
                $data1 = [];
                $cnt1 = count($request->checkbox2);
                for($i=0;$i<$cnt1;$i++){
                    
                    foreach($response_data2 as $res){
                        if($request->checkbox2[$i] == $res['AuditType']){
                            array_push($data1,$res);
                        }
                    }
                }

                $response_data2 = $data1;
            }

            if($request->checkbox != null){
                $data2 = [];
                $cnt3 = count($request->checkbox);
                for($i=0;$i<$cnt3;$i++){
                    
                    foreach($response_data2 as $res){
                        if($request->checkbox[$i] == $res['TtransporterName']){
                            array_push($data2,$res);
                        }
                    }
                }

                $response_data2 = $data2;
            }

            if($request->checkbox1 != null){
                $data3 = [];
                $cnt5 = count($request->checkbox1);
                for($i=0;$i<$cnt5;$i++){
                    
                    foreach($response_data2 as $res){
                        if($request->checkbox1[$i] == $res['VehicleNumber']){
                            array_push($data3,$res);
                        }
                    }
                }

                $response_data2 = $data3;
            }
        }


        $response_data2 = collect($response_data2);
        $response_data2 = $response_data2->unique('VehicleNumber');

        session()->put('VEHICLEWISESUMMEX',$response_data2);

        $res = session()->get('DATA');

        $res = collect($res);
        $i = 1;

        session()->put('VEHICLEWISESUMMEX2',$res);

        $rescheckvehinum = [];
        $rescheckvehinum = $request->checkbox1;

        $reschecktypevehi = [];
        $reschecktypevehi = $request->checkbox2;

        $rescheckomc = [];
        $rescheckomc = $request->checkbox;

        $daterange = date('d/m/Y', strtotime($request->startdate))." - ".date('d/m/Y', strtotime($request->enddate));

        session()->put('daterange',$daterange);
        session()->put('rescheckvehinum',$rescheckvehinum);
        session()->put('reschecktypevehi',$reschecktypevehi);
        session()->put('rescheckomc',$rescheckomc);


        $datares = view('datavehiclewise',compact('response_data2','i','res','startdate','enddate','daterange','rescheckvehinum','reschecktypevehi','rescheckomc'))->render();
        $response['datares'] = $datares;
        return $response;

    }

    public function vehiclewisesummexportxls()
    {
        return Excel::download(new VehiclewisesummExport, 'Vehiclewisesumm.xls');
    }

    public function vehiclewisesummexport()
    {
        return Excel::download(new VehiclewisesummExport, 'Vehiclewisesumm.csv');
    }

    public function vehiclewisesummexportpdf()
    {
        $response_data = session()->get('VEHICLEWISESUMMEX');
        $res = session()->get('VEHICLEWISESUMMEX2');
        $i = 1;

        $pdf = Pdf::loadView('exports.vehiclewisesummex',compact('response_data','res','i'));
        
        return $pdf->download('Vehiclewisesumm.pdf');
    }

    public function vehiclewisesummailsub(Request $request)
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
            return redirect()->route('vehiclewisesum')->with('ERROR','Please Select One Option');
        }

        if($request->checkbox1['0'] == 'csv'){
            Excel::store(new VehiclewisesummExport, 'Vehiclewisesumm.csv');

            $file = storage_path('app/public/Vehiclewisesumm.csv');

            Mail::send('emails.mymail', $data, function($message)use($data, $file) {
                $message->to($data["email"])
                        ->subject($data["title"]);

                        $message->attach($file);          
            });

            File::delete($file);
        }

        if($request->checkbox1['0'] == 'xls'){
            Excel::store(new VehiclewisesummExport, 'Vehiclewisesumm.xls');

            $file = storage_path('app/public/Vehiclewisesumm.xls');

            Mail::send('emails.mymail', $data, function($message)use($data, $file) {
                $message->to($data["email"])
                        ->subject($data["title"]);

                        $message->attach($file);          
            });

            File::delete($file);
        }

        if($request->checkbox1['0'] == 'pdf'){
            $response_data = session()->get('VEHICLEWISESUMMEX');
            $res = session()->get('VEHICLEWISESUMMEX2');
            $i = 1;

            $pdf = Pdf::loadView('exports.vehiclewisesummex',compact('response_data','res','i'));

            Mail::send('emails.mymail', $data, function($message)use($data, $pdf) {
                $message->to($data["email"], $data["email"])->subject($data["title"])->attachData($pdf->output(),'Vehiclewisesumm.pdf');
            });
        }

        return redirect()->route('vehiclewisesum');
    }

    public function vehwisesumasc($data)
    {
        $response_data = session()->get('VEHICLEWISESUMMEX');

        if($data == 'vehicleno'){
            $response_data = $response_data->sortBy('VehicleNumber');
        } 

        if($data == 'omc'){
            $response_data = $response_data->sortBy('TtransporterName');
        } 

        if($data == 'typeofvehicle'){
            $response_data = $response_data->sortBy('AuditType');
        } 

        session()->put('VEHICLEWISESUMMEX',$response_data);
        $i = 1;

        $res = session()->get('VEHICLEWISESUMMEX2');

        if(session()->has('daterange') || session()->has('rescheckvehinum') || session()->has('reschecktypevehi') || session()->has('rescheckomc') ){
            $daterange = session()->get('daterange');
            $rescheckvehinum = session()->get('rescheckvehinum');
            $reschecktypevehi = session()->get('reschecktypevehi');
            $rescheckomc = session()->get('rescheckomc');

            $datares = view('datavehiclewise',compact('response_data','i','res','daterange','rescheckvehinum','reschecktypevehi','rescheckomc'))->render();
            $response['datares'] = $datares;
            return $response;

        }


        $datares = view('datavehiclewise',compact('response_data','i','res'))->render();
        $response['datares'] = $datares;
        return $response;
    }

    public function vehwisesumdesc($data)
    {
        $response_data = session()->get('VEHICLEWISESUMMEX');

        if($data == 'vehicleno'){
            $response_data = $response_data->sortByDesc('VehicleNumber');
        } 

        if($data == 'omc'){
            $response_data = $response_data->sortByDesc('TtransporterName');
        }

        if($data == 'typeofvehicle'){
            $response_data = $response_data->sortByDesc('AuditType');
        }

        session()->put('VEHICLEWISESUMMEX',$response_data);
        $i = 1;

        $res = session()->get('VEHICLEWISESUMMEX2');

        if(session()->has('daterange') || session()->has('rescheckvehinum') || session()->has('reschecktypevehi') || session()->has('rescheckomc') ){
            $daterange = session()->get('daterange');
            $rescheckvehinum = session()->get('rescheckvehinum');
            $reschecktypevehi = session()->get('reschecktypevehi');
            $rescheckomc = session()->get('rescheckomc');

            $datares = view('datavehiclewise',compact('response_data','i','res','daterange','rescheckvehinum','reschecktypevehi','rescheckomc'))->render();
            $response['datares'] = $datares;
            return $response;

        }

        $datares = view('datavehiclewise',compact('response_data','i','res'))->render();
        $response['datares'] = $datares;
        return $response;
    }

}
