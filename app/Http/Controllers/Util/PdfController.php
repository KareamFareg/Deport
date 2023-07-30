<?php

namespace App\Http\Controllers\Util;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;

class PdfController extends Controller
{
  public function getPdf(Request $request ){

  // return response()->json($request['data']);

  // $pdf = PDF::loadHTML( $request['data'] );

  $data = $request['data'];
  $pdf = PDF::loadView('components.pdf',compact('data'));

  return response()->download( $pdf->download('Report.pdf') );
  // return $pdf->download('Admins.pdf') ;

  }
}
