<?php
// Our Controller
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\File;
use PDF;

class CustomerController extends Controller
{
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

  public function getDoneTestsByFileId($fileId)
  {
    $DoneTests = DB::table('done_tests AS dt')->leftJoin('tests AS t', 't.id', '=', 'dt.test_id')->where('dt.file_id', '=', $fileId)->get();
    return $DoneTests;
  }

    public function printPDF($id)
    {
      $doneTests = array();
      $results = array();
      $tests = array();
      $File = File::find($id)->toArray();
      $DoneTests = $this->getDoneTestsByFileId($id);
      $Tests = $this->getTodoTestsByFileId($id);

      foreach ($Tests as $key => $test)
      {
        array_push($tests, $test->name);
      }

      foreach ($DoneTests as $key => $test)
      {
        array_push($doneTests, $test->name);
        array_push($results, $test->results);
      }

      $strTests = implode(", ", $tests);
      $strDoneTests = implode(", ", $doneTests);
      $strResults = implode(", ", $results);

      $data = array();

      $data['title'] = 'Expediente ' . $File['number'];
      $data['file'] = $File;
      $data['tests'] = $strTests;
      $data['done_tests'] = $strDoneTests;
      $data['results'] = $strResults;

      $pdf = PDF::loadView('pdf_view', $data);
      return $pdf->download('medium.pdf');
    }
}
