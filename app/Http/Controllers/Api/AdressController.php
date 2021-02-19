<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Model\Address;

class AdressController extends RestAPI
{
    //
    // public function index()
    // {         
    //     return Address::query()->whereIn('Type_EN', ['Province', 'Capital'])->get();

    //     // User::query()
    //     //     ->where('name', 'LIKE', "%{$searchTerm}%") 
    //     //     ->orWhere('email', 'LIKE', "%{$searchTerm}%") 
    //     //     ->get();

    // }

    public function getTableSetting(){
        return [
            "tablename" => "cambodia_address",
            "model" => "App\Model\Address"
        ];
    }

    public function getQuery(){
        return Address::query();
    }

    public function getModel(){
        return new Address();
    }

    public function getProvince(Request $request){
        return Address::query()->whereIn('Type_EN', ['Province', 'Capital'])->get();
    }
    public function getKhan(Request $request){
        return Address::query()->whereIn('Type_EN', ['District', 'Khan','Municipality'])
        ->where('Code', 'LIKE', "%{$request['Code']}%")->get();
    }
    public function getSangkat(Request $request){
        return Address::query()->whereIn('Type_EN', ['Commune', 'Sangkat'])
        ->where('Code', 'LIKE', "%{$request['Code']}%")->get();
    }
    public function getVillage(Request $request){
        return Address::query()->whereIn('Type_EN', 'Village')
        ->where('Code', 'LIKE', "%{$request['Code']}%")->get();
    }

    
    
}
