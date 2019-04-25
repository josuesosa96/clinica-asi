<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use App\User;
use App\File;

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
      // var_dump($request);die();
      $file = new File;

      $file->number = $this->getMaxNumber();
      $file->name = $request->name;
      $file->age = $request->age;
      $file->address = $request->address;
      $file->phone_number = $request->phone_number;
      $file->appointment_date = $request->appointment_date;
      $file->general_doctor_id = $request->general_doctor_id;
      $file->specialist_doctor_id = $request->specialist_doctor_id;
      $file->allergies = $request->allergies;
      $file->symptoms = $request->symptoms;

      $file->save();

      return redirect()->route('home');
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
