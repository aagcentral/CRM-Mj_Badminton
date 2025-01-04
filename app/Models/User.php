<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Builder;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'locationID',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function Userlocations()
    {
        return $this->belongsTo(Location::class, 'locationID', 'location_id');
    }


    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    static function getRecord()
    {
        return User::select('users.*', 'roles.name as role_name')
            ->join('roles', 'roles.id', '=', 'users.role_id')
            ->orderBy('users.id', 'desc')->get();
    }



    static function getSingle($id)
    {
        return User::find($id);
    }
}
