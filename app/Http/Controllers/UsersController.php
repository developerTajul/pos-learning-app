<?php
namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Helper\JWTHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::all();
        return response()->json([
            'status' => 'success',
            'message' => 'All users retrieved successfully.',
            'data' => $user
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.registration-page');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $user = new User();
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = $request->password;
            $user->save();
    
            return response()->json([
                'status'    => 'success',
                'message'   => 'User created successfully.',
                'data'      => $user
            ] );
        }catch( Exception $e ){
            return response()->json([
                'status'    => 'failed',
                'message'   => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = DB::table('users')->where('id', $id)->first();
        return response()->json([
            'status'    => 'success',
            'message'   => 'User retrieved successfully.',
            'data'      => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {

        return view('auth.edit-user');

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $user = DB::table('users')->where('id', $id)->update($request->input());

        if (!$user) {
            return response()->json([
                'status'  => 'error',
                'message' => 'User not found.'
            ], 404);
        }

        
        return response()->json([
            'status'    => 'success',
            'message'   => 'User updated successfully.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            
            $user = DB::table('users')->where('id', '=', $id)->delete();

            if (!$user) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'User not found.'
                ], 404);
            }

            return response()->json([
                'status'    => 'success',
                'message'   => 'User deleted successfully.'
            ]);

        }catch( Exception $e ){

            return response()->json([
                'status'    => 'failed',
                'message'   => $e->getMessage()
            ]);

        }

    }

    // login page
    public function loginPage(){
        return view('auth.login-page');
    }

    // login
    public function login(Request $request){
        $email = $request->input( 'email' );
        $password = $request->input( 'password' );

        $user = User::where( 'email', $email )->first();

        if( $user && Hash::check( $password, $user->password ) ){

            $token = JWTHelper::createToken($user->id, $user->email);

            return response()->json([
                'status'    => 'success',
                'message'   => 'User logged in successfully.',
                'data'      => $token
            ], 200)->cookie('token', $token, 60);
        }
        return response()->json([
            'status'    => 'failed',
            'message'   => 'User logged failed.'
        ], 401);

    }   


    public function userLogout(Request $request){
        return redirect('/login')->cookie('token', '', -1);
    }


    public function forgetPasswordPage(){
        return view('auth.send-otp-page');
    }
    // send otp code
    public function forgetPassword( Request $request ){
        $email = $request->input('email');

        $user = User::where('email', $email)->first();

        $opt = rand(9999, 1000);


        if( $user ){

            // send otp
            $user->otp = $opt;
            $user->save();

            // send email

            return response()->json([
                'status'    => 'success',
                'message'   => 'OTP sent successfully.',
                'otp'       => $opt
            ]);
        }

        if( !$user ){
            return response()->json([
                'status'    => 'failed',
                'message'   => 'User not found.'
            ]);
        }

    }

    public function verifyOtpPage(){
        return view('auth.verify-otp-page');
    }

    public function verifyOtp( Request $request ){
        $email = $request->input('email');
        $otp = $request->input('otp');

        $user = User::where('email', $email)->first();
        if( $user && $user->otp == $otp ){
            // otp update
            $user->otp = '0';
            $user->save();

            $token = JWTHelper::resetPasswordCreateToken($user->id, $user->email);

            return response()->json([
                'status'    => 'success',
                'message'   => 'OTP verified successfully.',
                'token'     => $token
            ])->cookie('token', $token);
        }

        return response()->json([
            'status'    => 'failed',
            'message'   => 'OTP verification failed.'   
        ]);
    }    



    public function resetPasswordPage(){
        return view('auth.reset-pass-page');
    }


    // reset password
    public function resetPassword( Request $request ){


        $email = $request->header('user_email');
        $password = $request->input('password');    

        $user = User::where('email', $email)->first();

        

        try{
            if( $user ){
                $user->password = $password;
                $user->save();

                return response()->json([
                    'status'    => 'success',
                    'message'   => 'Password reset successfully.'   
                ]);
            }
        }catch( Exception $e ){
            return response()->json([
                'status'    => 'failed',
                'message'   => $e->getMessage() 
            ]);
        }

    }


    public function userProfile(Request $request){

        $email = $request->header('user_email');
        $user = User::where('email', $email)->first();
        return response()->json([
            'status'    => 'success',
            'message'   => 'User retrieved successfully.',
            'data'      => $user
        ]);
    }


    public function profileUpdate(Request $request){
        $email = $request->header('user_email');
        $user = User::where('email', $email)->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'password' => $request->input('password'),
        ]);

        return response()->json([
            'status'    => 'success',
            'message'   => 'User updated successfully.', 
            'data'      => $user
        ]);
  
    }




}
