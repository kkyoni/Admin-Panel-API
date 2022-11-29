<?php
namespace App\Http\Middleware;
use Closure;
use App\Models\User;

class APIToken{
/**
 * * Handle an incoming request.
 * *
 * * @param  \Illuminate\Http\Request  $request
 * * @param  \Closure  $next
 * * @return mixed
 * */
public function handle($request, Closure $next){
    $token = $request->header('Authorization');
    try {
        $user = User::where('api_token',$token)->first();
        if($user){
            return $next($request);
        } else {
            return response()->json([
                'status' => 'token_error',
                'message' => 'Token is Invalid',
            ],404);
        }
    } catch(Exception $e){
        return response()->json([
            'status'  => 'token_error',
            'message' => 'Authorization Token not found'
        ],404);
    }
    return $next($request);
}
}