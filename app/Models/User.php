<?php
  
namespace App\Models;
  
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;
use PragmaRX\Google2FA\Google2FA;
use ParagonIE\ConstantTime\Base32;
  
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    //protected $table = "user";

  
    /**
     * The attributes that are mass assignable.
     *
     * @var array

     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'aktif'
    ];
  
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array

     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
  
    /**
     * The attributes that should be cast.
     *
     * @var array

     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
 
    /**
     * Interact with the user's first name.
     *
     * @param  string  $value
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    // protected function type(): Attribute
    // {
    //     return new Attribute(
    //         get: fn ($value) =>  ["users", "admin"][$value],
    //     );
    // }

    public function generateOtpSecret()
    {
        $google2fa = new Google2FA();
        $rawSecret = $google2fa->generateSecretKey(16);
        
        $this->google2fa_secret = Base32::encodeUpper($rawSecret);
        $this->save();
    }

}