<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Mail;
use Validator;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
     */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    // protected $redirectTo = '/home';
    protected $redirectTo          = "/register-success-email";
    protected $redirectAfterLogout = '/';
    protected $redirectToLogin = "/user/mybooks";
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'     => 'required|max:255',
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * 1. Create a new user instance after a valid registration.
     * 2. Send email to the End user for registration email
     * 3. Return the created user to the calling function
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        # create new user
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => bcrypt($data['password']),
            'registration_token'=>str_random(40)
        ]);
        # create the activation url
        $user->activation_url = route('register-success',["token"=>$user->id."|".$user->registration_token]);
        # send an email with activation url
        $this->sendEmail($user);
        return $user;
    }

    private function sendEmail($user)
    {   
        Mail::send("auth.emails.register-success", ["user"=>$user], function ($message) use($user){
            $message->from("admin@bookbarterclub.com", "Book Barter Club");
            $message->sender("admin@bookbarterclub.com", "Book Barter Club");
            $message->to($user->email, $user->name);
            $message->replyTo("admin@bookbarterclub.com", "Book Barter Club");
            $message->subject("Book Barter Club : Account Activation");
            $message->getSwiftMessage();
        });
    }
}
