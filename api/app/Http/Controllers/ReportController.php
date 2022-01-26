<?php

namespace App\Http\Controllers;

use App\Report;
use Illuminate\Http\Request;

class ReportController extends APIController
{
    function __construct(){
        $this->model = new Report();
    }
}
