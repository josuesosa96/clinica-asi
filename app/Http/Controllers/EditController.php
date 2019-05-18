<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\File;
use Validator;

class EditController extends Controller
{
  public function editFile(Request $request)
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

    $File = File::find($input['id']);
    // dd($input);

    $File->names = $input['names'];
    $File->first_lastname = $input['first_lastname'];
    $File->second_lastname = $input['second_lastname'];
    $File->birthdate = $input['birthdate'];
    $File->age = $input['age'];
    $File->sex = $input['sex'];
    $File->dui = $input['dui'];
    $File->nit = $input['nit'];
    $File->phone_number = $input['phone_number'];
    $File->responsible_name = $input['responsible_name'];
    $File->responsible_phone_number = $input['responsible_phone_number'];
    $File->address = $input['address'];
    $File->appointment_date = $input['appointment_date'];
    $File->general_doctor_id = $input['general_doctor_id'];
    $File->specialist_doctor_id = $input['specialist_doctor_id'] == '' ? null : $input['specialist_doctor_id'];
    $File->allergies = $input['allergies'];
    $File->symptoms = $input['symptoms'];
    $File->diagnosis = $input['diagnosis'];
    $File->treatment = $input['treatment'];
    $File->todo_tests = $input['todo_tests'];
    $File->done_tests = $input['done_tests'];
    $File->results = $input['results'];

    $File->save();

    $File = File::find($input['id']);

    return json_encode($File->number);
  }
}
