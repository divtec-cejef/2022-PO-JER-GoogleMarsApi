<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 *
 */
class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable, HasFactory;


    /**
     * @var string
     */
    protected $table = 'users';
    /**
     * @var string
     */
    protected $primaryKey = 'id';
    /**
     * @var string[]
     */
    protected $fillable = [
        'password',
        'website',
        'is_admin'
    ];
    /**
     * @var string[]
     */
    protected $hidden = [
        'password',
        'updated_at',
        'ip_adress'
    ];

    /**
     * @return string[]
     */
    static function validateRules(): array
    {
        return [
            'first_name' => 'required|string|max:20',
            'last_name' => 'required|string|max:20',
            'username' => 'required|string|max:20|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'password_confirmation' => 'required|same:password',
            'is_admin' => 'boolean',
            'website' => 'string',
            'ip_adress' => 'integer',
        ];
    }

    /**
     * @return string[]
     */
    public static function emailSendValidation()
    {
        return [
            'email' => 'required|email',
        ];
    }

    /**
     * @return string[]
     */
    public static function emailResetValidation()
    {
        return [
            'resetToken' => 'required',
            'email' => 'required|email',
            'password' => 'required',];
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function badge()
    {
        return $this->belongsToMany(Badge::class, 'recevoir');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function base()
    {
        return $this->hasOne(Base::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function responsable()
    {
        return $this->belongsToMany(Badge::class, 'responsable');
    }

}
