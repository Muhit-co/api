<?php namespace Muhit\Http\Controllers;

use Muhit\Http\Requests;
use Muhit\Http\Controllers\Controller;

use Request;
use Muhit\Models\User;

use Authorizer;

class MembersController extends Controller {

    /**
     * get user profile
     *
     * @return json
     * @author gcg
     */
    public function getProfile($id = null)
    {
        #$user_id = Authorizer::getResourceOwnerId();
        if ($id === null) {
            $id = $user_id;
        }

        $user = User::find($id);

        if ($user === null) {
            return response()->api(404, 'User not found', ['id' => $id]);
        }

        return response()->api(200, 'User profile information', ['user' => $user->toArray()]);
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
