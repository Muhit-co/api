<?php namespace Muhit\Http\Controllers;

use Muhit\Http\Requests;
use Muhit\Http\Controllers\Controller;

use Request;
use Muhit\Models\User;

use Authorizer;
use Auth;
use Str;

class MembersController extends Controller {


    /**
     * get user profile
     *
     * @return mixed
     * @author gcg
     */
    public function getMyProfile()
    {
        if ($this->isApi) {
            $user_id = Authorizer::getResourceOwnerId();
        }
        else {
            $user_id = Auth::user()->id;
        }

        $user = User::with('hood.district.city')->find($user_id);

        if ($user === null) {
            if($this->isApi) {
                return response()->api(404, 'User not found', ['id' => $user_id]);
            }
            return redirect('/')
                ->with('error', 'Aradığınız kullanıcı bulunamadı.');
        }

        if($this->isApi) {
            return response()->api(200, 'User profile information', ['user' => $user->toArray()]);
        }

        return response()->app(200, 'members.profile', ['user' => $user->toArray()]);
    }

    /**
     * displays a form for user editing profile
     *
     * @return view
     * @author Me
     */
    public function getEditProfile()
    {

        if (!Auth::check()) {
            return redirect('/')
                ->with('error', 'Giriş yapıp tekrar deneyebilirsiniz.');
        }

        $user = User::with('hood.district.city')->find(Auth::user()->id);

        if ($user === null) {
            return redirect('/')
                ->with('error', 'Giriş yapıp tekrar deneyebilirsiniz.');
        }

        return response()->app(200, 'members.edit', ['user' => $user]);
    }

    /**
     * get user profile
     *
     * @return mixed
     * @author gcg
     */
    public function getProfile($id = null)
    {

        $user = User::find($id);

        if ($user === null) {
            if($this->isApi) {
                return response()->api(404, 'User not found', ['id' => $id]);
            }
            return redirect('/')
                ->with('error', 'Aradığınız kullanıcı bulunamadı.');
        }

        if($this->isApi) {
            return response()->api(200, 'User profile information', ['user' => $user->toArray()]);
        }

        return response()->app(200, 'members.profile', ['user' => $user->toArray()]);
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
        if ($this->isApi) {
            $user_id = Authorizer::getResourceOwnerId();
        }
        else {
            $user_id = Auth::user()->id;
        }

        $user = User::find($user_id);

        if (empty($user)) {
            if ($this->isApi) {
                return response()->api(401, 'User issue', []);
            }
            return redirect('/')
                ->with('error', 'Kullanıcı bulanamdı.');
        }

        if (isset($data['email']) and filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $user->email = $data['email'];
            $user->is_verified = 0;
        }

        if (isset($data['username']) and !empty($data['username'])) {
            $data['username'] = Str::slug($data['username']);
            $check_slug = (int) DB::table('users')
                ->where('username', $data['username'])
                ->where('id', '<>', $user_id)
                ->count();
            if ($check_slug === 0) {
                $user->username = $data['username'];
            }
        }

        if (isset($data['first_name']) and !empty($data['first_name'])) {
            $user->first_name = $data['first_name'];
        }
        if (isset($data['last_name']) and !empty($data['last_name'])) {
            $user->last_name = $data['last_name'];
        }
        if (isset($data['location']) and !empty($data['location'])) {
            $user->location = $data['location'];

        }
        if (isset($data['coordinates']) and !empty($data['coordinates'])) {
            $user->coordinates = $data['coordinates'];
        }
    }

}
