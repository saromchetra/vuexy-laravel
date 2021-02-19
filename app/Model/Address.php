<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Address extends BaseModel
{
    protected $table = 'cambodia_address';
    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';
    protected $fillable = [
        "id",
        "name",
        "Code",
        "Postal_Code",
        "Name_KH",
        "Type_EN"
    ];  //
}
