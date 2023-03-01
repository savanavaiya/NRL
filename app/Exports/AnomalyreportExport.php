<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class AnomalyreportExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct()
    {
        $this->datas = session()->get('ANOMALYEX');
        $this->response_datamain = session()->get('DATA');
    }
    
    public function view(): View
    {
        return view('exports.anomalyreportex',[
            'response_data' => $this->datas,
            'response_datamain' => $this->response_datamain,
            'i' => 1
        ]);
    }
}
