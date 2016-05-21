<?php namespace Muhit\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Muhit\Http\Requests;
use Muhit\Http\Requests\CreateAnnouncement;
use Muhit\Repositories\Announcement\AnnouncementRepositoryInterface;
use Muhit\Repositories\Hood\HoodRepositoryInterface;

class AnnouncementController extends Controller
{
    private $announcement;
    private $hood;

    public function __construct(HoodRepositoryInterface $hood, AnnouncementRepositoryInterface $announcement)
    {
        $this->announcement = $announcement;
        $this->hood = $hood;

        parent::__construct();
    }

    public function index($hoodId = null, $start = 0, $take = 25)
    {
        $hood = [];

        if (empty($hoodId) or $hoodId == 'null') {

            if (Auth::check() && isset(Auth::user()->hood_id) and !empty(Auth::user()->hood_id)) {

                $hood = $this->hood->get(Auth::user()->hood_id);
            }

        } else {

            $hood = $this->hood->get($hoodId);
        }

        if (empty($hood)) {

            if ($this->isApi) {

                return response()->api(404, 'No hood specified.', []);
            }

            return redirect('/')
                ->with('error', 'Lütfen profil ayarlarınızdan mahallenizi girip tekrar deneyin.');
        }

        $announcements = $this->announcement->getList($hood->id, $start, $take);

        if ($this->isApi) {

            if (!$announcements) {

                return response()->api(200, 'Announcements: ', []);
            }

            return response()->api(200, 'Announcements: ', $announcements->toArray());
        }

        return view('announcements.index')->with(compact('announcements', 'hood'));
    }

    public function create(CreateAnnouncement $request)
    {
        $message = $this->announcement->create($request);
        $messageStatus = $this->announcement->getStatus();
        \Session::flash($messageStatus, $message);

        return redirect()->back();
    }

    public function edit($id, CreateAnnouncement $create)
    {
        $message = $this->announcement->edit($id, $create->get('title'), $create->get('content'));
        $messageStatus = $this->announcement->getStatus();
        \Session::flash($messageStatus, $message);

        return redirect()->back();
    }

    public function delete($id)
    {
        $message = $this->announcement->delete($id);
        $messageStatus = $this->announcement->getStatus();
        \Session::flash($messageStatus, $message);

        return redirect()->back();
    }

}
