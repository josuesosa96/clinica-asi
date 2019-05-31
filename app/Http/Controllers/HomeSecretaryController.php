<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use App\User;
use App\File;
use Validator;

class HomeSecretaryController extends Controller
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

    public function getMaxId()
    {
      return $maxNumber = DB::table('files')->max('id') + 1;
    }

    public function getTodoTestsByFileId($fileId)
    {
      $TodoTests = DB::table('todo_tests AS tt')->leftJoin('tests AS t', 't.id', '=', 'tt.test_id')->where('tt.file_id', '=', $fileId)->where('tt.is_done', '=', 0)->get();
      return $TodoTests;
    }

    public function getDoneTestsByFileId($fileId)
    {
      $DoneTests = DB::table('done_tests AS dt')->leftJoin('tests AS t', 't.id', '=', 'dt.test_id')->where('dt.file_id', '=', $fileId)->get();
      return $DoneTests;
    }

    public function getFile(Request $request)
    {
      $input = $request->json()->all();

      $File = File::where('id', $input['id'])->get();

      $filesInfo = array();

      foreach ($File as $key => $file)
      {
        $tests = array();
        $doneTests = array();
        $results = array();
        $todoTests = $this->getTodoTestsByFileId($file->id);
        $DoneTests = $this->getDoneTestsByFileId($file->id);

        foreach ($todoTests as $key => $test)
        {
          array_push($tests, array(
            'id' => $test->id,
            'name' => $test->name
            )
          );
        }

        foreach ($DoneTests as $key => $test)
        {
          array_push($doneTests, $test->name);
          array_push($results, $test->results);
        }

        $strDoneTests = implode(", ", $doneTests);
        $strResults = implode(", ", $results);

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
          'done_tests' => $strDoneTests,
          'results' => $strResults,
          'tests' => $tests
        );

        array_push($filesInfo, $File);
      }

      return $filesInfo;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('create-file-secretary');
    }

    public function create(Request $request)
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

      $file = new File;

      $maxId = $this->getMaxId();
      $number = strtoupper(substr($input['first_lastname'], 0, 1)) . \Carbon\Carbon::now()->format('dmy') . $maxId;

      $file->number = $number;
      $file->first_name = $input['first_name'];
      $file->second_name = $input['second_name'] == '' ? null : $input['second_name'];
      $file->first_lastname = $input['first_lastname'];
      $file->second_lastname = $input['second_lastname'] == '' ? null : $input['second_lastname'];
      $file->birthdate = $input['birthdate'];
      $file->age = $input['age'];
      $file->sex = $input['sex'];
      $file->dui = $input['dui'];
      $file->nit = $input['nit'];
      $file->phone_number = $input['phone_number'];
      $file->second_phone_number = $input['second_phone_number'] == '' ? null : $input['second_phone_number'];
      $file->responsible_name = $input['responsible_name'];
      $file->responsible_phone_number = $input['responsible_phone_number'];
      $file->address = $input['address'];
      $file->city = $input['city'];
      $file->state = $input['state'];
      $file->general_doctor_id = $input['general_doctor_id'];
      $file->specialist_doctor_id = $input['specialist_doctor_id'] == '' ? null : $input['specialist_doctor_id'];
      $file->allergies = $input['allergies'];

      $file->save();

      $test = DB::table('files')->orderBy('id', 'desc')->first();

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
