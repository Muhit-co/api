<?php namespace Muhit\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Request;

abstract class Controller extends BaseController {

    use DispatchesCommands, ValidatesRequests;

    public $isApi;

    public function __construct(){
        if (Request::is('api/*')) {
            $this->isApi = true;
        }
        else {
            $this->isApi = false;
        }
    }

}
