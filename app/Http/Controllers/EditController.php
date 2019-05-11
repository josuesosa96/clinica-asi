<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\File;

class EditController extends Controller
{
  public function editFile(Request $request)
  {
    $input = $request->json()->all();

    $File = File::find($input['id']);

    $File->name = $input['name'];
    $File->age = $input['age'];
    $File->address = $input['address'];
    $File->phone_number = $input['phone_number'];
    $File->general_doctor_id = $input['general_doctor_id'];
    $File->specialist_doctor_id = $input['specialist_doctor_id'] == '' ? null : $input['specialist_doctor_id'];
    $File->allergies = $input['allergies'];
    $File->symptoms = $input['symptoms'];

    $File->save();

    $File = File::find($input['id']);

    return json_encode($File->number);
  }
}
