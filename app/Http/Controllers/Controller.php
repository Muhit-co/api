<?php namespace Muhit\Http\Controllers;

use Auth;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Request;

abstract class Controller extends BaseController
{

    use DispatchesCommands, ValidatesRequests;

    public $isApi;

    public function __construct()
    {
        if (Request::is('api/*')) {

            $this->isApi = true;

        } else {

            $this->isApi = false;

            $role = $this->getRole();

            view()->share('role', $role);
        }
    }

    private function getRole()
    {
        if (!Auth::check()) {

            return 'public';
        }

        if (Auth::user()->level < 4) {

            return 'user';
        }

        if (Auth::user()->level == 4) {

            return 'unapproved-admin';
        }

        if (Auth::user()->level == 5) {

            return 'admin';
        }

        if (Auth::user()->level == 6) {

            return 'municipality-admin';
        }

        if (Auth::user()->level >= 7 and Auth::user()->level < 10) {

            return 'admin';
        }

        return 'superadmin';
    }
}
