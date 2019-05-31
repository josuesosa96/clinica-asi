<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\File;
use App\TodoTests;
use Validator;

class DoctorEditController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function getTodoTestsByFileId($fileId)
  {
    $TodoTests = DB::table('todo_tests AS tt')->leftJoin('tests AS t', 't.id', '=', 'tt.test_id')->where('tt.file_id', '=', $fileId)->get();
    return $TodoTests;
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
    ];

    $input = $request->json()->all();

    $validated = Validator::make($input,
      [
        'symptoms' => 'required',
        'diagnosis' => 'required',
        'treatment' => 'required',
      ],
      $messages
    )->validate();

    $File = File::find($input['id']);
    $File->symptoms = $input['symptoms'];
    $File->diagnosis = $input['diagnosis'];
    $File->treatment = $input['treatment'];
    $File->save();

    $existingTests = DB::table('todo_tests AS tt')->where('tt.file_id', '=', $input['id'])->where('tt.is_done', '=', 0)->get();

    $existingTests->each(function($test)
    {
      $Test = TodoTests::find($test->id);
      $Test->is_done = 1;
      $Test->save();
    });

    foreach ($input['todo_tests'] as $key => $test)
    {
      $TodoTests = new TodoTests;
      $TodoTests->is_done = 0;
      $TodoTests->test_id = $test;
      $TodoTests->file_id = $input['id'];
      $TodoTests->save();
    }

    $File = File::find($input['id']);
    return json_encode($File->number);
  }
}
