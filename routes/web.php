<?php

use App\Http\Controllers\AnomalyreportController;
use App\Http\Controllers\AuditorController;
use App\Http\Controllers\DetailauditController;
use App\Http\Controllers\FilterajaxController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MonthlybillingController;
use App\Http\Controllers\VehiclehistoryController;
use App\Http\Controllers\VehiclewisesummController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', [LoginController::class,'loginpage'])->name('login');
Route::post('/login/submit', [LoginController::class,'loginsub'])->name('loginsub');
Route::get('/logout', [LoginController::class,'logout'])->name('logout');

Route::get('/dashboard', [HomeController::class,'dashboardpage'])->name('dashboard')->middleware('Logincheck');
Route::post('/dashboard/applyfilters', [HomeController::class,'dashfiltsub'])->name('dashfiltsub')->middleware('Logincheck');
Route::get('/dashboard/xls/exports/data', [HomeController::class,'dashboardexportxls'])->name('dashboardexportxls')->middleware('Logincheck');
Route::get('/dashboard/exports/data', [HomeController::class,'dashboardexport'])->name('dashboardexport')->middleware('Logincheck');
Route::get('/dashboard/pdf/exports/data', [HomeController::class,'dashboardexportpdf'])->name('dashboardexportpdf')->middleware('Logincheck');
Route::post('/dashboard/mail/exports/data', [HomeController::class,'dashboardmailsub'])->name('dashboardmailsub')->middleware('Logincheck');

Route::get('/dashboard/anomaly-report', [AnomalyreportController::class,'anomalyreport'])->name('anomalyreport')->middleware('Logincheck');
Route::post('/dashboard/anomaly-report/applyfilters', [AnomalyreportController::class,'anomalyreportfiltsub'])->name('anomalyreportfiltsub')->middleware('Logincheck');
Route::get('/dashboard/anomaly-report/xls/exports/data', [AnomalyreportController::class,'anomalyexportxls'])->name('anomalyexportxls')->middleware('Logincheck');
Route::get('/dashboard/anomaly-report/exports/data', [AnomalyreportController::class,'anomalyexport'])->name('anomalyexport')->middleware('Logincheck');
Route::get('/dashboard/anomaly-report/pdf/exports/data', [AnomalyreportController::class,'anomalyexportpdf'])->name('anomalyexportpdf')->middleware('Logincheck');
Route::post('/dashboard/anomaly-report/mail/exports/data', [AnomalyreportController::class,'anomalymailsub'])->name('anomalymailsub')->middleware('Logincheck');

Route::get('/dashboard/monthly-billing', [MonthlybillingController::class,'monthlybilling'])->name('monthlybilling')->middleware('Logincheck');
Route::post('/dashboard/monthly-billing/applyfilters', [MonthlybillingController::class,'monthbillfiltrsub'])->name('monthbillfiltrsub')->middleware('Logincheck');
Route::get('/dashboard/monthly-billing/xls/exports/data', [MonthlybillingController::class,'monthlybillingexxls'])->name('monthlybillingexxls')->middleware('Logincheck');
Route::get('/dashboard/monthly-billing/exports/data', [MonthlybillingController::class,'monthlybillingex'])->name('monthlybillingex')->middleware('Logincheck');
Route::get('/dashboard/monthly-billing/pdf/exports/data', [MonthlybillingController::class,'monthlybillingexpdf'])->name('monthlybillingexpdf')->middleware('Logincheck');
Route::post('/dashboard/monthly-billing/mail/exports/data', [MonthlybillingController::class,'monthlybillingmailsub'])->name('monthlybillingmailsub')->middleware('Logincheck');

Route::get('/dashboard/auditor', [AuditorController::class,'auditor'])->name('auditor')->middleware('Logincheck');
Route::post('/dashboard/auditor/applyfilters', [AuditorController::class,'auditorfiltsub'])->name('auditorfiltsub')->middleware('Logincheck');
Route::get('/dashboard/auditor/xls/exports/data', [AuditorController::class,'auditorexportxls'])->name('auditorexportxls')->middleware('Logincheck');
Route::get('/dashboard/auditor/exports/data', [AuditorController::class,'auditorexport'])->name('auditorexport')->middleware('Logincheck');
Route::get('/dashboard/auditor/pdf/exports/data', [AuditorController::class,'auditorexportpdf'])->name('auditorexportpdf')->middleware('Logincheck');
Route::post('/dashboard/auditor/mail/exports/data', [AuditorController::class,'auditormailsub'])->name('auditormailsub')->middleware('Logincheck');

Route::get('/dashboard/detailed-audit-report', [DetailauditController::class,'detailedaudit'])->name('detailedaudit')->middleware('Logincheck');
Route::post('/dashboard/detailed-audit-report/applyfilters', [DetailauditController::class,'detailauditfiltsub'])->name('detailauditfiltsub')->middleware('Logincheck');
Route::get('/dashboard/detailed-audit-report/xls/exports/data', [DetailauditController::class,'xlsexportdetaudit'])->name('xlsexportdetaudit')->middleware('Logincheck');
Route::get('/dashboard/detailed-audit-report/exports/data', [DetailauditController::class,'exportdetaudit'])->name('exportdetaudit')->middleware('Logincheck');
Route::get('/dashboard/detailed-audit-report/pdf/exports/data', [DetailauditController::class,'pdfexportdetaudit'])->name('pdfexportdetaudit')->middleware('Logincheck');
Route::post('/dashboard/detailed-audit-report/mail/exports/data', [DetailauditController::class,'detailauditmailsub'])->name('detailauditmailsub')->middleware('Logincheck');

Route::get('/dashboard/detailed-audit-report/view/as/pdf', [DetailauditController::class,'viewaspdfdetailaudit'])->name('viewaspdfdetailaudit')->middleware('Logincheck');

Route::get('/dashboard/vehicle-history', [VehiclehistoryController::class,'vehiclehistory'])->name('vehiclehistory')->middleware('Logincheck');
Route::post('/dashboard/vehicle-history/applyfilters', [VehiclehistoryController::class,'vehiclehisfilsub'])->name('vehiclehisfilsub')->middleware('Logincheck');
Route::get('/dashboard/vehicle-history/xls/exports/data', [VehiclehistoryController::class,'exportvehiclhistxls'])->name('exportvehiclhistxls')->middleware('Logincheck');
Route::get('/dashboard/vehicle-history/exports/data', [VehiclehistoryController::class,'exportvehiclhist'])->name('exportvehiclhist')->middleware('Logincheck');
Route::get('/dashboard/vehicle-history/pdf/exports/data', [VehiclehistoryController::class,'exportvehiclhistpdf'])->name('exportvehiclhistpdf')->middleware('Logincheck');
Route::post('/dashboard/vehicle-history/mail/exports/data', [VehiclehistoryController::class,'vehiclehistmailsub'])->name('vehiclehistmailsub')->middleware('Logincheck');

Route::get('/dashboard/vehicle-wise-summury', [VehiclewisesummController::class,'vehiclewisesum'])->name('vehiclewisesum')->middleware('Logincheck');
Route::get('/dashboard/vehicle-wise-summury/ajax/call', [VehiclewisesummController::class,'vehiclewisesumajax'])->name('vehiclewisesumajax')->middleware('Logincheck');
Route::post('/dashboard/vehicle-wise-summury/applyfilters', [VehiclewisesummController::class,'vehiclewisesummfilsub'])->name('vehiclewisesummfilsub')->middleware('Logincheck');
Route::get('/dashboard/vehicle-wise-summury/xls/exports/data', [VehiclewisesummController::class,'vehiclewisesummexportxls'])->name('vehiclewisesummexportxls')->middleware('Logincheck');
Route::get('/dashboard/vehicle-wise-summury/exports/data', [VehiclewisesummController::class,'vehiclewisesummexport'])->name('vehiclewisesummexport')->middleware('Logincheck');
Route::get('/dashboard/vehicle-wise-summury/pdf/exports/data', [VehiclewisesummController::class,'vehiclewisesummexportpdf'])->name('vehiclewisesummexportpdf')->middleware('Logincheck');
Route::post('/dashboard/vehicle-wise-summury/mail/exports/data', [VehiclewisesummController::class,'vehiclewisesummailsub'])->name('vehiclewisesummailsub')->middleware('Logincheck');
Route::get('/dashboard/vehicle-wise-summury/asc/{data}', [VehiclewisesummController::class,'vehwisesumasc'])->name('vehwisesumasc')->middleware('Logincheck');
Route::get('/dashboard/vehicle-wise-summury/desc/{data}', [VehiclewisesummController::class,'vehwisesumdesc'])->name('vehwisesumdesc')->middleware('Logincheck');


Route::get('/dashboard/get/omc/filters', [FilterajaxController::class,'filteromc'])->name('filteromc')->middleware('Logincheck');
Route::get('/dashboard/get/vehiclenumber/filters', [FilterajaxController::class,'filtervehiclenum'])->name('filtervehiclenum')->middleware('Logincheck');
Route::get('/dashboard/get/typeofvehicle/filters', [FilterajaxController::class,'filtertypevehi'])->name('filtertypevehi')->middleware('Logincheck');
Route::get('/dashboard/get/auditor/filters', [FilterajaxController::class,'filterauditor'])->name('filterauditor')->middleware('Logincheck');