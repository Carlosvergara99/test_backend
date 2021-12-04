<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use App\city;
use App\department;
use App\User;

class LotteryController extends Controller
{
 
   public function register (Request $request )
   {

    $validatedData = $request->validate([
        'email' => 'email|unique:users',
        'phone' => 'unique:users',
        'cc'    =>'unique:users'
    ],
    [
        'email.email' => 'el campo :attribute debe ser formato email .',
        'email.unique' => 'el :attribute  ya exsite .',
        'phone.unique' => 'el telefono ya exsite .',
        'cc.unique' => 'el cedula ya exsite .'

    ]);
       $department = department::where('name',$request->department)->first();

       if ( !isset($department)) {
        $new_department = new department();
        $new_department->name =$request->department;
        $new_department->save();
        $department = $new_department;
       }


       $city = city::where('department_id', $department->id)->where('name',$request->city)->first();
       if (!isset($city)) {
        $new_city =  city::create(['name' => $request->city,'department_id'=>  $department->id]); 
        $city = $new_city;
       }

        User::create([
            'name' => $request->name,
            'last_name'=> $request->last_name,
            'cc' =>$request->cc,
            'phone'=>$request->phone,
            'email' => $request->email,
            'city_id'=>  $city->id
       ]);
   }
   public function sorting()
   {
     $users = User::select(['name','last_name','cc'])->get()->toArray();
       if ( count($users) >= 5) {
        return response()->json($users[array_rand($users)]);
       }
       return response()->json([
        'message' => 'Error data'
       ], 404);

   }
   public function export() 
   {
      
     return Excel::download(new UsersExport, 'users.xlsx');
   }
}
