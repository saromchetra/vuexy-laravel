<?php

namespace App\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends BaseModel
{
    protected $table = 'users';
    protected $keyType = 'string';
    protected $duplicateField =['username'];
    public $incrementing = false;
    protected $with = ['user_role'];
    protected $withCount = [];
    public $timestamps = true;
    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';
    protected $fillable = [
        "id",
        "avatar",
        "fullname",
        "email",
		"username",
		"language",
        "password",
		"api_token",
		"users_id",
		"api_token",
        "is_active",
        "User_Role_Id",
        "deleted",
        "created_date",
        "updated_date",
        "updated_by",
        "created_by",
    ];

	
// 	protected $hidden = [
//         'password'
// 	];

	public function user_role(){
        return $this->hasOne('App\Model\UserRole', 'id', 'User_Role_Id');
    }

    public function getCreatedByNameAttribute()
    {
        return User::where('id', $this->created_by)->pluck('name')->first();
    }

    public function created_by_obj(){
        return $this->hasOne('App\Model\User', 'id', 'created_by');
    }
    public function updated_by_obj(){
        return $this->hasOne('App\Model\User', 'id', 'updated_by');
    }
	//to set value or convert value for create/update
    public function setPasswordAttribute($value){
        
        //if user not mach, it mean new password ($value) is not encrypt yet
        if($this->attributes == null || !isset($this->attributes['password']) || $this->attributes['password'] != $value){
            $this->attributes['password'] = md5($value);
        }
    }
}
