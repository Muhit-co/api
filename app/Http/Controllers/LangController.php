<?php namespace Muhit\Http\Controllers;

use App;
use Session;

class LangController extends Controller
{

    public function changeLoc($loc)
    {
        Session::put('lang', $loc);
        return redirect('/')
            ->with('success', 'You are all set with: '.$loc);
    }
}
