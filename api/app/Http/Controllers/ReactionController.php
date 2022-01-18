<?php

namespace App\Http\Controllers;

use App\Reaction;

class ReactionController extends APIController
{
  function __construct(){
    $this->model = new Reaction();
  }

  public function retrieveWithPayload($column, $clause, $value, $column1, $clause1, $value1){
    $result = Reaction::where($column, $clause, $value)->where($column1, $clause1, $value1)->select('account_id')->get();
    $final_result = array();
    $i = 0;
    if(sizeof($result) > 0) {
      foreach($result as $key) {
        array_push($final_result, $result[$i]['account_id']);
        $i++;
      }
      return $final_result;
    } else {
      return [];
    }
  }

  public function removeReaction(Request $request){
    $data = $request->all();
    $result = Reaction::where('comment_id', '=', $data['comment_id'])->where('account_id', '=', $data['account_id'])->select('id')->get();
    $final_result = Reaction::where('id', '=', $result[0]['id'])->delete();
    $this->response['data'] = $final_result;
    return $this->response();
  }
}
