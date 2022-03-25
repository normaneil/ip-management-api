<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Hash;

class AuthController extends Controller
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
   
        if($validator->fails()){
            // return $this->sendError('Validation Error.', $validator->errors()); 
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Validation Error',
            ], 422);      
        }

        $user = User::where(['email' => $request->email])->first();
        if($user)
        {
            return response()->json([
                'success' => FALSE,
                'message' => 'Duplicate entry found.',
            ], 422);
        }
   
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->name;
   
        return response()->json([
            'success' => true,
            'data'    => $success,
            'message' => 'User register successfully',
        ], 200);
    }
   
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')-> accessToken; 
            $success['name'] =  $user->name;
   
            
            return response()->json([
                'success' => true,
                'data'    => $success,
                'message' => 'User login successfully.',
            ], 200);
        } 
        else{ 
            
            return response()->json([
                'success' => false,
                'message' => 'Unauthorised',
            ], 200);
        } 
    }

    public function user(Request $request) {
        return $request->user();
    }
}
