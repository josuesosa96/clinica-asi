<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\File;
use Validator;

class DoctorEditController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function index()
  {
    $Files = File::all();
    return view('doctor-edit')->with('files', $Files);
  }

  public function editFile(Request $request)
  {
    $messages = [
      'symptoms.required' => 'El campo "Sintomas" es obligatorio',
      'diagnosis.required' => 'El campo "Diagnostico" es obligatorio',
      'treatment.required' => 'El campo "Treatment" es obligatorio',
      'todo_tests.required' => 'El campo "Exámenes por realizar" es obligatorio'
    ];

    $input = $request->json()->all();

    $validated = Validator::make($input,
      [
        'symptoms' => 'required',
        'diagnosis' => 'required',
        'treatment' => 'required',
        'todo_tests' => 'required'
      ],
      $messages
    )->validate();

    $File = File::find($input['id']);

    $File->symptoms = $input['symptoms'];
    $File->diagnosis = $input['diagnosis'];
    $File->treatment = $input['treatment'];
    $File->todo_tests = $input['todo_tests'];

    $File->save();

    $File = File::find($input['id']);

    return json_encode($File->number);
  }
}
