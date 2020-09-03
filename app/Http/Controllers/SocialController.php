<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\DB;
use Validator,Redirect,Response,File;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    //

    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
    public function callback($provider)
    {
        $getInfo = Socialite::driver($provider)->user();
        $user = $this->createUser($getInfo,$provider);
        auth()->login($user);
        return redirect()->to('/patient/profile-settings');
    }
    function createUser($getInfo,$provider){
        $user = User::where('provider_id', $getInfo->id)->first();
        list($firstname, $lastname) = explode(' ', $getInfo->name,2);
        $slug = filter_var($firstname, FILTER_SANITIZE_STRING) . '-' .
            filter_var($lastname, FILTER_SANITIZE_STRING);
        if (!$user) {
            $user = User::create([
                'first_name'     => $firstname,
                'last_name'     => $lastname,
                'slug'         => $slug,
                'password'         => password_hash('',PASSWORD_DEFAULT),
                'email'    => $getInfo->email,
                'provider' => $provider,
                'provider_id' => $getInfo->id
            ]);
            $role = DB::table('roles')->select('name')->where('role_type', 'patient')->first();
            $user->assignRole($role->name);
        }
        return $user;
    }
}
