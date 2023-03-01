<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class VehiclewisesummExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct()
    {
        $this->datas = session()->get('VEHICLEWISESUMMEX');

        $this->datas2 = session()->get('VEHICLEWISESUMMEX2');
    }
    
    public function view(): View
    {
        return view('exports.vehiclewisesummex',[
            'response_data' => $this->datas,
            'res' => $this->datas2,
            'i' => 1
        ]);
    }
}
