<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ResponseHandler;

class TriggerHandler extends ResponseHandler
{
    public function beforeCreate(&$lstNewRecords){

    }
    public function beforeUpdate(&$lstNewRecords, $mapOldRecords=[]){

    }
    public function beforeDelete(&$lstNewRecords){

    }

    public function afterCreate(&$lstNewRecords){

    }
    public function afterUpdate(&$lstNewRecords){

    }
    public function afterDelete($lstOldRecords){

    }
}
