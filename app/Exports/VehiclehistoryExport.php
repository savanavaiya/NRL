<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class VehiclehistoryExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct()
    {
        $this->datas = session()->get('VEHICLEHISEX');
    }
    
    public function view(): View
    {
        return view('exports.vehiclehistoryex',[
            'response_data' => $this->datas,
            'i' => 1
        ]);
    }
}
