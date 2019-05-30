<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\File;
use Validator;

class LabEditController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function index()
  {
    $Files = File::all();
    return view('lab-manager-edit')->with('files', $Files);
  }

  public function editFile(Request $request)
  {
    $messages = [
      'done_tests.required' => 'El campo "Exámenes realizados" es obligatorio',
      'results.required' => 'El campo "Resultados de los exámenes" es obligatorio',
    ];

    $input = $request->json()->all();

    $validated = Validator::make($input,
      [
        'done_tests' => 'required',
        'results' => 'required',
      ],
      $messages
    )->validate();

    $File = File::find($input['id']);

    $File->done_tests = $input['done_tests'];
    $File->results = $input['results'];

    $File->save();

    $File = File::find($input['id']);

    return json_encode($File->number);
  }
}
