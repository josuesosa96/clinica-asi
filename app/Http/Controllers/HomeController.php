<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use App\User;
use App\File;
use Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      $this->middleware('auth');
    }

    public function getMaxNumber()
    {
      return $maxNumber = DB::table('files')->max('number') + 1;
    }

    public function getFile(Request $request)
    {
      $input = $request->json()->all();

      $File = File::where('number', $input['number'])->get();

      return $File;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function create(Request $request)
    {
      $messages = [
        'names.required' => 'El campo "Nombres" es obligatorio',
        'first_lastname.required' => 'El campo "Primer apellido" es obligatorio',
        'second_lastname.required' => 'El campo "Segundo apellido" es obligatorio',
        'birthdate.required' => 'El campo "Primer apellido" es obligatorio',
        'age.required' => 'El campo "Edad" es obligatorio',
        'sex.required' => 'El campo "Sexo" es obligatorio',
        'address.required' => 'El campo "Dirección" es obligatorio',
        'general_doctor_id.required' => 'El campo "Doctor general" es obligatorio',
        'symptoms.required' => 'El campo "sintomas" es obligatorio'
      ];

      $input = $request->json()->all();

      $validated = Validator::make($input, ['names' => 'required', 'first_lastname' => 'required', 'second_lastname' => 'required', 'birthdate' => 'required', 'age' => 'required', 'sex' => 'required', 'address' => 'required', 'general_doctor_id' => 'required', 'symptoms' => 'required'], $messages)->validate();

      $file = new File;

      $file->number = $this->getMaxNumber();
      $file->names = $input['names'];
      $file->first_lastname = $input['first_lastname'];
      $file->second_lastname = $input['second_lastname'];
      $file->birthdate = $input['birthdate'];
      $file->age = $input['age'];
      $file->sex = $input['sex'];
      $file->dui = $input['dui'];
      $file->nit = $input['nit'];
      $file->phone_number = $input['phone_number'];
      $file->responsible_name = $input['responsible_name'];
      $file->responsible_phone_number = $input['responsible_phone_number'];
      $file->address = $input['address'];
      $file->general_doctor_id = $input['general_doctor_id'];
      $file->specialist_doctor_id = $input['specialist_doctor_id'] == '' ? null : $input['specialist_doctor_id'];
      $file->allergies = $input['allergies'];
      $file->symptoms = $input['symptoms'];


      $file->save();

      $test = DB::table('files')->orderBy('number', 'desc')->first();

      return json_encode($test->number);
    }

    public function addPermissions($userId)
    {
      $user = User::findOrFail($userId);
      $user->assignRole('super-admin');
    }

    public function getUserRoles($userId)
    {
      $user = User::findOrFail($userId);
      echo($user->getRoleNames());
    }
}
