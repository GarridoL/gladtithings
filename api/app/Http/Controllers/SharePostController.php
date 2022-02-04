<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SharePost;

class SharePostController extends Controller
{
  function __construct(){
    $this->model = new SharePost();
  }

  public function retrieveByPayloads($payload, $payload_value) {
    $result = SharePost::where('payload', '=', $payload_value)->where('payload_value', '=', $payload_value)->get();
    return sizeof($result) > 0 ? $result[0] : null;
  }
}
