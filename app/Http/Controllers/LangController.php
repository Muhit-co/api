<?php namespace Muhit\Http\Controllers;

use App;

class LangController extends Controller
{

    public function changeLoc($loc)
    {
        App::setLocale($loc);
        return redirect('/')
            ->with('success', 'You are all set with: '.$loc);
    }
}
