<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;


class UsersExport implements FromArray,WithHeadings
{

    /**
    * @return \Illuminate\Support\Collection
    */
    public function array(): array
    {
        $user = User::with(['city','city.department'])->get()->toArray();
        $data =[];
        foreach ($user as $key => $value) {
           array_push($data,[
             'nombre' => $value['name'],
             'apellido' =>$value['last_name'],
             'cedula'=>$value['cc'],
             'celular' => $value['phone'],
             'email'=> $value['email'],
             'departamento'=>$value['city']['department']['name'],
             'Ciudad' =>$value['city']['name'],
             'fecha' => date('d-m-y H:m', strtotime($value['created_at']))

         ]);
        }
        
       return  $data;
    }

    public function headings(): array
    {
        return [
            'Nombres',
            'Apellido',
            'No Cedula',
            'No Celular',
            'Email',
            'Departamento',
            'Ciudad',
            'Fecha de creacion'
        ];
    }
   
}
