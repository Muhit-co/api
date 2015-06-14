<?php namespace Muhit\Http\Controllers;

use Muhit\Http\Requests;
use Muhit\Http\Controllers\Controller;

use Request;
use Muhit\Models\User;

class MembersController extends Controller {

    /**
     * get user profile
     *
     * @return json
     * @author gcg
     */
    public function getProfile($id = null)
    {

    }

    /**
     * update a users profile
     *
     * @return json
     * @author gcg
     */
    public function postUpdate()
    {
        $data = Request::all();
        $user_id = Authorizer::getResourceOwnerId();

    }

}
