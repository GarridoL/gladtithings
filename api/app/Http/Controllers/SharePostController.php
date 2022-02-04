<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SharePost;

class SharePostController extends APIController
{
  function __construct(){
    $this->model = new SharePost();
  }

  public function retrieveByPayloads($id) {
    $result = SharePost::where('id', '=', $id)->get();
    if(sizeof($result) > 0) {
      $result[0]['account'] = $this->retrieveAccountDetails($result[0]['account_id']);
    }
    return sizeof($result) > 0 ? $result[0] : null;
  }
}