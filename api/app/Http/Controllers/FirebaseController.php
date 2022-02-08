<?php

namespace App\Http\Controllers;
use Kreait\Firebase\Factory;
use Illuminate\Http\Request;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Messaging;
use Exception;
use App\Jobs\Firebase;
class FirebaseController extends APIController
{
  public $messaging;
  function __construct(){
  	$path = null;
  	if(env('OS') == 'linux'){
  		$path = 'Http/Controllers/gladtithings-662af-firebase-adminsdk-5u7x4-712a3f8183.json';
  	}else{
      $path = 'Http\Controllers\gladtithings-662af-firebase-adminsdk-5u7x4-712a3f8183.json';
    }
  	$factory = (new Factory)->withServiceAccount(app_path($path));
  	$this->messaging = $factory->createMessaging();
  }

  public function sendFromJob($data){
    $this->messaging->send(CloudMessage::fromArray($data));
  }
}
