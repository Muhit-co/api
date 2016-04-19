<?php

namespace Muhit\Repositories\Announcement;


use Illuminate\Http\Request;
use Muhit\Models\Announcement;

class AnnouncementRepository implements AnnouncementRepositoryInterface
{
    private $announcement;

    public function __construct(Announcement $announcement)
    {
        $this->announcement = $announcement;
    }

    public function getList($hoodId, $start, $take)
    {
        return $this->announcement->with('user')
            ->where('hood_id', $hoodId)
            ->orderBy('id', 'desc')
            ->skip($start)
            ->take($take)
            ->get();
    }

    public function create(Request $request)
    {
        $this->announcement->create([
            'hood_id' => $request->get('hood_id'),
            'location' => $request->get('location'),
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'user_id' => $request->get('user_id')
        ]);
    }

    public function delete($id)
    {
        $announcement = $this->announcement->find($id);

        if (!$announcement) {

            return 'Announcement not found';
        }

        if ($announcement->user_id != \Auth::getUser()->id) {

            return 'not allowed';
        }

        $this->announcement->delete();
    }

    public function edit($id, $title, $content)
    {
        $announcement = $this->announcement->find($id);

        if (!$announcement) {

            return 'Announcement not found';
        }

        if ($announcement->user_id != \Auth::getUser()->id) {

            return 'not allowed';
        }

        $announcement->title = $title;
        $announcement->content = $content;
        $announcement->save();

        return 'Announcement updated';
    }
}