<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\File;
use Validator;

class SecretaryEditController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function index()
  {
    $Files = File::all();
    return view('secretary-edit')->with('files', $Files);
  }

  public function editFile(Request $request)
  {
    $messages = [
      'first_name.required' => 'El campo "Primer nombre" es obligatorio',
      'first_lastname.required' => 'El campo "Primer apellido" es obligatorio',
      'birthdate.required' => 'El campo "Primer apellido" es obligatorio',
      'age.required' => 'El campo "Edad" es obligatorio',
      'sex.required' => 'El campo "Sexo" es obligatorio',
      'address.required' => 'El campo "Dirección" es obligatorio',
      'city.required' => 'El campo "Ciudad" es obligatorio',
      'state.required' => 'El campo "Departamento" es obligatorio',
      'general_doctor_id.required' => 'El campo "Doctor general" es obligatorio',
      'dui.required' => 'El campo "DUI" es obligatorio'
    ];

    $input = $request->json()->all();

    $validated = Validator::make($input,
      [
        'first_name' => 'required',
        'first_lastname' => 'required',
        'birthdate' => 'required',
        'age' => 'required',
        'sex' => 'required',
        'address' => 'required',
        'city' => 'required',
        'state' => 'required',
        'general_doctor_id' => 'required',
        'dui' =>  'required'
      ],
      $messages
    )->validate();

    $File = File::find($input['id']);

    $File->first_name = $input['first_name'];
    $File->second_name = $input['second_name'] == '' ? null : $input['second_name'];
    $File->first_lastname = $input['first_lastname'];
    $File->second_lastname = $input['second_lastname'] == '' ? null : $input['second_lastname'];
    $File->birthdate = $input['birthdate'];
    $File->age = $input['age'];
    $File->sex = $input['sex'];
    $File->dui = $input['dui'];
    $File->nit = $input['nit'];
    $File->phone_number = $input['phone_number'];
    $File->second_phone_number = $input['second_phone_number'] == '' ? null : $input['second_phone_number'];
    $File->responsible_name = $input['responsible_name'];
    $File->responsible_phone_number = $input['responsible_phone_number'];
    $File->address = $input['address'];
    $File->city = $input['city'];
    $File->state = $input['state'];
    $File->general_doctor_id = $input['general_doctor_id'];
    $File->specialist_doctor_id = $input['specialist_doctor_id'] == '' ? null : $input['specialist_doctor_id'];
    $File->allergies = $input['allergies'];

    $File->save();

    $File = File::find($input['id']);

    return json_encode($File->number);
  }
}
