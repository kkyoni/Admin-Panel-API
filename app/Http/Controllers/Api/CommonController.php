<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Mail;
use Event;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Response;
use App\Models\User;

class CommonController extends Controller{
  public function __construct(){
    $this->apiToken = uniqid(base64_encode(str_random(60)));
  }

  public function login(Request $request){
    $validation_array =[
      'email'        => 'required|email',
      'password'        => 'required|min:8',
    ];
    $validation = Validator::make($request->all(),$validation_array);
    if($validation->fails()){
      return response()->json(['status' => 'error','message' => $validation->messages()->first()],200);
    }
    try{
      $user = User::where('email',$request->email)->first();
      if($user) {
        if( password_verify($request->password, $user->password) ) {
          $postArray = ['api_token' => $this->apiToken];
          $login = User::where('email',$request->email)->update($postArray);
          if($login) {
            return response()->json([
              'status' => 'success',
              'message' => 'Login Successfully Done..!',
              'name'         => $user->name,
              'email'        => $user->email,
              'access_token' => $this->apiToken,
            ],200);
          }
        } else {
          return response()->json([
            'status'    => 'error',
            'message'   => "Invalid Password"],200);
        }
      } else {
        return response()->json([
          'status'    => 'error',
          'message'   => "Please try again with Correct Details"],200);
      }
    }catch(\Exception $e){
      return response()->json([
        'status'    => 'error',
        'message'   => $e->getMessage()],200);
    }
  }

  public function logout(Request $request){
    try {
      $token = $request->header('Authorization');
      $user = User::where('api_token',$token)->first();
      if($user) {
        $postArray = ['api_token' => null];
        $logout = User::where('id',$user->id)->update($postArray);
        if($logout) {
          return response()->json(['status' => 'success','message' => 'User Logged Out'], 200);
        }
      } else {
        return response()->json(['status' => 'success','message' => 'User not found'], 200);
      }
    }catch (\Exception $e) {
      return response()->json(['status'  => 'error','message' => $e->getMessage()]);
    }
  }

  public function getprofile(Request $request){
    try {
      $token = $request->header('Authorization');
      $user = User::where('api_token',$token)->first();
      $UserDetail = User::where('id',$user->id)->first();
      return response()->json(['status'  => 'success','message' => 'User Detail Successfully', 'data' => $UserDetail],200);
    }catch (\Exception $e) {
      return response()->json(['status'  => 'error','message' => $e->getMessage()]);
    }
  }
}