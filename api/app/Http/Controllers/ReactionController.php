<?php

namespace App\Http\Controllers;

use App\Reaction;

class ReactionController extends APIController
{
  function __construct(){
    $this->model = new Reaction();
  }
}
