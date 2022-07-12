<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\carbon;
use App\Models\Client;
use App\Models\Codes;

use function PHPSTORM_META\map;

class ClientsController extends Controller
{
    public function index()
    {
        $clients = DB::table('clients')->get();
        return response($clients);
    }

    public function store(Request $request)
    {
        $client = new Client();
        $date = Carbon::now();
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $allowedfileExtention = ['png','jpg'];
            $extention = $file->getClientOriginalExtension();
            $check = in_array($extention,$allowedfileExtention);
            if ($check) {
                $fileName = time().$file->getClientOriginalName();
                $data = array(
                    'name' => $request->input('name'),
                    'address' => $request->input('address'),
                    'jobs' => $request->input('jobs'),
                    'email' => $request->input('email'),
                    'password' => Hash::make($request->input('password')),
                    'gender' => $request->input('gender'),
                    'age' => $request->input('age'),
                    'no_telp' => $request->input('no_telp'),
                    'parents_name' => $request->input('parents_name'),
                    'parents_no_telp' => $request->input('parents_no_telp'),
                    'photo' => $fileName,
                    'created_at' => $date,
                    'updated_at' => $date
                 );
                 $this->createCodes($request->input('email'));
                 $store = $client->create($data);
                 return response()->json($store);
            }else {
                return response()->json([
                    'code' => 500,
                    'messages' => 'format foto tidak bisa di proses'
                ]);
            }
        }else{
            return response()->json([
                'code' => 400,
                'messages' => 'no foto'
            ]);
        }
    }
    public function createCodes($email)
    {
        $digits = 5;
        $randomString = '';
        $date = Carbon::now();
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        for($i = 0; $i< $digits;$i++){
            $index = rand(00,strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
        $data = array(
            'code_activate' => $randomString,
            'user_email' => $email,
            'expired' => $date,
            'created_at' => $date,
            'updated_at' => $date
        );
        DB::table('codes')->insert($data);
    }
    public function activatedAccount(Request $request)
    {
        try{
            $otp = Codes::where('code_activate',$request->input('otp'))->first();
            $clients = Client::where('email',$otp->user_email)->first();
            if ($request->input('otp') == $otp->code_activate && $clients->status == 'active') {
                return response()->json([
                    'code' => 200,
                    'messages' =>'your account has been active',
                    'data' =>$clients
                ]);
            }else{
                Client::where('email',$otp->user_email)->update(['status'=>'active']);
            }
            return response()->json($clients);
        }catch(\Exception $e){
            return response()->json([
                'code' => 404,
                'message' => $e->getCode()
            ],404);
        }
    }
    public function login(Request $request)
    {
        try {
            $clientsData = Client::where('email',$request->input('email'))->first();
            if (Hash::check($request->input('password'), $clientsData->password)) {
                if ($clientsData->status == 'not_active') {
                    return response()->json([
                        'code' => 200,
                        'email' => $clientsData->email,
                        'status' => $clientsData->status,
                        'message' => 'your account not active'
                    ]);
                }
                return response()->json([
                    'code' => 200,
                    'email' => $clientsData->email,
                    'status' => $clientsData->status,
                    'message' => 'your account is active'
                ]);
        }
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => $e->getCode()
            ],500);
        }
    }

    public function show($id)
    {
        $client = new Client();
        try {
            $data = $client->where('id',$id)->first();
            return response()->json($data);

        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'messages' => 'bad request'.$e->getCode()
            ],500);
        }        
    }

    public function update(Request $request, $id)
    {
        
    }
}
