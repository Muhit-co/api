<?php

namespace Muhit\Repositories\Admin;

use Auth;
use Date;
use DB;
use Exception;
use Illuminate\Http\Request;
use Log;
use Muhit\Models\User;

class AdminRepository implements AdminRepositoryInterface
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getMembers(Request $request)
    {
        $order = ($request->has('order')) ? $request->get('order') : 'id';
        $dir = ($request->has('dir')) ? $request->get('dir') : 'asc';

        $users = $this->user->orderBy($order, $dir);

        $filterable_fields = ['level', 'location', 'q'];

        foreach ($filterable_fields as $field) {
            if ($request->has($field)) {
                if ($field == 'q') {
                    $users->where('username', 'LIKE', '%' . $request->get($field) . '%')
                        ->orWhere('first_name', 'LIKE', '%' . $request->get($field) . '%')
                        ->orWhere('last_name', 'LIKE', '%' . $request->get($field) . '%')
                        ->orWhere('email', 'LIKE', '%' . $request->get($field) . '%');
                } else {
                    $users->where($field, 'LIKE', '%' . $request->get($field) . '%');
                }
            }
        }

        return $users->paginate(30);
    }

    public function getMember($id)
    {
        return $this->user->find($id);
    }

    public function getUpdates($id)
    {
        return DB::table('user_updates')->where('user_id', $id)->get();
    }

    public function rejectMuhtar($member)
    {
        try {
            $data = [
                'created_at' => Date::now(),
                'updated_at' => Date::now(),
                'source_id' => Auth::user()->id,
                'previous_level' => $member->level,
                'current_level' => 3,
                'user_id' => $member->id,
            ];

            $member->level = 3;
            $member->save();
            DB::table('user_updates')->insert($data);
        } catch (Exception $e) {
            Log::error('AdminController/getRejectMuhtar', (array)$e);

            return false;
        }

        return true;
    }

    public function approveMuhtar($member)
    {
        try {
            $current_level = (isset($member->admin_type) && $member->admin_type == 'municipality') ? 6 : 5;

            $data = [
                'created_at' => Date::now(),
                'updated_at' => Date::now(),
                'source_id' => Auth::user()->id,
                'previous_level' => $member->level,
                'current_level' => $current_level,
                'user_id' => $member->id,
            ];

            $member->level = $current_level;
            $member->save();
            DB::table('user_updates')->insert($data);
        } catch (Exception $e) {
            Log::error('AdminController/getApproveMuhtar', (array)$e);

            return false;
        }

        return true;
    }
}
