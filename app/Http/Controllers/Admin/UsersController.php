<?php
namespace App\Http\Controllers\Admin;
use Carbon\Carbon;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use DataTables,Notify,Str,Storage;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Html\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Auth;
use App\Models\User;
use Event;


class UsersController extends Controller
{
    protected $authLayout = '';
    protected $pageLayout = '';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authLayout = 'admin.auth.';
        $this->pageLayout = 'admin.pages.user.';
        $this->middleware('auth');
    }

    /* -----------------------------------------------------------------------------------------
    @Description: Function for Update profile details
    @input: name,email.
    @Output: update profile details
    -------------------------------------------------------------------------------------------- */
    public function updateProfile()
    {
        $user = User::where(['status'=>'active','id'=>Auth::user()->id])->first();
        if(empty($user)){
            Notify::error('User not found.');
            return redirect()->to('admin/dashboard');
        }
        return view($this->pageLayout.'updateprofile',compact('user'));
    }

    /* -----------------------------------------------------------------------------------------
    @Description: Function for Update profile details
    @input: name,email.
    @Output: update profile details
    -------------------------------------------------------------------------------------------- */

    public function updateProfileDetail(Request $request){
        $validatedData = $request->validate([
            'email'         => 'required|unique:users,email,'.Auth::user()->id,
            'fname'    => 'required',
            'avatar'        => 'sometimes|mimes:jpeg,jpg,png'
            ]);
        try{
            $allowedfileExtension=['pdf','jpg','png'];
            if($request->hasFile('avatar')){
                $file = $request->file('avatar');
                $extension = $file->getClientOriginalExtension();
                $filename = Str::random(10).'.'.$extension;
                Storage::disk('public')->putFileAs('avatar', $file,$filename);
            }else{
                $userDetail=User::where('id',Auth::user()->id)->first()->avatar;
                $filename = $userDetail;
            }
            User::where('id',Auth::user()->id)->update([
                'avatar'         => $filename,
                'email'          => $request->email,
                'fname'          => $request->fname,
                ]);
            return redirect()->back();
        }catch(\Exception $e){
            Notify::error($e->getMessage());
        }
    }


    /* -----------------------------------------------------------------------------------------
    @Description: Function for update Password
    @input: old_password,password,password_confirmation.
    @Output: update Password
    -------------------------------------------------------------------------------------------- */
    public function updatePassword(Request $request){
        try{
            $validatedData = Validator::make($request->all(),[
               'old_password'          => 'required',
               'password'              => 'required|min:6',
               'password_confirmation' => 'required|min:6',
               ],

               [
               'old_password.required'          => 'The current password field is required.',
               'password.required'              => 'The new password field is required.',
               'password_confirmation.required' => 'The confirm password field is required.'
               ]
               );
            $validatedData->after(function() use($validatedData,$request){
                if($request->get('password') !== $request->get('password_confirmation')){
                    $validatedData->errors()->add('password_confirmation','The Confirm Password does not match.');
                }
            });
            if ($validatedData->fails()) {
                return redirect()->back()
                ->withErrors($validatedData)
                ->withInput();
            }
            if (\Hash::check($request->get('old_password'),auth()->user()->password) === false) {
                Notify::error('Your current Password does not matches with the Previous Password. Please try again.');
                return redirect()->back();
            }
            $user = auth()->user();
            $user->password =\Hash::make($request->get('password'));
            $user->save();
            Notify::success('Password Updated Successfully..!');
            return redirect()->back();
        }catch(Exception $e){
            Notify::error($e->getMessage());
        }
    }
}