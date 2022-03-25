<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreIpRequest;
use App\Http\Resources\IpResource;
use App\Models\IpAddress;
use App\Models\IpAddressHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Validator;

class IpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // GET
    // http://localhost:8000/api/ip-address
    public function index()
    {
        $result = IpAddress::all();
        return IpResource::collection($result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // POST
    // http://localhost:8000/api/ip-address
    public function store(Request $request)
    {
        $user = Auth::user();

        $input = $request->all();
     
        $validator = Validator::make($input, [
            'ip_add' => 'required',
            'label' => 'required'
        ]);
     
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Validation Error',
            ], 422);      
        }

        if(!filter_var($request->ip_add, FILTER_VALIDATE_IP)){
            return response()->json([
                'success' => FALSE,
                'message' => 'Not Valid IP',
            ], 422);
        }

        $record = IpAddress::where(['ip_add' => $request->ip_add])->first();
        if($record)
        {
            return response()->json([
                'success' => FALSE,
                'message' => 'Duplicate entry found.',
            ], 422);
        }
     
        $ip_add = IpAddress::create($input);


        IpAddressHistory::create([
            'history' => 'Added new ip address',
            'ip_address_id' => $ip_add->id,
            'user_id' => $user->id
        ]);

        return response()->json([
            'success' => true,
            'data' => new IpResource($ip_add),
            'message' => 'Added successfully',
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\IpAddress  $ipAddress
     * @return \Illuminate\Http\Response
     */
    // GET
    // http://localhost:8000/api/ip-address/1
    public function show($id)
    {
        $ip_add = IpAddress::find($id);
        // print_r($ip_add->histories);exit;
    
        if (is_null($ip_add)) {
            return response()->json([
                'success' => FALSE,
                'message' => 'Not found.',
            ], 404);
        }

        $user = Auth::user();
        IpAddressHistory::create([
            'history' => 'Viewed record',
            'ip_address_id' => $ip_add->id,
            'user_id' => $user->id
        ]);
        
        return response()->json([
            'success' => true,
            'data' => new IpResource($ip_add),
            'message' => 'Retrieved successfully',
        ], 200);
    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\IpAddress  $ipAddress
     * @return \Illuminate\Http\Response
     */
    // PUT
    // http://localhost:8000/api/ip-address/1?label=This is a test
    public function update(Request $request, IpAddress $ipAddress)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'label' => 'required'
        ]);
     
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Validation Error',
            ], 422); 
        }

        $old_label = $ipAddress->label;
        $new_label = $input['label'];

        $ipAddress->label = $input['label'];
        $ipAddress->save();

        $user = Auth::user();
        IpAddressHistory::create([
            'history' => "Changed label from {$old_label} to {$new_label}",
            'ip_address_id' => $ipAddress->id,
            'user_id' => $user->id
        ]);

        return response()->json([
            'success' => true,
            'data' => new IpResource($ipAddress),
            'message' => 'Updated successfully',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\IpAddress  $ipAddress
     * @return \Illuminate\Http\Response
     */
    public function destroy(IpAddress $ipAddress)
    {
        return response()->json([
            'success' => true,
            'message' => 'Not Allowed',
        ], 200);
    }
}
