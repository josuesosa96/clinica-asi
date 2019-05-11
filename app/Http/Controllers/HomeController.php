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
        'name.required' => 'El campo "nombre" es obligatorio',
        'age.required' => 'El campo "edad" es obligatorio',
        'general_doctor_id.required' => 'El campo "doctor general" es obligatorio',
        'symptoms.required' => 'El campo "sintomas" es obligatorio'
      ];

      $input = $request->json()->all();

      $validated = Validator::make($input, ['name' => 'required', 'age' => 'required', 'general_doctor_id' => 'required', 'symptoms' => 'required'], $messages)->validate();

      $file = new File;

      $file->number = $this->getMaxNumber();
      $file->name = $input['name'];
      $file->age = $input['age'];
      $file->address = $input['address'];
      $file->phone_number = $input['phone_number'];
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
