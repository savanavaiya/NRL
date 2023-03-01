<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class AuditorreportExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct()
    {
        $this->datas = session()->get('AUDITOREX');
    }
    
    public function view(): View
    {
        return view('exports.auditorreportex',[
            'response_data' => $this->datas,
            'i' => 1
        ]);
    }
}
