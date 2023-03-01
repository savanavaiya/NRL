<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class DashboardExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct()
    {
        $this->datas = session()->get('DASHBOARDEX');
    }
    
    public function view(): View
    {
        return view('exports.dashboardex',[
            'response_data' => $this->datas,
            's' => 1,
            'a' => 1,
        ]);
    }
}
