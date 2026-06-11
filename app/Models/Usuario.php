<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\CustomResetPasswordNotification;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'USUARIO';

    protected $primaryKey = 'rut';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'rut',
        'nombre',
        'email',
        'contrasena',
        'rol',
        'remember_token'
    ];

    protected $hidden = [
        'contrasena',
        'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->contrasena;
    }

    public function getEmailForPasswordReset()
    {
        return $this->email;
    }

    public function retiros()
    {
        return $this->hasMany(Retiro::class, 'id_usuario', 'rut');
    }
    
    public function sendPasswordResetNotification($token)
    {
        $this->notify(
            new CustomResetPasswordNotification($token)
        );
    }
}