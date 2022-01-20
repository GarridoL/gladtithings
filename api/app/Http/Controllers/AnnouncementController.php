<?php

namespace App\Http\Controllers;

use App\Announcement;

class AnnouncementController extends APIController
{
  function __construct(){
    $this->model = new Announcement();
  }
}
