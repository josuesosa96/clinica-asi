<?php
// Our Controller
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\File;
use PDF;

class CustomerControllerSEC extends Controller
{
    public function printPDF($id)
    {
      $File = File::find($id)->toArray();

      $data = array();

      $data['title'] = 'Expediente ' . $File['number'];
      $data['file'] = $File;

      $pdf = PDF::loadView('pdf_viewSEC', $data);
      return $pdf->download('medium.pdf');
    }
}
