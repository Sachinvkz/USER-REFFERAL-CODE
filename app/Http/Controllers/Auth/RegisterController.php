<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\RefferalInfo;
use App\Models\Point;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $reffered_user_count = 0;
        $point = 10;

        if($data['refferal_code'])
        {
            //check refferal code exists
            $check_refferal = User::where('refferal_code', $data['refferal_code'])
                                    ->select('id','name')->first();
            
            if($check_refferal)
            {
                  $newuser = new User;
                  $newuser->name = $data['name'];
                  $newuser->email = $data['email'];
                  $newuser->password = $data['password'];
                  $newuser->save();
                   
                  $created_user = $newuser->id;

                  $refferal_info = new RefferalInfo;
                  $refferal_info->reg_user_id = $created_user;
                  $refferal_info->refferal_codes = $data['refferal_code'];
                  $refferal_info->refferal_by = $check_refferal->id;
                  $refferal_info->save();

                  $reffered_user_count = RefferalInfo::where('refferal_by', $check_refferal->id)
                                                       ->count();
                  $current_point = 0;

                  if($reffered_user_count > 0)
                  {
                    $current_point = $point - $reffered_user_count;
                  }
                  else
                  {
                     $current_point = 0;
                  }
                    
                   
                   $point_data = new Point;
                   $point_data->user_id = $check_refferal->id;
                   $point_data->current_point = $current_point;
                   $point_data->save();


            }
            else
            {
                return User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                    'refferal_code' => $data['refferal_code'],
                ]);
    

            }

            


            
        }
        else
        {
            return User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'refferal_code' => '',
            ]);

        }
        
    }
}
