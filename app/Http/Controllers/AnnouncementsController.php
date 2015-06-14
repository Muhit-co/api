<?php namespace Muhit\Http\Controllers;

use Muhit\Http\Requests;
use Muhit\Http\Controllers\Controller;
use Muhit\Models\Announcement;

use Illuminate\Http\Request;

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
    public function getList($hood_id = null, $start = null, $take = null)
    {
        $announcements = Announcement::where('hood_id', $hood_id)->get();

        if ($announcements === null) {
            return response()->api(200, 'Announcements: ', []);
        }

        return response()->api(200, 'Announcements: ', $announcements->toArray());
    }

}
