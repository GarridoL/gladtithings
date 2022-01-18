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
        array_push($final_result, $result['account_id']);
        $i++;
      }
      return $final_result;
    } else {
      return [];
    }
  }

}
