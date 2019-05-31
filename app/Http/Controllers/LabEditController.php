<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\File;
use App\TodoTests;
use App\DoneTests;
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

  public function getTodoTestsByFileId($fileId)
  {
    $TodoTests = DB::table('todo_tests AS tt')
                  ->leftJoin('tests AS t', 't.id', '=', 'tt.test_id')
                  ->where('tt.file_id', '=', $fileId)
                  ->where('tt.is_done', '=', 0)
                  ->select(
                    't.name AS name'
                  )
                  ->get()
                  ->toArray();

    return $TodoTests;
  }

  public function getTestsByName(array $tests)
  {
    $Tests = DB::table('tests AS t')
              ->whereIn('t.name', $tests)
              ->select('t.id AS id')
              ->get()
              ->toArray();
    return $Tests;
  }

  public function getFile(Request $request)
  {
    $input = $request->json()->all();

    $File = File::where('id', $input['id'])->get();

    $filesInfo = array();

    foreach ($File as $key => $file)
    {
      $tests = array();
      $todoTests = $this->getTodoTestsByFileId($file->id);

      foreach ($todoTests as $key => $test)
      {
        array_push($tests, $test->name);
      }

      $strTests = implode(", ", $tests);

      $File = array(
        'id' => $file->id,
        'number' => $file->number,
        'first_name' => $file->first_name,
        'second_name' => $file->second_name,
        'first_lastname' => $file->first_lastname,
        'second_lastname' => $file->second_lastname,
        'birthdate' => $file->birthdate,
        'age' => $file->age,
        'sex' => $file->sex,
        'dui' => $file->dui,
        'nit' => $file->nit,
        'phone_number' => $file->phone_number,
        'second_phone_number' => $file->second_phone_number,
        'responsible_name' => $file->responsible_name,
        'responsible_phone_number' => $file->responsible_phone_number,
        'address' => $file->address,
        'city' => $file->city,
        'state' => $file->state,
        'general_doctor_id' => $file->general_doctor_id,
        'specialist_doctor_id' => $file->specialist_doctor_id,
        'allergies' => $file->allergies,
        'symptoms' => $file->symptoms,
        'diagnosis' => $file->diagnosis,
        'treatment' => $file->treatment,
        'done_tests' => $file->done_tests,
        'results' => $file->results,
        'todo_tests' => $strTests
      );

      array_push($filesInfo, $File);
    }
    return $filesInfo;
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

    $test = explode(", ", $input['done_tests']);

    $testsId = $this->getTestsByName($test);

    $todoTests = DB::table('todo_tests AS tt')
                  ->leftJoin('tests AS t', 't.id', '=', 'tt.test_id')
                  ->where('tt.is_done', '=', 0)
                  ->where('tt.file_id', '=', $File->id)
                  ->select(
                    'tt.id AS todo_test_id',
                    't.id AS test_id'
                  )
                  ->get();

    foreach ($todoTests as $key => $test)
    {
      $todoTest = TodoTests::find($test->todo_test_id);
      $todoTest->is_done = 1;
      $todoTest->save();

      $DoneTests = new DoneTests;
      $DoneTests->results = $input['results'];
      $DoneTests->file_id = $File->id;
      $DoneTests->todo_test_id = $test->todo_test_id;
      $DoneTests->test_id = $test->test_id;
      $DoneTests->save();
    }

    $File = File::find($input['id']);

    return json_encode($File->number);
  }
}
