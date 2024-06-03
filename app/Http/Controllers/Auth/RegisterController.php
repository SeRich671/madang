<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
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
            'login' => ['required', 'string', 'max:255', 'unique:users'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'company_name' => ['required', 'string', 'max:255'],
            'nip' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'company_address' => ['required', 'string', 'max:255'],
            'company_city' => ['required', 'string', 'max:255'],
            'company_zipcode' => ['required', 'string', 'max:255'],
            'company_fax' => ['nullable', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'marketing' => ['sometimes', 'nullable'],
            'address' => ['required', 'array'],
            'address.first_name' => ['required', 'string', 'max:255'],
            'address.last_name' => ['required', 'string', 'max:255'],
            'address.company_name' => ['nullable', 'string', 'max:255'],
            'address.address' => ['required', 'string', 'max:255'],
            'address.city' => ['required', 'string', 'max:255'],
            'address.zipcode' => ['required', 'string', 'max:255'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        DB::beginTransaction();

        $user = User::create([
            'login' => $data['login'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'company_name' => $data['last_name'],
            'nip' => $data['nip'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'company_address' => $data['company_address'],
            'company_city' => $data['company_city'],
            'company_zipcode' => $data['company_zipcode'],
            'company_fax' => $data['company_fax'] ?? null,
            'marketing' => isset($data['marketing']) && $data['marketing'] === 'true',
            'password' => Hash::make($data['password']),
        ]);

        $user->addresses()->create([
            'first_name' => $data['address']['first_name'],
            'last_name' => $data['address']['last_name'],
            'company_name' => $data['address']['company_name'],
            'street' => $data['address']['address'],
            'city' => $data['address']['city'],
            'zip_code' => $data['address']['zipcode'],
            'phone' => $data['phone'],
            'email' => $data['email'],
        ]);

        $user->billings()->create([
            'first_name' => $data['address']['first_name'],
            'last_name' => $data['address']['last_name'],
            'company_name' => $data['address']['company_name'],
            'address' => $data['address']['address'],
            'city' => $data['address']['city'],
            'zipcode' => $data['address']['zipcode'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'nip' => $data['nip']
        ]);

        DB::commit();

        return $user;
    }
}
