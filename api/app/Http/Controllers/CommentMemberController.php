<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CommentMember;

class CommentMemberController extends APIController
{
    //
    public function create(Request $request){
        $data = $request->all();
        $exist = $this->checkIfExist($data['account_id'], $data['comment_id']);
        if($exist){
            $this->model = new CommentMember();
            $data = CommentMember::where('account_id', '=', $data['account_id'])->where('comment_id', '=', $data['comment_id'])->update(array(
                'liked' => $data['liked'],
                'joined' => $data['joined']
            ));
            $this->response['data'] = $data;
        }else{
            $data = CommentMember::create($data);
            $this->response['data'] = $data;
        }
        return $this->response();
    }

    public function checkIfExist($accountId, $commentId){
        $result = CommentMember::where('account_id', '=', $accountId)->where('comment_id', '=', $commentId)->get();
        return sizeof($result) > 0 ? true : false;
    }

    public function retrieveMemberWithInfo($commentId){
        $result = CommentMember::where('comment_id', '=', $commentId)->where('deleted_at', '=', null)->get();
        if(sizeof($result) > 0){
            $i=0;
            foreach ($result as $key) {
                $result[$i]['account'] = $this->retrieveFullAccountDetails($key['account_id']);
                $i++;
            }
        }
        return $result;
    }
}
