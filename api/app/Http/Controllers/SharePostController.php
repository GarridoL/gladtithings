<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SharePost;
use Carbon\Carbon;

class SharePostController extends APIController
{
  function __construct(){
    $this->model = new SharePost();
  }

  public function retrieveByPayloads($id) {
    $result = SharePost::where('id', '=', $id)->first();
    if($result !== null) {
      $result['account'] = $this->retrieveAccountDetails($result['account_id']);
      $result['created_at_human'] = Carbon::createFromFormat('Y-m-d H:i:s', $result['created_at'])->copy()->tz($this->response['timezone'])->diffForHumans();
    }
    return $result;
  }
}
