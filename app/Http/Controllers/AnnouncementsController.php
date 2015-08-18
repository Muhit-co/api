<?php namespace Muhit\Http\Controllers;

use Muhit\Http\Requests;
use Muhit\Http\Controllers\Controller;
use Muhit\Models\Announcement;

use Illuminate\Http\Request;

use Muhit\Models\Hood;

use Auth;

class AnnouncementsController extends Controller {

    /**
     * adds new announcement
     *
     * @return josn
     * @author gcg
     */
    public function postAdd()
    {

    }

    /**
     * get the list of announcements for givin hood.
     *
     * @return json
     * @author gcg
     */
    public function getList($hood_id = null, $start = 0, $take = 25)
    {
        $hood = [];

        if (empty($hood_id) or $hood_id == 'null') {
            if (Auth::check()) {
                if (isset(Auth::user()->hood_id) and !empty(Auth::user()->hood_id)) {
                    $hood = Hood::with('district.city')->find(Auth::user()->hood_id);
                    $hood_id = $hood->id;
                }
            }
        }
        else {
            $hood = Hood::with('district.city')->find($hood_id);
        }

        if (empty($hood)) {
            if ($this->isApi) {
                return response()->api(404, 'No hood spesified.', []);
            }
            return redirect('/')
                ->with('error', 'Lütfen profil ayarlarınızdan mahallenizi girip tekrar deneyin.');
        }

        $hood_id = $hood->id;

        $announcements = Announcement::with('user')
            ->where('hood_id', $hood_id)
            ->orderBy('id', 'desc')
            ->skip($start)
            ->take($take)
            ->get();

        if ($this->isApi) {
            if ($announcements === null) {
                return response()->api(200, 'Announcements: ', []);
            }

            return response()->api(200, 'Announcements: ', $announcements->toArray());
        }


        return response()->app(200, 'announcements.list', ['announcements' => $announcements, 'hood' => $hood]);
    }

}
