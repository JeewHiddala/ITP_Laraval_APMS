<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use DB;
use App\courier_service;
use App\invoice;
use App\wholeSaleBuyer;
use App\EmpDetails;
use App\Vehicle;
use App\deliver_by_own_vehicles;
use App\deliver_by_courier_service;
use App\daily_visit;
use App\Delivery;
use App\deliver_through_company_vehicles;
use App\deliver_through_courier_services;



class courier_controller extends Controller
{

//Search Functions

    public function searchDC(Request $request){

        $search = $request->get('searchBar');
        
        /*$data = DB::table('deliver_by_courier_services')
        ->join('whole_sale_buyers','whole_sale_buyers.reg_no','buyer_id')
        ->join('courier_services','courier_services.id','courier_id')
        ->select('deliver_by_courier_services.id','deliver_by_courier_services.invoice_id','whole_sale_buyers.buyer_name','whole_sale_buyers.address','whole_sale_buyers.mobile','whole_sale_buyers.land','whole_sale_buyers.email','courier_services.company_name','deliver_by_courier_services.date','deliver_by_courier_services.total')
        ->where('whole_sale_buyers.buyer_name','LIKE', '%'  .$search.'%')->paginate(5);*/

         $data = DB::table('deliver_through_courier_services')
         ->join('deliveries','deliveries.id','deliver_through_courier_services.delivery_id')
        ->join('whole_sale_buyers','whole_sale_buyers.reg_no','deliveries.buyer_id')
        ->join('courier_services','courier_services.id','deliver_through_courier_services.courier_id')
        ->select('deliveries.id','deliveries.invoice_id','whole_sale_buyers.buyer_name','whole_sale_buyers.address','whole_sale_buyers.mobile','whole_sale_buyers.land','whole_sale_buyers.email','courier_services.company_name','deliveries.date','deliveries.total')
        ->where('whole_sale_buyers.buyer_name','LIKE', '%'  .$search.'%')
        ->orWhere('deliveries.id','LIKE', '%'  .$search. '%' )
        ->orWhere('whole_sale_buyers.mobile','LIKE', '%'  .$search. '%' )
        ->paginate(5);

        return view('searchDiliverByCourier',['data' =>$data]);

    }


    public function searchDO(Request $request){

        $search = $request->get('searchBar');
        
        /*$data = DB::table('deliver_by_own_vehicles')
        ->join('whole_sale_buyers','whole_sale_buyers.reg_no','buyer_id')
        ->join('emp_details','emp_details.employee_id','driver_id')
        ->join('vehicles','vehicles.id','vehicle_id')
        ->select('deliver_by_own_vehicles.id','deliver_by_own_vehicles.invoice_id','whole_sale_buyers.buyer_name','whole_sale_buyers.address','whole_sale_buyers.mobile','whole_sale_buyers.land','whole_sale_buyers.email','emp_details.name','vehicles.vehi_reg_no','deliver_by_own_vehicles.date','deliver_by_own_vehicles.total')
        ->where('whole_sale_buyers.buyer_name','LIKE', '%'  .$search. '%' )->paginate(5);
        return view('searchDeliverByOwn',['data' =>$data]);*/

        $data = DB::table('deliver_through_company_vehicles')
        ->join('deliveries','deliveries.id','deliver_through_company_vehicles.delivery_id')
        ->join('whole_sale_buyers','whole_sale_buyers.reg_no','deliveries.buyer_id')
        ->join('emp_details','emp_details.employee_id','deliver_through_company_vehicles.driver_id')
        ->join('vehicles','vehicles.id','deliver_through_company_vehicles.vehicle_id')
        ->select('deliveries.id','deliveries.invoice_id','whole_sale_buyers.buyer_name','whole_sale_buyers.address','whole_sale_buyers.mobile','whole_sale_buyers.land','whole_sale_buyers.email','emp_details.name','vehicles.vehi_reg_no','deliveries.date','deliveries.total')
        ->where('whole_sale_buyers.buyer_name','LIKE', '%'  .$search. '%' )
        ->orWhere('deliveries.id','LIKE', '%'  .$search. '%' )
        ->orWhere('whole_sale_buyers.mobile','LIKE', '%'  .$search. '%' )
        ->paginate(5);
        return view('searchDeliverByOwn',['data' =>$data]);

    }

    public function searchCu(Request $request){

        $search = $request->get('searchBar');
        
        $data = DB::table('courier_services')
        ->where('company_name','LIKE', '%'  .$search. '%' )
        ->orWhere('id','LIKE', '%'  .$search. '%' )
        ->orWhere('mobile','LIKE', '%'  .$search. '%' )
        ->paginate(5);
        
        return view('searchCourierService',['data' =>$data]);
        

    }

    public function searchVi(Request $request){

        $search = $request->get('searchBar');
        
        $data = DB::table('daily_visits')
        ->join('emp_details','emp_details.employee_id','driver_id')
        ->join('vehicles','vehicles.id','vehicle_id')
        ->select('daily_visits.id','daily_visits.date','daily_visits.departure','daily_visits.arrival','daily_visits.fuel','daily_visits.purpose','emp_details.name','vehicles.vehi_reg_no')
        ->where('daily_visits.id','LIKE', '%'  .$search. '%' )
        ->orWhere('emp_details.name','LIKE', '%'  .$search. '%' )
        ->paginate(5);
        
        return view('/search_official_visits',['data' =>$data]);
        

    }




//Courier Service Registration

    public function store(Request $request){
       //dd($request->all());

       $courier = new courier_service;

       $this->validate($request,[
           'company_name'=>'required|max:100|min:1',
           'address'=>'required|max:100|min:1',
           'district'=>'required|max:100|min:1',
           'land'=>'required|max:10|min:1',
           'mobile'=>'required|max:10|min:1',
           'fax'=>'required|max:10|min:1',
           'e_mail'=>'required|max:100|min:1',
           
       ]);

       

        $courier->company_name=$request->company_name;
        $courier->address=$request->address;
        $courier->district=$request->district;
        $courier->land=$request->land;
        $courier->mobile=$request->mobile;
        $courier->fax=$request->fax;
        $courier->e_mail=$request->e_mail;
        $courier->save();

        $data= courier_service::paginate(5);
        //dd($data);
        //return view('/courier_service_reg')->with('courier_service',$data);
        return redirect("/courier");
        //return redirect()->back();

        
        //return view('/courier_service_reg');
       


    }

    public function delcourier($id){

        $courier=courier_service::find($id);
        $courier->delete();

        $datas= courier_service::paginate(5);
        //return view('/courier_service_reg')->with('courier_service',$datas); 
        return redirect("/courier");

    }

    public function updatecourier($id){

        $courier=courier_service::find($id);

        return view('/update_courier')->with('courierdata',$courier);

    }

    public function updatecouriers(Request $request){

        $id=$request->id;
        $company_name=$request->company_name;
        $address=$request->address;
        $district=$request->district;
        $land=$request->land;
        $mobile=$request->mobile;
        $fax=$request->fax;
        $e_mail=$request->e_mail;

   

        $data=courier_service::find($id);

        $data->company_name=$company_name;
        $data->address=$address;
        $data->district=$district;
        $data->land=$land;
        $data->mobile=$mobile;
        $data->fax=$fax;
        $data->e_mail=$e_mail;

        $data->save();

        $datas= courier_service::paginate(5);
        //return view('/courier_service_reg')->with('courier_service',$datas);        
        return redirect("/courier");
    }

    /*public function index(){

        $invoices = invoice::all(['id','invoice_name']);
        return view('/deliver_by_company_vehicles',compact('invoices'));
        dd($invoices);

        
    }*/



//Delivery | Wholesale buyer details | To Ajax 

public function getCusName2(Request $request) 
{        

        $data= wholeSaleBuyer::select('buyer_name','address','mobile','land','email','reg_no')->where('reg_no',$request->id)->first();
        return response()->json($data);//then sent this data to ajax success

}






//Delivery By Company Vehicles


    public function getInvoices()
    {
        //$invoices = DB::table('invoices')->pluck("invoice_name","id");
        $invoices = invoice::all();
        $driver = EmpDetails::all()->where('designation','Driver');
        $vehicle = Vehicle::all();
        //dd($invoices);

        /*$data = DB::table('deliver_by_own_vehicles')
        ->join('whole_sale_buyers','whole_sale_buyers.reg_no','buyer_id')
        ->join('emp_details','emp_details.employee_id','driver_id')
        ->join('vehicles','vehicles.id','vehicle_id')
        ->select('deliver_by_own_vehicles.id','deliver_by_own_vehicles.invoice_id','whole_sale_buyers.buyer_name','whole_sale_buyers.address','whole_sale_buyers.mobile','whole_sale_buyers.land','whole_sale_buyers.email','emp_details.name','vehicles.vehi_reg_no','deliver_by_own_vehicles.date','deliver_by_own_vehicles.total')
        ->get();*/

        ////////////////////////////NEW CODE////////////////////////

        $data = DB::table('deliver_through_company_vehicles')
        ->join('deliveries','deliveries.id','deliver_through_company_vehicles.delivery_id')
        ->join('whole_sale_buyers','whole_sale_buyers.reg_no','buyer_id')
        ->join('emp_details','emp_details.employee_id','deliver_through_company_vehicles.driver_id')
        ->join('vehicles','vehicles.id','deliver_through_company_vehicles.vehicle_id')
        ->select('deliveries.id','deliveries.invoice_id','whole_sale_buyers.buyer_name','whole_sale_buyers.address','whole_sale_buyers.mobile','whole_sale_buyers.land','whole_sale_buyers.email','emp_details.name','vehicles.vehi_reg_no','deliveries.date','deliveries.total')
        ->paginate(5);

        ///////////////////////////////////////////////////////////

        return view('/deliver_by_company_vehicles',compact('invoices','driver','vehicle','data'));

    }


    public function storeDelivary(Request $request){

    //dd($request->all());

    $deliver = new deliver_by_own_vehicles;


    $this->validate($request,[
        'invoice_id'=>'required|max:100|min:1',
        'buyer_id'=>'required|max:100|min:1',
        'address'=>'required|max:100|min:1',
        'driver_id'=>'required|max:100|min:1',
        'vehicle_id'=>'required|max:10|min:1',
        'mobile_phone'=>'required|max:10|min:1',
        'land_phone'=>'required|max:10|min:1',
        'email'=>'required|max:100|min:1',
        'date'=>'required|max:10|min:1',
        'total'=>'required|max:100|min:1',
        
    ]);

    ////////////////////////////////NEW CODE/////////////////////////////
    $delivery = new Delivery;
    $O_delivery = new deliver_through_company_vehicles;

    $delivery->invoice_id=$request->invoice_id;
    $delivery->buyer_id=$request->buyer_id;
    $delivery->date=$request->date;
    $delivery->total=$request->total;
    $delivery->d_type= "Through Company Vehicles";

    $delivery->save();

    $O_delivery->delivery_id = $delivery->id;
    $O_delivery->driver_id=$request->driver_id;
    $O_delivery->vehicle_id=$request->vehicle_id;

    $O_delivery->save();




    ////////////////////////////////////////////////////////////////////

    

     /*$deliver->invoice_id=$request->invoice_id;
     $deliver->buyer_id=$request->buyer_id;
     $deliver->driver_id=$request->driver_id;
     $deliver->vehicle_id=$request->vehicle_id;
     $deliver->date=$request->date;
     $deliver->total=$request->total;
     //dd($deliver);

     $deliver->save();*/

     $invoices = invoice::all();
     $driver = EmpDetails::all()->where('designation','Driver');
     $vehicle = Vehicle::all();

     /*$data = DB::table('deliver_by_own_vehicles')
     ->join('whole_sale_buyers','whole_sale_buyers.reg_no','buyer_id')
     ->join('emp_details','emp_details.employee_id','driver_id')
     ->join('vehicles','vehicles.id','vehicle_id')
     ->select('deliver_by_own_vehicles.id','deliver_by_own_vehicles.invoice_id','whole_sale_buyers.buyer_name','whole_sale_buyers.address','whole_sale_buyers.mobile','whole_sale_buyers.land','whole_sale_buyers.email','emp_details.name','vehicles.vehi_reg_no','deliver_by_own_vehicles.date','deliver_by_own_vehicles.total')
     ->get();*/

     /////////////////////////////////////////NEW CODE/////////////////////////////
     $data = DB::table('deliver_through_company_vehicles')
     ->join('deliveries','deliveries.id','deliver_through_company_vehicles.delivery_id')
     ->join('whole_sale_buyers','whole_sale_buyers.reg_no','buyer_id')
     ->join('emp_details','emp_details.employee_id','deliver_through_company_vehicles.driver_id')
     ->join('vehicles','vehicles.id','deliver_through_company_vehicles.vehicle_id')
     ->select('deliveries.id','deliveries.invoice_id','whole_sale_buyers.buyer_name','whole_sale_buyers.address','whole_sale_buyers.mobile','whole_sale_buyers.land','whole_sale_buyers.email','emp_details.name','vehicles.vehi_reg_no','deliveries.date','deliveries.total')
     ->paginate(5);

     //dd($data);
    /////////////////////////////////////////////////////////////////////////////
   // return view('/deliver_by_company_vehicles',compact('invoices','driver','vehicle','data'));
   return redirect("/deliver1");
    
     //$deliver->save();
     //$data= courier_service::all();
     //dd($data); 
     //return redirect()->back();  
     //return view('/courier_service_reg')

}

public function deldelivery($id){


    /*$deliver = deliver_by_own_vehicles::find($id);
    $deliver->delete();*/

    $deliver = Delivery::find($id);
    $deliver->delete();



    $invoices = invoice::all();
    $driver = EmpDetails::all()->where('designation','Driver');
    $vehicle = Vehicle::all();

    /*$data = DB::table('deliver_by_own_vehicles')
    ->join('whole_sale_buyers','whole_sale_buyers.reg_no','buyer_id')
    ->join('emp_details','emp_details.employee_id','driver_id')
    ->join('vehicles','vehicles.id','vehicle_id')
    ->select('deliver_by_own_vehicles.id','deliver_by_own_vehicles.invoice_id','whole_sale_buyers.buyer_name','whole_sale_buyers.address','whole_sale_buyers.mobile','whole_sale_buyers.land','whole_sale_buyers.email','emp_details.name','vehicles.vehi_reg_no','deliver_by_own_vehicles.date','deliver_by_own_vehicles.total')
    ->get();*/

    $data = DB::table('deliver_through_company_vehicles')
    ->join('deliveries','deliveries.id','deliver_through_company_vehicles.delivery_id')
    ->join('whole_sale_buyers','whole_sale_buyers.reg_no','buyer_id')
    ->join('emp_details','emp_details.employee_id','deliver_through_company_vehicles.driver_id')
    ->join('vehicles','vehicles.id','deliver_through_company_vehicles.vehicle_id')
    ->select('deliveries.id','deliveries.invoice_id','whole_sale_buyers.buyer_name','whole_sale_buyers.address','whole_sale_buyers.mobile','whole_sale_buyers.land','whole_sale_buyers.email','emp_details.name','vehicles.vehi_reg_no','deliveries.date','deliveries.total')
    ->paginate(5);

    //return view('/deliver_by_company_vehicles',compact('invoices','driver','vehicle','data'));
    return redirect("/deliver1");

}

public function updatedelevery($id){

    //$deliver = deliver_by_own_vehicles::find($id);

    /*$data = DB::table('deliver_by_own_vehicles')
    ->join('whole_sale_buyers','whole_sale_buyers.reg_no','buyer_id')
    ->join('emp_details','emp_details.employee_id','driver_id')
    ->join('vehicles','vehicles.id','vehicle_id')
    ->select('deliver_by_own_vehicles.id','deliver_by_own_vehicles.driver_id','deliver_by_own_vehicles.vehicle_id','deliver_by_own_vehicles.invoice_id','whole_sale_buyers.buyer_name','whole_sale_buyers.address','whole_sale_buyers.mobile','whole_sale_buyers.land','whole_sale_buyers.email','emp_details.name','vehicles.vehi_reg_no','deliver_by_own_vehicles.date','deliver_by_own_vehicles.total')->where('deliver_by_own_vehicles.id',$id)
    ->first();*/

    //dd($id);

    $data = DB::table('deliver_through_company_vehicles')
    ->join('deliveries','deliveries.id','deliver_through_company_vehicles.delivery_id')
    ->join('whole_sale_buyers','whole_sale_buyers.reg_no','buyer_id')
    ->join('emp_details','emp_details.employee_id','deliver_through_company_vehicles.driver_id')
    ->join('vehicles','vehicles.id','deliver_through_company_vehicles.vehicle_id')
    ->select('deliveries.id','deliver_through_company_vehicles.driver_id','deliver_through_company_vehicles.vehicle_id','deliveries.invoice_id','whole_sale_buyers.buyer_name','whole_sale_buyers.address','whole_sale_buyers.mobile','whole_sale_buyers.land','whole_sale_buyers.email','emp_details.name','vehicles.vehi_reg_no','deliveries.date','deliveries.total')->where('deliver_through_company_vehicles.delivery_id',$id)
    ->first();

    //dd($data);

    $driver = EmpDetails::all()->where('designation','Driver');
    $vehicle = Vehicle::all();

    return view('/update_deliver_by_company_vehicles',compact('data','driver','vehicle'));

}

public function updatedeliveries(Request $request){

    $id=$request->delivery_id;
    $vehi_reg_no=$request->vehicle_id;
    $driver_id=$request->driver_id;
    $date=$request->date;
    $total=$request->total;

    //dd($vehi_reg_no);




    /*$data=deliver_by_own_vehicles::find($id);

    $data->vehicle_id=$vehi_reg_no;
    $data->driver_id=$driver_id;
    $data->date=$date;
    $data->total=$total;*/

    $data_Delivery_Table=Delivery::find($id);

    $data_Delivery_Table->date=$date;
    $data_Delivery_Table->total=$total;

    $data_DCompany_Table = deliver_through_company_vehicles::where('delivery_id',$id)
    ->update(['vehicle_id' => $vehi_reg_no,'driver_id' => $driver_id]);

    $data_Delivery_Table->save();

    $invoices = invoice::all();
    $driver = EmpDetails::all()->where('designation','Driver');
    $vehicle = Vehicle::all();

    /*$data = DB::table('deliver_by_own_vehicles')
    ->join('whole_sale_buyers','whole_sale_buyers.reg_no','buyer_id')
    ->join('emp_details','emp_details.employee_id','driver_id')
    ->join('vehicles','vehicles.id','vehicle_id')
    ->select('deliver_by_own_vehicles.id','deliver_by_own_vehicles.invoice_id','whole_sale_buyers.buyer_name','whole_sale_buyers.address','whole_sale_buyers.mobile','whole_sale_buyers.land','whole_sale_buyers.email','emp_details.name','vehicles.vehi_reg_no','deliver_by_own_vehicles.date','deliver_by_own_vehicles.total')
    ->get();*/

    $data = DB::table('deliver_through_company_vehicles')
    ->join('deliveries','deliveries.id','deliver_through_company_vehicles.delivery_id')
    ->join('whole_sale_buyers','whole_sale_buyers.reg_no','buyer_id')
    ->join('emp_details','emp_details.employee_id','deliver_through_company_vehicles.driver_id')
    ->join('vehicles','vehicles.id','deliver_through_company_vehicles.vehicle_id')
    ->select('deliveries.id','deliveries.invoice_id','whole_sale_buyers.buyer_name','whole_sale_buyers.address','whole_sale_buyers.mobile','whole_sale_buyers.land','whole_sale_buyers.email','emp_details.name','vehicles.vehi_reg_no','deliveries.date','deliveries.total')
    ->paginate(5);



   // return view('/deliver_by_company_vehicles',compact('invoices','driver','vehicle','data'));     
   return redirect("/deliver1");
}







//Delivary | Courier Service

public function getInvoices2()
{
    //$invoices = DB::table('invoices')->pluck("invoice_name","id");
    $invoices = invoice::all();
    $courier = courier_service::all();

    //dd($invoices);

    /*$data = DB::table('deliver_by_courier_services')
    ->join('whole_sale_buyers','whole_sale_buyers.reg_no','buyer_id')
    ->join('courier_services','courier_services.id','courier_id')
    ->select('deliver_by_courier_services.id','deliver_by_courier_services.invoice_id','whole_sale_buyers.buyer_name','whole_sale_buyers.address','whole_sale_buyers.mobile','whole_sale_buyers.land','whole_sale_buyers.email','courier_services.company_name','deliver_by_courier_services.date','deliver_by_courier_services.total')
    ->get();*/

    $data = DB::table('deliver_through_courier_services')
    ->join('deliveries','deliveries.id','deliver_through_courier_services.delivery_id')
   ->join('whole_sale_buyers','whole_sale_buyers.reg_no','deliveries.buyer_id')
   ->join('courier_services','courier_services.id','deliver_through_courier_services.courier_id')
   ->select('deliveries.id','deliveries.invoice_id','whole_sale_buyers.buyer_name','whole_sale_buyers.address','whole_sale_buyers.mobile','whole_sale_buyers.land','whole_sale_buyers.email','courier_services.company_name','deliveries.date','deliveries.total')
   ->paginate(5);

    return view('/deliver_by_courier_service',compact('invoices','courier','data'));

}


public function storeDelivary2(Request $request){

    //dd($request->all());

    $deliver = new deliver_by_courier_service;

    $this->validate($request,[

        'invoice_id'=>'required|max:100|min:1',
        'buyer_id'=>'required|max:100|min:1',
        'address'=>'required|max:100|min:1',
        'courier_id'=>'required|max:100|min:1',
        'mobile_phone'=>'required|max:10|min:1',
        'land_phone'=>'required|max:10|min:1',
        'email'=>'required|max:100|min:1',
        'date'=>'required|max:10|min:1',
        'total'=>'required|max:100|min:1',
        
    ]);

     /*$deliver->invoice_id=$request->invoice_id;
     $deliver->buyer_id=$request->buyer_id;
     $deliver->courier_id=$request->courier_id;
     $deliver->date=$request->date;
     $deliver->total=$request->total;
     //dd($deliver);

     $deliver->save();*/

     /////////////////////////////New Code//////////////////////
     $delivery = new Delivery;
     $C_delivery = new deliver_through_courier_services;
 
     $delivery->invoice_id=$request->invoice_id;
     $delivery->buyer_id=$request->buyer_id;
     $delivery->date=$request->date;
     $delivery->total=$request->total;
     $delivery->d_type= "Through Courier Services"; 
 
     $delivery->save();
 
     $C_delivery->delivery_id = $delivery->id;
     $C_delivery->courier_id=$request->courier_id;
 
     $C_delivery->save();
 
     //////////////////////////////////////////////////////////

     $invoices = invoice::all();
     $courier = courier_service::all();

     /*$data = DB::table('deliver_by_courier_services')
     ->join('whole_sale_buyers','whole_sale_buyers.reg_no','buyer_id')
     ->join('courier_services','courier_services.id','courier_id')
     ->select('deliver_by_courier_services.id','deliver_by_courier_services.invoice_id','whole_sale_buyers.buyer_name','whole_sale_buyers.address','whole_sale_buyers.mobile','whole_sale_buyers.land','whole_sale_buyers.email','courier_services.company_name','deliver_by_courier_services.date','deliver_by_courier_services.total')
     ->get();*/

     $data = DB::table('deliver_through_courier_services')
     ->join('deliveries','deliveries.id','deliver_through_courier_services.delivery_id')
    ->join('whole_sale_buyers','whole_sale_buyers.reg_no','deliveries.buyer_id')
    ->join('courier_services','courier_services.id','deliver_through_courier_services.courier_id')
    ->select('deliveries.id','deliveries.invoice_id','whole_sale_buyers.buyer_name','whole_sale_buyers.address','whole_sale_buyers.mobile','whole_sale_buyers.land','whole_sale_buyers.email','courier_services.company_name','deliveries.date','deliveries.total')
    ->paginate(5);

   // return view('/deliver_by_courier_service',compact('invoices','courier','data'));
   return redirect("/deliver2");   
     //$deliver->save();
     //$data= courier_service::all();
     //dd($data); 
     //return redirect()->back();  
     //return view('/courier_service_reg')

}

public function deldelivery2($id){

    /*$deliver = deliver_by_courier_service::find($id);
    $deliver->delete();*/

    $deliver = Delivery::find($id);
    $deliver->delete();


    $invoices = invoice::all();
    $courier = courier_service::all();

    /*$data = DB::table('deliver_by_courier_services')
    ->join('whole_sale_buyers','whole_sale_buyers.reg_no','buyer_id')
    ->join('courier_services','courier_services.id','courier_id')
    ->select('deliver_by_courier_services.id','deliver_by_courier_services.invoice_id','whole_sale_buyers.buyer_name','whole_sale_buyers.address','whole_sale_buyers.mobile','whole_sale_buyers.land','whole_sale_buyers.email','courier_services.company_name','deliver_by_courier_services.date','deliver_by_courier_services.total')
    ->get();*/

    $data = DB::table('deliver_through_courier_services')
    ->join('deliveries','deliveries.id','deliver_through_courier_services.delivery_id')
   ->join('whole_sale_buyers','whole_sale_buyers.reg_no','deliveries.buyer_id')
   ->join('courier_services','courier_services.id','deliver_through_courier_services.courier_id')
   ->select('deliveries.id','deliveries.invoice_id','whole_sale_buyers.buyer_name','whole_sale_buyers.address','whole_sale_buyers.mobile','whole_sale_buyers.land','whole_sale_buyers.email','courier_services.company_name','deliveries.date','deliveries.total')
   ->paginate(5);

  // return view('/deliver_by_courier_service',compact('invoices','courier','data'));
  return redirect("/deliver2");

}

public function updatedelivery2($id){

    //$deliver = deliver_by_own_vehicles::find($id);

    /*$data = DB::table('deliver_by_courier_services')
    ->join('whole_sale_buyers','whole_sale_buyers.reg_no','buyer_id')
    ->join('courier_services','courier_services.id','courier_id')
    ->select('deliver_by_courier_services.id','deliver_by_courier_services.invoice_id','whole_sale_buyers.buyer_name','whole_sale_buyers.address','whole_sale_buyers.mobile','whole_sale_buyers.land','whole_sale_buyers.email','deliver_by_courier_services.date','deliver_by_courier_services.total','deliver_by_courier_services.courier_id','courier_services.company_name')->where('deliver_by_courier_services.id',$id)
    ->first();*/

     $data = DB::table('deliver_through_courier_services')
     ->join('deliveries','deliveries.id','deliver_through_courier_services.delivery_id')
    ->join('whole_sale_buyers','whole_sale_buyers.reg_no','deliveries.buyer_id')
    ->join('courier_services','courier_services.id','deliver_through_courier_services.courier_id')
    ->select('deliveries.id','deliveries.invoice_id','whole_sale_buyers.buyer_name','whole_sale_buyers.address','whole_sale_buyers.mobile','whole_sale_buyers.land','whole_sale_buyers.email','deliveries.date','deliveries.total','deliver_through_courier_services.courier_id','courier_services.company_name')->where('deliveries.id',$id)
    ->first();

     $courier = courier_service::all();

     return view('/update_deliver_by_courier_service',compact('data','courier'));

}

public function updatedeliveries2(Request $request){

    //dd($request->all());

    $id=$request->delivery_id;
    $courier=$request->courier_id;
    $date=$request->date;
    $total=$request->total;

    /*$data=deliver_by_courier_service::find($id);

    $data->courier_id=$courier;
    $data->date=$date;
    $data->total=$total;

    $data->save();*/

    $data_Delivery_Table=Delivery::find($id);
    
        $data_Delivery_Table->date=$date;
        $data_Delivery_Table->total=$total;
    
        $data_DCompany_Table = deliver_through_courier_services::where('delivery_id',$id)
        ->update(['courier_id' => $courier]);
    
        $data_Delivery_Table->save();

    

    $invoices = invoice::all();
    $courier = courier_service::all();

    /*$data = DB::table('deliver_by_courier_services')
    ->join('whole_sale_buyers','whole_sale_buyers.reg_no','buyer_id')
    ->join('courier_services','courier_services.id','courier_id')
    ->select('deliver_by_courier_services.id','deliver_by_courier_services.invoice_id','whole_sale_buyers.buyer_name','whole_sale_buyers.address','whole_sale_buyers.mobile','whole_sale_buyers.land','whole_sale_buyers.email','courier_services.company_name','deliver_by_courier_services.date','deliver_by_courier_services.total')
    ->get();*/

    $data = DB::table('deliver_through_courier_services')
    ->join('deliveries','deliveries.id','deliver_through_courier_services.delivery_id')
   ->join('whole_sale_buyers','whole_sale_buyers.reg_no','deliveries.buyer_id')
   ->join('courier_services','courier_services.id','deliver_through_courier_services.courier_id')
   ->select('deliveries.id','deliveries.invoice_id','whole_sale_buyers.buyer_name','whole_sale_buyers.address','whole_sale_buyers.mobile','whole_sale_buyers.land','whole_sale_buyers.email','courier_services.company_name','deliveries.date','deliveries.total')
   ->paginate(5);

   //return view('/deliver_by_courier_service',compact('invoices','courier','data')); 
   return redirect("/deliver2");

}





//Official Visits

public function getVisits()
{
    //$invoices = DB::table('invoices')->pluck("invoice_name","id");
    $driver = EmpDetails::all()->where('designation','Driver');
    $vehicle = Vehicle::all();
    //dd($invoices);
    $data = DB::table('daily_visits')
    ->join('emp_details','emp_details.employee_id','driver_id')
    ->join('vehicles','vehicles.id','vehicle_id')
    ->select('daily_visits.id','daily_visits.date','daily_visits.departure','daily_visits.arrival','daily_visits.fuel','daily_visits.purpose','emp_details.name','vehicles.vehi_reg_no')
    ->paginate(5);

    return view('/daily_visits',compact('driver','vehicle','data'));

}

public function storeVisits(Request $request){

    //dd($request->all());

    $visit = new daily_visit;

    $this->validate($request,[
        'date'=>'required|max:100|min:2',
        'departure'=>'required|max:100|min:2',
        'arrival'=>'required|max:100|min:2',
        'purpose'=>'required|max:1000|min:2',
        'driver_id'=>'required|max:10|min:1',
        'vehicle_id'=>'required|max:10|min:1',
        'fuel'=>'required|max:100|min:2',
        
    ]);

     $visit->date=$request->date;
     $visit->departure=$request->departure;
     $visit->arrival=$request->arrival;
     $visit->purpose=$request->purpose;
     $visit->driver_id=$request->driver_id;
     $visit->vehicle_id=$request->vehicle_id;
     $visit->fuel=$request->fuel;
     //dd($visit);

     $visit->save();

     $driver = EmpDetails::all()->where('designation','Driver');
     $vehicle = Vehicle::all();


     $data = DB::table('daily_visits')
   
     ->join('emp_details','emp_details.employee_id','driver_id')
     ->join('vehicles','vehicles.id','vehicle_id')
     ->select('daily_visits.id','daily_visits.date','daily_visits.departure','daily_visits.arrival','daily_visits.fuel','daily_visits.purpose','emp_details.name','vehicles.vehi_reg_no')
     ->paginate(5);

     //return view('/daily_visits',compact('driver','vehicle','data'));
     return redirect("/visits");
    
     //$deliver->save();
     //$data= courier_service::all();
     //dd($data); 
     //return redirect()->back();  
     //return view('/courier_service_reg')*/

}

public function delvisit($id){

    $visit = daily_visit::find($id);
    $visit->delete();

     $driver = EmpDetails::all()->where('designation','Driver');
     $vehicle = Vehicle::all();


     $data = DB::table('daily_visits')
   
     ->join('emp_details','emp_details.employee_id','driver_id')
     ->join('vehicles','vehicles.id','vehicle_id')
     ->select('daily_visits.id','daily_visits.date','daily_visits.departure','daily_visits.arrival','daily_visits.fuel','daily_visits.purpose','emp_details.name','vehicles.vehi_reg_no')
     ->paginate(5);

    //return view('/daily_visits',compact('driver','vehicle','data'));
    return redirect("/visits");

}

public function updatevisit($id){

    $visit = daily_visit::find($id);

    $driver = EmpDetails::all()->where('designation','Driver');
    $vehicle = Vehicle::all();

    $data = DB::table('daily_visits')
    ->join('emp_details','emp_details.employee_id','driver_id')
    ->join('vehicles','vehicles.id','vehicle_id')
    ->select('daily_visits.id','daily_visits.driver_id','daily_visits.vehicle_id','daily_visits.date','daily_visits.departure','daily_visits.arrival','daily_visits.purpose','emp_details.name','vehicles.vehi_reg_no','daily_visits.fuel')->where('daily_visits.id',$id)
    ->first();



    return view('/update_daily_visits',compact('driver','vehicle','data'));

}

public function updatevisit2(Request $request){

    //dd($request->all());

    $visit_id=$request->visit_id;
    $date=$request->date;
    $departure=$request->departure;
    $arrival=$request->arrival;
    $purpose=$request->purpose;
    $driver_id=$request->driver_id;
    $vehicle_id=$request->vehicle_id;
    $fuel=$request->fuel;


    $data=daily_visit::find($visit_id);

    $data->date=$date;
    $data->departure=$departure;
    $data->arrival=$arrival;
    $data->purpose=$purpose;
    $data->driver_id=$driver_id;
    $data->vehicle_id=$vehicle_id;
    $data->fuel=$fuel;

    $data->save();

    $driver = EmpDetails::all()->where('designation','Driver');
    $vehicle = Vehicle::all();


    $data = DB::table('daily_visits')
  
    ->join('emp_details','emp_details.employee_id','driver_id')
    ->join('vehicles','vehicles.id','vehicle_id')
    ->select('daily_visits.id','daily_visits.date','daily_visits.departure','daily_visits.arrival','daily_visits.fuel','daily_visits.purpose','emp_details.name','vehicles.vehi_reg_no')
    ->paginate(5);

  // return view('/daily_visits',compact('driver','vehicle','data')); 
  return redirect("/visits");
}

}
