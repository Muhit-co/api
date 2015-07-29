<?php namespace Muhit\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Request;
use Auth;

abstract class Controller extends BaseController {

    use DispatchesCommands, ValidatesRequests;

    public $isApi;

    public function __construct(){
        if (Request::is('api/*')) {
            $this->isApi = true;
        }
        else {
            $this->isApi = false;
            $role = 'public';
            if (Auth::check()) {
                if (Auth::user()->level < 4) {
                    $role = 'user';
                }
                elseif (Auth::user()->level == 4) {
                    $role = 'unapproved-admin';
                }
                elseif (Auth::user()->level >= 5 and Auth::user()->level < 10) {
                    $role = 'admin';
                }
                else {
                    $role = 'superadmin';
                }
            }
            view()->share('role', $role);
        }


    }

}
