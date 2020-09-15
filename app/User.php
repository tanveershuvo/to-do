<?php
namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
use Notifiable;

// Rest omitted for brevity

    protected $fillable = ['name','email','password'];

    protected $hidden = ['password','remember_token'];
    /**
    * Get the identifier that will be stored in the subject claim of the JwtMiddleware.
    *
    * @return mixed
    */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
    * Return a key value array, containing any custom claims to be added to the JwtMiddleware.
    *
    * @return array
    */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function todos(){
        return $this->hasMany(Todo::class);
    }

    public function setPasswordAttribute($value){
        $this->attributes['password'] = bcrypt($value);
    }
}
