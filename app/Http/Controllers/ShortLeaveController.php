<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShortLeaveController extends Controller
{
    public function ShortLeaveForm(){
    
        return view('shortLeaveForm');
    }
}
