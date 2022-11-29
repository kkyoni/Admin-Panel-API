<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Carbon\Carbon;
use Response;
class MainController extends Controller
{
    protected $authLayout = '';
    protected $pageLayout = 'admin.pages.';

    public function __construct()
    {
        $this->authLayout = 'admin.auth.';
        $this->pageLayout = 'admin.pages.';
        $this->middleware('auth');
    }

    /* -----------------------------------------------------------------------------------------
    @Description: Function Index Page
    -------------------------------------------------------------------------------------------- */


    public function index()
    {
        return view('front.auth.login');
    }

    /* -----------------------------------------------------------------------------------------
    @Description: Function Dashboard Page
    -------------------------------------------------------------------------------------------- */


    public function dashboard(){
        return view('admin.pages.dashboard');
    }

}
