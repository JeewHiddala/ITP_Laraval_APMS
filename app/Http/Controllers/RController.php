<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class RController extends Controller
{
    public function getDCompanyData(Request $request){

        if(!empty($request->from_date))
        {

            $from_date = $request->from_date;
            $to_date = $request->to_date;

        $data = DB::table('deliver_through_company_vehicles')
        ->join('deliveries','deliveries.id','deliver_through_company_vehicles.delivery_id')
        ->join('whole_sale_buyers','whole_sale_buyers.reg_no','buyer_id')
        ->join('emp_details','emp_details.employee_id','deliver_through_company_vehicles.driver_id')
        ->join('vehicles','vehicles.id','deliver_through_company_vehicles.vehicle_id')
        ->select(['deliveries.id','deliveries.invoice_id','whole_sale_buyers.buyer_name','whole_sale_buyers.address','whole_sale_buyers.mobile','whole_sale_buyers.land','whole_sale_buyers.email','emp_details.name','vehicles.vehi_reg_no','deliveries.date','deliveries.total'])
        ->whereBetween('deliveries.date', array($request->from_date, $request->to_date))
        ->paginate(5);

        $total = DB::table('deliver_through_company_vehicles')
        ->join('deliveries','deliveries.id','deliver_through_company_vehicles.delivery_id')
        ->select([DB::raw('Sum(deliveries.total) OVER () AS total_cost')])
        ->whereBetween('deliveries.date', array($request->from_date, $request->to_date))
        ->value('total_cost');

        //dd($total);

        return view('/RDeliveryCompany',compact('data','total','from_date','to_date'));

        }
        else
        {

            $from_date = "Not Mentioned";
            $to_date = "Not Mentioned"  ;
        
        $data = DB::table('deliver_through_company_vehicles')
        ->join('deliveries','deliveries.id','deliver_through_company_vehicles.delivery_id')
        ->join('whole_sale_buyers','whole_sale_buyers.reg_no','buyer_id')
        ->join('emp_details','emp_details.employee_id','deliver_through_company_vehicles.driver_id')
        ->join('vehicles','vehicles.id','deliver_through_company_vehicles.vehicle_id')
        ->select(['deliveries.id','deliveries.invoice_id','whole_sale_buyers.buyer_name','whole_sale_buyers.address','whole_sale_buyers.mobile','whole_sale_buyers.land','whole_sale_buyers.email','emp_details.name','vehicles.vehi_reg_no','deliveries.date','deliveries.total'])
        ->paginate(5);

        $total = DB::table('deliver_through_company_vehicles')
        ->join('deliveries','deliveries.id','deliver_through_company_vehicles.delivery_id')
        ->select([DB::raw('Sum(deliveries.total) OVER () AS total_cost')])
        ->value('total_cost');

        //dd($total);

        return view('/RDeliveryCompany',compact('data','total','from_date','to_date'));

        }
    }


    //Report of Delivary by Courier View

    public function getDCourierData(Request $request){

        if(!empty($request->from_date))
        {

            $from_date = $request->from_date;
            $to_date = $request->to_date;

        $data = DB::table('deliver_through_courier_services')
        ->join('deliveries','deliveries.id','deliver_through_courier_services.delivery_id')
       ->join('whole_sale_buyers','whole_sale_buyers.reg_no','deliveries.buyer_id')
       ->join('courier_services','courier_services.id','deliver_through_courier_services.courier_id')
       ->select('deliveries.id','deliveries.invoice_id','whole_sale_buyers.buyer_name','whole_sale_buyers.address','whole_sale_buyers.mobile','whole_sale_buyers.land','whole_sale_buyers.email','courier_services.company_name','deliveries.date','deliveries.total')
       ->whereBetween('deliveries.date', array($request->from_date, $request->to_date))
       ->paginate(5);

        $total = DB::table('deliver_through_courier_services')
        ->join('deliveries','deliveries.id','deliver_through_courier_services.delivery_id')
        ->select([DB::raw('Sum(deliveries.total) OVER () AS total_cost')])
        ->whereBetween('deliveries.date', array($request->from_date, $request->to_date))
        ->value('total_cost');

        //dd($total);

        return view('/RDeliveryCourier',compact('data','total','from_date','to_date'));

        }
        else
        {

            $from_date = "Not Mentioned";
            $to_date = "Not Mentioned";
        
        $data = DB::table('deliver_through_courier_services')
        ->join('deliveries','deliveries.id','deliver_through_courier_services.delivery_id')
       ->join('whole_sale_buyers','whole_sale_buyers.reg_no','deliveries.buyer_id')
       ->join('courier_services','courier_services.id','deliver_through_courier_services.courier_id')
       ->select('deliveries.id','deliveries.invoice_id','whole_sale_buyers.buyer_name','whole_sale_buyers.address','whole_sale_buyers.mobile','whole_sale_buyers.land','whole_sale_buyers.email','courier_services.company_name','deliveries.date','deliveries.total')
       ->paginate(5);

        $total = DB::table('deliver_through_courier_services')
        ->join('deliveries','deliveries.id','deliver_through_courier_services.delivery_id')
        ->select([DB::raw('Sum(deliveries.total) OVER () AS total_cost')])
        ->value('total_cost');

        //dd($total);

        return view('/RDeliveryCourier',compact('data','total','from_date','to_date'));

        }
    }

    //Report of Delivaries View

    public function getDData(Request $request){

        if(!empty($request->from_date))
        {

            $from_date = $request->from_date;
            $to_date = $request->to_date;

            $data = DB::table('deliveries')
            ->join('whole_sale_buyers','whole_sale_buyers.reg_no','deliveries.buyer_id')
            ->select(['deliveries.id','deliveries.invoice_id','whole_sale_buyers.buyer_name','whole_sale_buyers.address','whole_sale_buyers.mobile','whole_sale_buyers.land','whole_sale_buyers.email','deliveries.date','deliveries.total'])
            ->whereBetween('deliveries.date', array($request->from_date, $request->to_date))
            ->paginate(5);

            $total = DB::table('deliveries')
            ->select([DB::raw('Sum(deliveries.total) OVER () AS total_cost')])
            ->whereBetween('deliveries.date', array($request->from_date, $request->to_date))
            ->value('total_cost');

        //dd($total);

        return view('/RDelivery',compact('data','total','from_date','to_date'));

        }
        else
        {

            $from_date = "Not Mentioned";
            $to_date = "Not Mentioned";
        
            $data = DB::table('deliveries')
            ->join('whole_sale_buyers','whole_sale_buyers.reg_no','deliveries.buyer_id')
            ->select(['deliveries.id','deliveries.invoice_id','whole_sale_buyers.buyer_name','whole_sale_buyers.address','whole_sale_buyers.mobile','whole_sale_buyers.land','whole_sale_buyers.email','deliveries.date','deliveries.total'])
            ->paginate(5); 

            $total = DB::table('deliveries')
            ->select([DB::raw('Sum(deliveries.total) OVER () AS total_cost')])
            ->value('total_cost');

        //dd($total);

        return view('/RDelivery',compact('data','total','from_date','to_date'));

        }
    }


    //Report of Daily vists View

    public function getVisitsData(Request $request){

        if(!empty($request->from_date))
        {

            $from_date = $request->from_date;
            $to_date = $request->to_date;

            $data = DB::table('daily_visits')
            ->join('emp_details','emp_details.employee_id','driver_id')
            ->join('vehicles','vehicles.id','vehicle_id')
            ->select('daily_visits.id','daily_visits.date','daily_visits.departure','daily_visits.arrival','daily_visits.fuel','daily_visits.purpose','emp_details.name','vehicles.vehi_reg_no')
            ->whereBetween('daily_visits.date', array($request->from_date, $request->to_date))
            ->paginate(5);

            $total = DB::table('daily_visits')
            ->select([DB::raw('Sum(daily_visits.fuel) OVER () AS total_cost')])
            ->whereBetween('daily_visits.date', array($request->from_date, $request->to_date))
            ->value('total_cost');

        //dd($total);

        return view('/RDailyVisits  ',compact('data','total','from_date','to_date'));

        }
        else
        {

            $from_date = "Not Mentioned";
            $to_date = "Not Mentioned";
        
            $data = DB::table('daily_visits')
            ->join('emp_details','emp_details.employee_id','driver_id')
            ->join('vehicles','vehicles.id','vehicle_id')
            ->select('daily_visits.id','daily_visits.date','daily_visits.departure','daily_visits.arrival','daily_visits.fuel','daily_visits.purpose','emp_details.name','vehicles.vehi_reg_no')
            ->paginate(5);

            $total = DB::table('daily_visits')
            ->select([DB::raw('Sum(daily_visits.fuel) OVER () AS total_cost')])
            ->value('total_cost');

        //dd($total);

        return view('/RDailyVisits',compact('data','total','from_date','to_date'));

        }
    }
    
}
