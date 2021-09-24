<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Transaction;
use Illuminate\Support\Facades\DB;

class TransactionController extends APIController
{
  public $locationClass = 'Increment\Imarket\Location\Http\LocationController';

  function __construct()
  {
    $this->model = new Transaction();
    $this->notRequired = array('title');
  }

  public function create(Request $request)
  {
    $data = $request->all();
    $data['code'] = $this->generateCode();
    $this->model = new Transaction();
    $this->insertDB($data);
    return $this->response();
  }

  public function generateCode()
  {
    $code = 'SY_' . substr(str_shuffle($this->codeSource), 0, 61);
    $codeExist = Transaction::where('code', '=', $code)->get();
    if (sizeof($codeExist) > 0) {
      $this->generateCode();
    } else {
      return $code;
    }
  }
}
