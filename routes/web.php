<?php

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

Route::get('/', function () {
    return view('Test');
});

Route::get('/about', 'Pagecontroller@indexaboutus');

///////Routes Started (Isira)/////////

//Main menu
Route::get('/menu', function(){
  return view('mainMenu');
});

//Report Menu
Route::get('/rmenu', function () {
  return view('ReportMenu');
});


//Transport Managment Sub menu
Route::get('tmMenu', function(){
  return view('transportManagementMenu');
});

//Courier Service Registration

Route::post('/save_courier', 'courier_controller@store');

Route::get('/courier', function () {
    $data =App\courier_service::paginate(5);

    return view('courier_service_reg')->with('courier_service',$data);
});

Route::get('/delcourier/{id}', 'courier_controller@delcourier');

Route::get('/updatecourier/{id}', 'courier_controller@updatecourier');

Route::post('/updatecouriers','courier_controller@updatecouriers');

//Route::get('/deliver1', function () {
  //  return view('deliver_by_company_vehicles');
//});



///Delivery////



//Delivery | This is to get Wholesale buyer details to the Ajax

Route::get('/getCusName2','courier_controller@getCusName2');



//Delivery Function | Company Vehicles

Route::get('/deliver1','courier_controller@getInvoices');

Route::post('/save_delivery', 'courier_controller@storeDelivary');

Route::get('/deldelivery/{id}', 'courier_controller@deldelivery');

Route::post('/updatedeliveries','courier_controller@updatedeliveries');

Route::get('/updatedelivery/{id}','courier_controller@updatedelevery');



//Delivery Function | Courier Services

Route::get('/deliver2','courier_controller@getInvoices2');



Route::post('/save_delivery2','courier_controller@storeDelivary2');

Route::get('/deldelivery2/{id}', 'courier_controller@deldelivery2');

Route::get('/updatedelivery2/{id}','courier_controller@updatedelivery2');

Route::post('/updatedeliveries2','courier_controller@updatedeliveries2');



//Official vists

Route::get('/visits','courier_controller@getVisits');

Route::post('/save_visits','courier_controller@storeVisits');

Route::get('/delvisit/{id}', 'courier_controller@delvisit');

Route::get('/updatevisit/{id}','courier_controller@updatevisit');

Route::post('/updatevisit2','courier_controller@updatevisit2');



//Search Functions

Route::get('/searchDC', 'courier_controller@searchDC');

Route::get('/searchDO', 'courier_controller@searchDo');

Route::get('/searchCu', 'courier_controller@searchCu');

Route::get('/searchVi', 'courier_controller@searchVi');

//Route::get('/R_D_Company', 'DynamicPDFController@delivery_through_company');

Route::get('/courier_company/pdf', 'DynamicPDFController@Courierpdf');



//TCPDF Report (Isira)

Route::resource('report_delivery_by_own', 'DeliveryReportOwnController');

Route::resource('report_delivery_by_courier', 'DeliveryReportCourierController');

Route::resource('report_delivery', 'DeliveryReportController');

Route::resource('report_daily_visits', 'DailyVisitsReportController');

Route::get('/DeliveryPieChart', 'DeliveryChartController@index');

Route::get('/DeliveryBarChart', 'DeliveryChartController@index2');



//Delivery Charts

Route::get('deliveries_pie_chart', function(){
  return view('DeliveriesPieChartDatePicker');
});

Route::get('deliveries_bar_chart', function(){
  return view('DeliveriesBarChartDatePicker');
});
//Route::get('/report_delivery_by_own_vehicles/pdf', 'DeliveryReportController@pdf');
//Route::get('/deliver1','courier_controller@getCusName');



/* Reporting Part */



//Delivery By Company Vehicles

Route::get('/RCompany', 'RController@getDCompanyData');

Route::get('/RCompanyFilter', 'RController@getDCompanyData');

//Route::get('/RCompanyDate', 'RController@getDCompanyFilter');

Route::get('/RCompany/pdf/{from_date}/{to_date}', 'DynamicPDFController@RPCompanyPDF');


//Delivery By Courier Services

Route::get('/RCourier', 'RController@getDCourierData');

Route::get('/RCourierFilter', 'RController@getDCourierData');

Route::get('/RCourier/pdf/{from_date}/{to_date}', 'DynamicPDFController@RPCourierPDF');

//Deliveries

Route::get('/RDelivery', 'RController@getDData');

Route::get('/RDeliveryFilter', 'RController@getDData');

Route::get('/RDelivery/pdf/{from_date}/{to_date}', 'DynamicPDFController@RPDeliveryPDF');

//Daily Visits

Route::get('/RVisits', 'RController@getVisitsData');

Route::get('/RVisitsFilter', 'RController@getVisitsData');

Route::get('/RVisit/pdf/{from_date}/{to_date}', 'DynamicPDFController@RPVisitsPDF');


Route::get('/newMenu123', function () {

  return view('newMenu123');
 
});









////////////////////////////Kasuni's Routes//////////////////////////





Route::get('/logo', function () {
    
  echo 'New Kasuni';
});

//Route::get('/supplierHome', 'Frontendcontroller@indexSupplier');

Route::get('/supplierHome',function(){

  $localSupData=App\localSupplier::all();
  return view('supplier')->with('supplier',$localSupData);
});

Route::get('/buyerHome', function () {

  $buyerData=App\wholeSaleBuyer::all();
  return view('wholeSaleBuyer')->with('wholeSaleBuyer', $buyerData);
  
});

Route::post('/addSupplier', 'localSupplierController@stroreLocalSupplier'); 

Route::get('/deleteLocalSup/{reg_no}','localSupplierController@deleteLocalSup');


Route::get('/updateLocalSup/{reg_no}','localSupplierController@updateLocalSupView');

Route::post('/updateLocalSupData','localSupplierController@updateLocalSupplierData');

Route::get('/Supplier-Buyer Home', function () {
  return view('Sup-BuyerHome');
 
});

Route::post('/addBuyer', 'wholeSaleBuyerController@storeBuyer'); 

Route::get('/deleteBuyer/{reg_no}','wholeSaleBuyerController@deleteBuyer');
 
Route::get('/updateBuyer/{reg_no}','wholeSaleBuyerController@updateBuyerView');

Route::post('/updateBuyerData','wholeSaleBuyerController@updateBuyerData');
 
Route::get('/foreignSupplierHome',function(){

  $foreignSupData=App\foreignSupplier::all();
  return view('foreignSupplier')->with('foreignSupplier', $foreignSupData);

 
 
});

Route::post('/addForeignSupplier', 'foreignSupplierController@stroeForeignSupplier'); 

Route::get('/deleteForeignSupplier/{reg_no}','foreignSupplierController@deleteForeignSupplier');

Route::get('/updateForeignSupplier/{reg_no}','foreignSupplierController@updateForeignSupplierView');

Route::post('/updateForeignSupData','foreignSupplierController@updateForeignSupplierData');

//Route::get('/buyerHome','wholeSaleBuyerController@selectDistrict');

//Route::post('buyerHome/fetch','wholeSaleBuyerController@fetch')->name('wholeSaleBuyerController.fetch');

Route::get('/searchLocalSup','localSupplierController@searchLocalSup');


Route::get('/searchForeignSup','foreignSupplierController@searchForeignSup');

Route::get('/searchWholeBuyer','wholeSaleBuyerController@searchWholeBuyer');


Route::get('/subBuyerMenu', function () {
  return view('SubBuyerMenu');
});


Route::get('/lsupplierEvaluate', function(){
  return view('localSupplierEvaluate');
});

Route::get('/buyerEvaluate', function(){
 // $data = DB::table('whole_sale_buyers');
  //return view('/buyerEvaluate',['data' =>$data]);
  return view('buyerEvaluate');
 
});

Route::get('/bestBuyer','wholeSaleBuyerController@bestBuyer');

Route::get('/buyerEvaluateResult', function(){
  // $data = DB::table('whole_sale_buyers');
   //return view('/buyerEvaluate',['data' =>$data]);
   return view('buyerEvaluateResult');
  
 });

Route::get('dynamic_pdf_buyer','wholeSaleBuyerController@index');

Route::get('/dynamic_pdf_buyer/pdf','wholeSaleBuyerController@pdf_buyer');

Route::get('/dynamic_pdf_SingleEbuyer/pdf/{reg_no}','wholeSaleBuyerController@pdf_singleEbuyer');

Route::get('/bestFSupplier','foreignSupplierController@bestFSupplier');

Route::get('/fsupplierEvaluateResult', function(){
  // $data = DB::table('whole_sale_buyers');
   //return view('/buyerEvaluate',['data' =>$data]);
   return view('foreignSupplierEvaluate');
  
 });

Route::get('/dynamic_pdf_SingleEforeignSupplier/pdf/{reg_no}','foreignSupplierController@pdf_singleEforeignbSupplier');

Route::get('/singleBuyerProfile/{reg_no}','wholeSaleBuyerController@singleBuyerProfileView');

Route::get('/singleBuyerProfile', function(){
  // $data = DB::table('whole_sale_buyers');
   //return view('/buyerEvaluate',['data' =>$data]);
   return view('singleBuyerProfile');
  
 });

Route::get('/dynamic_pdf_singleBuyer/pdf/{reg_no}','wholeSaleBuyerController@pdf_singleBuyer');

Route::get('dynamic_pdf_localSupplier','localSupplierController@index_lsupplier');

Route::get('/dynamic_pdf_localSupplier/pdf','localSupplierController@pdf_localSuppliers');

Route::get('/singleLocalSupplierProfile/{reg_no}','localSupplierController@singleLocalSupplierProfileView');

Route::get('/singleLocalSupplierProfile', function(){
  // $data = DB::table('whole_sale_buyers');
   //return view('/buyerEvaluate',['data' =>$data]);
   return view('singleLocalSupplierProfile');
  
 });

Route::get('/dynamic_pdf_singlelocalSupplier/pdf/{reg_no}','localSupplierController@pdf_singleLocalSupplier');

Route::get('dynamic_pdf_foreign_supplier','foreignSupplierController@index_fsupplier');


Route::get('/dynamic_pdf_foreign_supplier/pdf','foreignSupplierController@pdf_foreignSuppliers');

Route::get('/singleForeignSupplierProfile/{reg_no}','foreignSupplierController@singleForeignSupplierProfileView');

Route::get('/singleForeignSupplierProfile', function(){
  // $data = DB::table('whole_sale_buyers');
   //return view('/buyerEvaluate',['data' =>$data]);
   return view('singleForeignSupplierProfile');
  
 });


Route::get('/dynamic_pdf_singleForeignSupplier/pdf/{reg_no}','foreignSupplierController@pdf_singleForeignSupplier');


Route::get('/lsupPDFresult', function () {

  return view('localSupplierPDFResult');
 
});
Route::get('/fsupPDFresult', function () {

  return view('foreignSupPDFresult');
 
});

Route::get('/buyerPDFResult', function () {

  return view('buyerPDFresult');
 
});


Route::get('/searchLocalSupPDF','localSupplierController@searchlocalSupPDF');


Route::get('/searchForeignPDF','foreignSupplierController@searchfSupPDF');


Route::get('/searchPDFbuyer','wholeSaleBuyerController@searchbuyerPDF');







/////////////////////////////////////////////////////NISHAN//////////////////////////////////////////////////////////////






//Load All incomes and expenses
Route::get('/expense','ExpenseController@showAll');
Route::get('/income','IncomeController@showAll');

// Route::get('/editExpense', function (){
//     return view('editExpense');
// });
// Route::get('/editIncome', function (){
//     return view('editIncome');
// });

Route::get('/fmMenu', function (){
    return view('financeManagementMenu');
});

//Save
Route::post('/saveExpense','ExpenseController@store');
Route::post('/saveIncome','IncomeController@store');

//Delete
Route::get('/deleteExpense/{id}', 'ExpenseController@deleteExpense');
Route::get('/deleteIncome/{id}', 'IncomeController@deleteIncome');

//Updates
Route::get('/updateExpenseView/{id}','ExpenseController@updateExpenseView');
Route::get('/updateIncomeView/{id}','IncomeController@updateIncomeView');
Route::post('/updateExpense', 'ExpenseController@updateExpense');
Route::post('/updateIncome', 'IncomeController@updateIncome');

//History
Route::get('/expenseHistory','ExpenseHistoryController@historyView');
Route::get('/incomeHistory','IncomeHistoryController@historyView');

//Search
Route::get('/searchIncome','IncomeController@searchIncome');
Route::get('/searchExpense','ExpenseController@searchExpense');

//Viewing all the sales
Route::get('/viewAllSales','ViewAllSales@viewAll');
// Route::resource('summary', 'SummaryController');
// Route::resource('summaryIncome', 'IncomeSummaryController');

//Charts
Route::get('/chartCategory', 'GoogleGraphController@index');
Route::get('/chartCategoryBar', 'GoogleGraphController@indexBar');
Route::get('/fmCharts', function(){
    return view('fmChartsExpense');
});
Route::get('/fmChartsIncome', function(){
    return view('fmChartsIncome');
});
Route::get('/fmChartsBar', function(){
    return view('fmChartsBar');
});
Route::get('/fmChartsIncomeBar', function(){
    return view('fmChartsIncomeBar');
});
Route::get('/chartsCategoryIncome', 'GoogleGraphController@incomePie');
Route::get('/chartsCategoryIncomeBar', 'GoogleGraphController@incomeBar');


//Reporting Routes
Route::get('/incomeSummary', 'SummaryController@loadIncomeData');
Route::get('/expenseSummary', 'SummaryController@loadExpenseData');
Route::get('/profitSummary', 'SummaryController@loadProfitData');

//PDF Routes
Route::get('/expensePDF/{fromDate}/{toDate}','ExpenseReportController@ExpensePDF');
Route::get('/incomePDF/{fromDate}/{toDate}','IncomeReportController@IncomePDF');
Route::get('/profitPDF/{fromDate}/{toDate}','ProfitReportController@ProfitPDF');







//////////////////////////////////////////JEEWANTHA ROUTES/////////////////////////////

//vehicle registration route
Route::get('/vehicleregistration', function () {
  //echo 'vehicle registration';
  $data=App\Vehicle::all();
  return view('vehicleregistration')->with('vehicleregistration',$data);
});

//machinery registration route
Route::get('/machineryregistration', function () {
  //echo 'machinery registration';
  $data=App\Machinery::all();
  return view('machineryregistration')->with('machineryregistration',$data);
});

Route::get('/editvehicleregistration', function () {
  echo 'edit vehicle registration';

});

Route::get('/editmachineryregistration', function () {
  echo 'edit machinery registration';
  return view('welcome');
});

//vehicle maintenance route
Route::get('/vehiclemaintenance','VehicleMaintenanceController@getDetails');


Route::get('/editvehiclemaintenance', function () {
  echo 'edit maintenance';
  return view('editmachinerymaintenance');
});

//machinery maintenance route
Route::get('/machinerymaintenance','MachineryMaintenanceController@getDetails');

//route for edit machinery 
Route::get('/editmachinerymaintenance', function () {
  echo 'edit machinery maintenance';
  return view('editmachinerymaintenance');
});

//route for edit vehicle
Route::get('/editvehiclemaintenance', function () {
  echo 'edit vehicle maintenance';
  return view('editvehiclemaintenance');
});

//machinery usage log route
Route::get('/machineryusagelog','MachineryUsageLogController@getDetails');

// Route::get('/machineryusagelog', function () {
//     //$data=App\MachineryMaintenance::all();
//     return view('machineryusagelog');
// });

Route::get('/editmachineryusagelog', function () {
  //echo 'edit machinery maintenance';
  return view('editmachineryusagelog');
});

/*Route::get('/vehicleregistrationsearch', function () {
//echo 'edit machinery maintenance';
return view('vehicleregistrationsearch');
});*/



//VEHICLE REGISTRATION
//add vehicles
Route::post('/saveVehicle','VehicleController@storevehicle'); 

//delete vehicle
Route::get('/deletevehicle/{id}','VehicleController@deletevehicle');

//edit vehicle
Route::get('/editvehicle/{id}','VehicleController@editvehicleview');

//update vehicle
Route::post('/updatevehicle','VehicleController@updatevehicle');



//MACHINERY REGISTRATION
//add machineries
Route::post('/saveMachinery','MachineryController@storemachinery');

//delete machineries
Route::get('/deletemachinery/{id}','MachineryController@deletemachinery');

//edit machinery
Route::get('/editmachinery/{id}','MachineryController@editmachineryview');

//update machinery
Route::post('/updatemachinery','MachineryController@updatemachinery');



//VEHICLE MAINTENANCE
//add vehicles maintenance
Route::post('/saveVehicleMaintenance','VehicleMaintenanceController@storevehiclemaintenance');

//delete vehicle maintenance
Route::get('/deletevehiclemaintenance/{maintenance_id}','VehicleMaintenanceController@deletevehiclemaintenance');

//edit vehicle maintenance
Route::get('/editvehiclemaintenance/{maintenance_id}','VehicleMaintenanceController@editvehiclemaintenanceview');

//update vehicle maintenance
Route::post('/updatevehiclemaintenance','VehicleMaintenanceController@updatevehiclemaintenance');



//MACHINERY MAINTENANCE
//add machineries maintenance
Route::post('/saveMachineryMaintenance','MachineryMaintenanceController@storemachinerymaintenance'); 

//delete machineries maintenance
Route::get('/deletemachinerymaintenance/{maintenance_id}','MachineryMaintenanceController@deletemachinerymaintenance');

//edit machinery maintenance
Route::get('/editmachinerymaintenance/{maintenance_id}','MachineryMaintenanceController@editmachinerymaintenaceview');

//update machinery maintenance
Route::post('/updatemachinerymaintenance','MachineryMaintenanceController@updatemachinerymaintenance');



//MACHINERY USAGE LOG
//add machineries usage log
Route::post('/saveMachineryUsageLog','MachineryUsageLogController@storemachineryusagelog');

//edit machinery usage log
Route::get('/editmachineryusagelog/{log_no}','MachineryUsageLogController@editmachineryusagelogview');

//update machinery usage log
Route::post('/updatemachineryusagelog','MachineryUsageLogController@updatemachineryusagelog');



//SEARCH
//search Vehicle Registration
Route::get('/searchVehiReg','VehicleController@searchVehicleRegistration');

//search Machinery Registration
Route::get('/searchMachineReg','MachineryController@searchMachineryRegistration');

//search Vehicle Maintenance
Route::get('/searchVehiMain','VehicleMaintenanceController@searchVehicleMaintenance');

//search Machinery Maintenance
Route::get('/searchMachMain','MachineryMaintenanceController@searchMachineryMaintenance');

//search Machinery Usage Log
Route::get('/searchMachUsageLog','MachineryUsageLogController@searchMachineryUsageLog');



//DATERANGE
//Machinery Maintenance Daterange
Route::resource('machinery_maintenance_daterange', 'MachineryMaintenanceDaterangeController');

//Vehicle Maintenance Daterange
Route::resource('vehicle_maintenance_daterange', 'VehicleMaintenanceDaterangeController');

//Machinery usage log Daterange
Route::resource('machinery_usage_log_daterange', 'MachineryUsageLogDaterangeController');



//PDF VIEWS
//Machinery Maintenance PDF View
Route::get('machinerymaintainancePDF', 'ResourceReportController@getMachinerydatabydatepicker');
Route::get('/machinerymaintainancedatepicker', 'ResourceReportController@getMachinerydatabydatepicker');
Route::get('/machinerymaintainancePDF/pdf/{from_date}/{to_date}', 'MachineryMaintenancePDFController@pdf');

//Vehicle Maintenance PDF View
Route::get('vehiclemaintainancePDF', 'ResourceReportController@getVehicledatabydatepicker');
Route::get('/vehiclemaintainancedatepicker', 'ResourceReportController@getVehicledatabydatepicker');
Route::get('/vehiclemaintainancePDF/pdf/{from_date}/{to_date}', 'VehicleMaintenancePDFController@pdf');

//Machinery usage log PDF View
Route::get('machineryusagelogPDF', 'ResourceReportController@getMachineryusagedatabydatepicker');
Route::get('/machineryusagedatepicker', 'ResourceReportController@getMachineryusagedatabydatepicker');
Route::get('/machineryusagelogPDF/pdf/{from_date}/{to_date}', 'MachineryUsageLogPDFController@pdf');



//MENU
//menu route
Route::get('/subResourceMenu', function () {
  return view('subResourceMenu');
});


  //about
  Route::get('/about', function(){
    return view('about');
  });




  /////////////////////////THARUVI////////////////////////////////



  //before the first evaluation

Route::get('/unavailableItems',function (){
  $data2=App\unavailableItems::all();
  return view('unavailableItems')->with('unavailableItems',$data2);
});

Route::get('/feedback',function(){
  $data=App\feedback::all();
  return view('feedback')->with('feedback',$data);
});

Route::post('/unavailableItems','unavailableItemsController@storeUn');

Route::get('/markascompleted/{id}','unavailableItemsController@updateTaskAsCompleted');
Route::get('/markasnotcompleted/{id}','unavailableItemsController@updateTaskAsNotCompleted');

Route::get('/deleteEntry/{id}','unavailableItemsController@DeteleEntry');

Route::post('/feedback','FeedbackController@saveFeedback');

//after the first evaluation
Route::get('/updateUnItems/{id}','unavailableItemsController@editUnItems');

Route::post('/UpdateUnItem','unavailableItemsController@updateItems');

Route::resource('invoices', 'InvoiceController');

Route::resource('bills', 'InvoiceController');

Route::get('Tpdf','unavailablePdfController@index');
Route::get('/Tpdf/pdf','unavailablePdfController@pdf');
Route::get('/feedbackpdf/pdf','FeedbackController@pdf');
Route::get('/billpdf/pdf','BillPdfController@pdf');

Route::get('/viewfeedback','FeedbackController@index');


Route::get('/searchUnitems','unavailableItemsController@SearchUnItems');


Route::get('SinglebillPDF','InvoiceController@index2');


Route::get('/dynamic_pdf_singleBill/pdf/{invoice_no}','InvoiceController@pdf_singleBill');

Route::get('/subBillingMenu', function () {
  return view('subIndiBillingMenu');
});






///////////////////////////////Tharushika//////////////////////////////////




Route::get('/empReg', function () {
  $data=App\EmpDetails::all();
  return view('employeeRegistration')->with('emprg',$data);
});
Route::get('/emp', function () {
  $data=App\EmpDetails::all();
  return view('employee')->with('emprg',$data);
});

//EmpRegistration
//Route::get('/empReg','Frontendcontroller@indexempRegistration');

Route::post('/saveEmpDetails','EmployeeController@store');

Route::get('/deleteemp/{employee_id}','EmployeeController@deleteemp');

Route::get('/updateemp/{employee_id}','EmployeeController@updateempview');

Route::post('/updateemployee','EmployeeController@updateemp');

Route::get('/main', 'MainController@index');
Route::post('/main/checklogin', 'MainController@checklogin');
Route::get('main/successlogin', 'MainController@successlogin');
Route::get('main/logout', 'MainController@logout');

Route::get('emp_login', 'loginController@showLogin');


Route::get('/home', 'HomeController@index')->name('home');
Route::get('/l', 'loginController@newl');
Route::get('session/set','SessionController@storeSessionData');
Route::get('session/remove','SessionController@deleteSessionData');

Route::get('/empReport', function () {

  return view('dynamicEmp_pdf');
 
});

Route::get('/leaveReport', function () {

  return view('dynamicLeave_pdf');
 
});

Route::get('/shortLeaveReport', function () {

  return view('dynamicShortLeave_pdf');
 
});


Route::get('/profile', function () {

  return redirect('session/get');
 
});
Route::get('session/get','SessionController@accessSessionData');

//Route::get('/viewEmp', function () {

  //return redirect('session/get');
 
//});

Route::get('/myProfileView/{id}','EmployeeController@viewProfile');
Route::get('/updateemp/{employee_id}','EmployeeController@updateempview');

Route::get('/empview/{employee_id}','EmployeeController@empview');
//Route::get('/updateMyProfile/{employee_id}','EmployeeController@updateProfview');

Route::post('/updateemployee','EmployeeController@updateemp');
Route::get('/myProfileView/{id}','EmployeeController@viewProfile');

Route::get('/leave', function () {
  $data=App\Leave::all();
  return view('leaveForm')->with('leaveForm',$data);
});
Route::get('/sleave', function () {
  $data=App\ShortLeave::all();
  return view('shortLeaveForm')->with('shortLeaveForm',$data);
});


Route::get('/approval', function () {
  $data=App\Leave::all();
  return view('leaveApproval')->with('leaveApproval',$data);
});
Route::get('/sapproval', function () {
  $data=App\ShortLeave::all();
  return view('shortLeaveApproval')->with('shortLeaveApproval',$data);
});


Route::post('/storeLeave','leaveApprovalController@storeLeave');
Route::post('/storeShortLeave','ShortLeaveApprovalController@storeShortLeave');

Route::get('/markasapproved/{leave_id}','leaveApprovalController@updateLeaveasApproved');
Route::get('/markSasapproved/{leave_id}','ShortLeaveApprovalController@updateShortLeaveasApproved');


Route::get('/markasnotapproved/{leave_id}','leaveApprovalController@updateLeaveasRejected');
Route::get('/markSasnotapproved/{leave_id}','ShortLeaveApprovalController@updateShortLeaveasRejected');

Route::get('/deleteLeave/{leave_id}','leaveApprovalController@deleteLeave');
Route::get('/deleteSLeave/{leave_id}','ShortLeaveApprovalController@deleteShortLeave');


Route::get('/loginView', function(){
  // $data = DB::table('whole_sale_buyers');
   //return view('/buyerEvaluate',['data' =>$data]);
   return view('loginView');
  
 });

Route::post('/loginValidate', 'loginController@loginValidate'); 

 Route::get('/signUp', function(){
  // $data = DB::table('whole_sale_buyers');
   //return view('/buyerEvaluate',['data' =>$data]);
   return view('signUp');
});


Route::post('/Registered', 'loginController@RegisteredEmployee'); 

Route::get('session/get','loginController@accessSessionData');

Route::get('/signOut','loginController@SignOut');
Route::get('session/remove','loginController@deleteSessionData');

Route::get('/subEmp', function(){
  
   return view('subEmployee');
});

Route::get('/leaveManage', function(){
  
  return view('leaveManager');
});

/*Route::get('/applyLeave', function(){
  
  return view('applyLeave');
});*/


Route::get('/forgetPassword', function(){
 
   return view('forgetPassword');
  
 });

Route::post('/forgotPassword', 'loginController@forgotPasswordValidate'); 

Route::get('/resetPassword', function(){
 
   return view('resetPassword');
});

Route::post('/resetP', 'loginController@ResetPassword'); 

Route::get('/checkRole', function () {

  return redirect('session/getStock');
 
});

Route::get('session/getStock','loginController@accessSessionDataStock');

Route::get('/subStockMenu', function () {

  $name=App\EmpDetails::all();
  return view('subStockMenu')->with ('name',$name);;
});

Route::get('/checkRoleSupBuyer', function () {

  return redirect('session/getSupBuyer');
 
});

Route::get('session/getSupBuyer','loginController@accessSessionSupBuyer');

Route::get('/checkRolerOrders', function () {

  return redirect('session/getOrders');
 
});

Route::get('session/getOrders','loginController@accessSessionOrders');

Route::get('/checkRoleTrasport', function () {

  return redirect('session/getTrasport');
 
});

Route::get('session/getTrasport','loginController@accessSessionTrasport');

Route::get('/checkRoleFinance', function () {

  return redirect('session/getFinance');
 
});
Route::get('session/getFinance','loginController@accessSessionFinance');


Route::get('/checkRoleEmployee', function () {

  return redirect('session/getEmployee');
 
});
Route::get('session/getEmployee','loginController@accessSessionEmployee');

Route::get('/checkRoleResource', function () {

  return redirect('session/getResource');
 
});
Route::get('session/getResource','loginController@accessSessionResource');


Route::get('/checkRoleFeedback', function () {

  return redirect('session/getFeedback');
 
});

Route::get('session/getFeedback','loginController@accessSessionFeedback');

Route::get('/checkRoleEmployee', function () {

  return redirect('session/getEmployee');
 
});

Route::get('session/getEmployee','loginController@accessSessionEmployee');

Route::get('/checkRolerwOrders', function () {

  return redirect('session/Worders');
 
});

Route::get('session/Worders','loginController@accessSessionWOrders');


Route::get('/dynamicEmp_pdf', 'DynamicEmployeePDFController@index');
Route::get('/dynamicLeave_pdf', 'DynamicEmployeePDFController@indexLeave');
Route::get('/dynamicShortLeave_pdf', 'DynamicEmployeePDFController@indexShortLeave');
//Route::get('/dynamicSingleEmp_pdf/{$reg_no}', 'DynamicEmployeePDFController@indexSingleEmp');

//call pdf method of dynamic controller
Route::get('/dynamicEmp_pdf/pdf', 'DynamicEmployeePDFController@pdf');
Route::get('/dynamicLeave_pdf/pdf', 'DynamicEmployeePDFController@pdfLeave');
Route::get('/dynamicShortLeave_pdf/pdf', 'DynamicEmployeePDFController@pdfShortLeave');
Route::get('/dynamicSingleEmp_pdf/pdf/{reg_no}', 'DynamicEmployeePDFController@pdfSingleEmp');
Route::get('/dynamicSingleEmp_pdf/{reg_no}','DynamicEmployeePDFController@singleEmployeeProfileView');




Route::get('/searchEmp','EmployeeController@searchEmployee');

Route::get('/dynamicSingleEmp_pdf', function(){
  // $data = DB::table('whole_sale_buyers');
   //return view('/buyerEvaluate',['data' =>$data]);
   return view('dynamicSingleEmp_pdf');
  
 });




 /////////////////////NIMESHA///////////////////////////




 /////////////////Stock Management/////////////////

Route::get('/subStockMenu', function () {
  return view('subStockMenu');
});

Route::post('/saveItem','ItemController@store');
Route::get('/display/items','ItemController@index')->name('item_registration');
Route::get('/editItems/{id}','ItemController@edit');

Route::post('/updateItem/{id}','ItemController@update');

Route::delete('/deleteItem/{id}','ItemController@destroy');

Route::get('/getItemNo','StockItemController@getItemNos');
Route::get('/getItemDetails','StockItemController@getItemDetails');

Route::get('/itemsCharts', 'ItemController@itemsCharts');
Route::get('/itemsBarCharts/{from_date}/{to_date}','ItemController@itemsBarCharts');
Route::get('itemsPieCharts/{from_date}/{to_date}', 'ItemController@itemsPieCharts');

Route::post('/saveStock','StockItemController@store');
Route::get('/display/stocks','StockItemController@index')->name('add_stock');
Route::get('/editStockItems/{id}','StockItemController@edit');
Route::post('/updateStockItems/{id}','StockItemController@update');
Route::delete('/deleteStockItem/{id}','StockItemController@destroy');
Route::get('/searchStocks', 'StockItemController@searchStocks');

Route::get('/stocksCharts', 'StockItemController@stocksCharts');
Route::get('/stocksBarCharts/{from_date}/{to_date}','StockItemController@stocksBarCharts');
Route::get('/stocksPieCharts/{from_date}/{to_date}', 'StockItemController@stocksPieCharts');

Route::get('/GRN/getItemNo', 'GoodsReceiveController@getItemNos');
Route::get('/GRN/getItemDetails', 'GoodsReceiveController@getItemDetails');

Route::get('/GRN/getForeignSupplierNo', 'GoodsReceiveController@getForeignSupplierNos');
Route::get('/getForeignSupplierDetails', 'GoodsReceiveController@getForeignSupplierDetails');

Route::post('/saveReceivedGoods', 'GoodsReceiveController@store');
Route::get('/display/ReceivedGoods', 'GoodsReceiveController@index')->name('receivedGoods');
Route::get('/searchGRNs', 'GoodsReceiveController@searchGRNs');
/*Route::get('/addReceivedGoods', function () {
  return view('goods_receive');
});*/
Route::get('/editReceivedGoods/{id}','GoodsReceiveController@edit');
Route::post('/updateReceivedGoods/{id}','GoodsReceiveController@update');
Route::delete('/deleteReceivedGood/{id}','GoodsReceiveController@destroy');

Route::get('/goodsReceiveCharts', 'GoodsReceiveController@goodsReceiveCharts');
Route::get('/goodsReceiveBarCharts/{from_date}/{to_date}','GoodsReceiveController@goodsReceiveBarCharts');
Route::get('/goodsReceivePieCharts/{from_date}/{to_date}', 'GoodsReceiveController@goodsReceivePieCharts');


Route::get('/GRE/getItemNo', 'GoodsReturnController@getItemNos');
Route::get('/GRE/getItemDetails', 'GoodsReturnController@getItemDetails');

Route::post('/saveReturnGoods', 'GoodsReturnController@store');
Route::get('/display/ReturnGoods', 'GoodsReturnController@index')->name('returnGoods');

/*Route::get('/returnItemNote', function () {
  return view('goods_return');
});*/
Route::get('/editReturnGoods/{id}','GoodsReturnController@edit');
Route::post('/updateReturnGoods/{id}','GoodsReturnController@update');
Route::delete('/deleteReturnGood/{id}','GoodsReturnController@destroy');
Route::get('/searchGREs', 'GoodsReturnController@searchGREs');

Route::get('/goodsReturnCharts', 'GoodsReturnController@goodsReturnCharts');
Route::get('/goodsReturnBarCharts/{from_date}/{to_date}','GoodsReturnController@goodsReturnBarCharts');
Route::get('/goodsReturnPieCharts/{from_date}/{to_date}', 'GoodsReturnController@goodsReturnPieCharts');



Route::get('/search','ItemController@search');
Route::get('/searchResults', function () {
  return view('itemSearchResults');
});
Route::get('/reorderItems/rol', 'StockItemController@rolItems');
Route::get('/reorderItemsSearch/rol', 'StockItemController@rolItemsSearch');
/*Route::get('/rolItems', function () {
  return view('reOrderLevelItems');
});*/
Route::get('/reorderItems/reports', 'StockItemController@rolItemsReportAll');
Route::get('/rolItemsReport/PDF', 'StockItemController@rolStocksReportPDF');

Route::get('/rolItemsCharts', 'StockItemController@rolItemsCharts');
Route::get('/rolItemsBarCharts/','StockItemController@rolItemsBarCharts');
Route::get('/rolItemsPieCharts/', 'StockItemController@rolItemsPieCharts');


Route::get('/itemsReports','ItemController@itemsReportAll');
Route::get('/itemsReports/DateFilter','ItemController@itemsReportAll');
Route::get('/itemsReports/PDF/{from_date}/{to_date}','ItemController@itemsReportPDF');

Route::get('/stocksReports','StockItemController@stocksReportAll');
Route::get('/stocksReports/DateFilter','StockItemController@stocksReportAll');
Route::get('/stocksReports/PDF/{from_date}/{to_date}','StockItemController@stocksReportPDF');

Route::get('/search/items','StockItemController@searchItems');

Route::get('/searchedStocksReport/PDF/{item_no}','StockItemController@searchedStocksReportPDF');


Route::get('/goodsReturnReports','GoodsReturnController@greReportAll');
Route::get('/goodsReturnReports/DateFilter','GoodsReturnController@greReportAll');
Route::get('/goodsReturnReports/PDF/{from_date}/{to_date}','GoodsReturnController@GoodsReturnPDF');

Route::get('/goodsReturnNotes/Print/PDF/{item_no}/{gre_no}', 'GoodsReturnController@goodsReturnNotesPrintPDF');

Route::get('/goodsReceiveReports','GoodsReceiveController@grnReportAll');
Route::get('/goodsReceiveReports/DateFilter','GoodsReceiveController@grnReportAll');
Route::get('/goodsReceiveReports/PDF/{from_date}/{to_date}','GoodsReceiveController@GoodsReceivePDF');

Route::get('/goodsReceivedNotes/PDF/{item_no}/{grn_no}/{sup_no}','GoodsReceiveController@goodsReceivedNotesPDF');





///////////////////////////////////////Anuththara////////////////////////////////////





route::get('/createInvoice',function(){
  return view('newInvoice');
});


route::get('/goodReturnAdd',function(){
return view('goodReturnAdd');
});
route::get('/goodView',function(){
return view('goodView');
});

route::get('/searchResultInvoice',function(){
return view('searchResultInvoice');
});



route::get('/visitNewInvoice',function(){
return view('visitNewInvoice');
});

route::get('/visitGoodInvoice',function(){
return view('visitGoodInvoice');
});

//View Invoice Page
Route::get('/newInvoice','controllerPage@newI');

Route::get('/visitNewInvoice','controllerPage@newGI');

//View Good R Invoice Page
//Route::get('/searchResultInvoice','controllerPage@newGI');

Route::get('/itemdelete/{i_List}/{id}','controllerPage@itemdelete');



//add
Route::get('/itemAdd/{i_List}/{id}','controllerPage@itemAddview');

//add to the GRI 
Route::get('/addGoodRData', 'controllerPage@itemAdd');

//Route::get('sig/edit/{id}/{ticketid}', 'TicketsController@edit');

//add buyer id  and seller id
Route::post('/readyids/{id}','controllerPage@readyids');


//add discount and do other calculation 
Route::get('/addDiscount/{id}','controllerPage@addDis');

////Route::get('/editInvoice','controllerPage@editI');
Route::get('/editItem/{i_List}','controllerPage@updateInvoiceView');

//action 4 update button
Route::post('/updateInvoice/{i_List}','controllerPage@updateInvoiceData');

Route::get('/goodRetrunInvoice','controllerPage@gudRI');

Route::get('/editGoodRetrunInvoice','controllerPage@egudRI');

Route::get('/wholeSaleBuyer','controllerPage@wsbuyer');

Route::get('/newInvoive','controllerPage@getData');

//dynamic dropdown
Route::post('/newInvoice','controllerPage@fetch')->name('dynamicdependent.fetch');
//dynamic dropdown


//Route::resource('editI','controllerPage');


Route::get('/db','controllerPage@index');

//Route::get('/enter_details','controllerPage@insert');



Route::post('/newInvoive','controllerPage@insert');

//create new invoice Id
Route::post('/createInvoiceID','controllerPage@createInvoiceID');


//create new Good Return invoice Id
Route::post('/createGRInvoiceID','controllerPage@createGRInvoiceID');

Route::get('/createInvoice',function(){

 

  $list = App\item::all();
  return view('/newInvoice')->with('list', $list);
 
 
});

//Route::get('/editItem/{item_no}','controllerPage@editItem');

Route::get('/editItemView/{i_List}','controllerPage@editItemView');

Route::get('/orderManageMenu', function () {
  return view('orderManagMenu');
});



Route::get('wsbuyer', function(){
  return view('wsbuyer');
});


Route::get('grn', function(){
  return view('gdrInvoice');
});

Route::get('/search','controllerPage@searchInvoice');

//PDF 
Route::get('dynamic_pdf_Invoice','controllerPage@index_in_item_Detail');

Route::get('/dynamic_pdf_Invoice/pdf/{id}','controllerPage@pdf_invoice');

//finish view
Route::get('/finishedView/{id}','controllerPage@finishInvoiceView');

Route::get('/finalView', function () {
  return view('finalView');
});



Route::get('/dynamic_pdf_GRInvoice/pdf/{id}','controllerPage@pdf_grinvoice');
