<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewChannel;

// use Spatie\Permission\Traits\HasRoles;
use App\Models\User;

class Channel extends User
{
    use CrudTrait;
    use HasFactory;
    // use HasRoles;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'channels';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['name', 'email', 'desc', 'profile_image', 'cover_image', 'recipient_units', 'recipient_programmes'];
    // protected $hidden = [];
    
    protected $casts = [
        'recipient_units' => 'json',
        'recipient_programmes' => 'json',
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($channel) {
            
            // dd($_REQUEST['password']);
            Mail::to($channel->email)->send(new NewChannel($_REQUEST));

            //creating channel account and Store the hash of the temporary password in the database
            $user = new User([
                'name' => $channel->name,
                'email' => $channel->email,
                'password' => Hash::make($_REQUEST['password'])
            ]);

            // $user->password = Hash::make(request()->input('password'));
            $user->save();

            // Assign a default role to the user
            // $user->assignRole('PROFILE');
        });
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
