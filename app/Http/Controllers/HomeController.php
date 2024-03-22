<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Point;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        
        $existing_refferal_code = User::where('id', Auth::user()->id)
                              ->select('refferal_code')
                              ->first();
        
        if($existing_refferal_code->refferal_code == null)
        {
            $reff_code = Str::random(15);

            User::where('id', Auth::user()->id)
                  ->update([
                              'refferal_code' => $reff_code
                          ]);
        }
        else
        {
           $reff_code = $existing_refferal_code->refferal_code;
        }
        
        //fetch points

        $points = Point::where('user_id', Auth::user()->id)->select('current_point')->get();
        
        
        return view('home', compact('reff_code','points'));
    }
}
