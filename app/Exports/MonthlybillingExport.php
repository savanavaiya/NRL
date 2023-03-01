<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class MonthlybillingExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct()
    {
        $this->datas = session()->get('MONTHLYBILLINGEX');
    }
    
    public function view(): View
    {
        return view('exports.monthlybillingex',[
            'response_data' => $this->datas,
            'i' => 1
        ]);
    }
}
