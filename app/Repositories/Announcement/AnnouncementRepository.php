<?php

namespace Muhit\Repositories\Announcement;


use Illuminate\Http\Request;
use Muhit\Models\Announcement;

class AnnouncementRepository implements AnnouncementRepositoryInterface
{
    private $announcement;
    private $status;

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
            'hood_id' => \Auth::user()->hood_id,
            'location' => '',
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'user_id' => \Auth::user()->id
        ]);

        $this->setStatus();

        return 'Duyuru yaratildi';
    }

    public function delete($id)
    {
        $announcement = $this->announcement->find($id);

        if (!$announcement || $announcement->user_id != \Auth::getUser()->id) {

            $this->setStatus('error');

            return 'Duyuru bulunamadi!';
        }

        $this->setStatus();
        $announcement->delete();

        return 'Duyuru silindi';
    }

    public function edit($id, $title, $content)
    {
        $announcement = $this->announcement->find($id);

        if (!$announcement || $announcement->user_id != \Auth::getUser()->id) {

            $this->setStatus('error');

            return 'Duyuru bulunamadi!';
        }

        $announcement->title = $title;
        $announcement->content = $content;
        $announcement->save();

        $this->setStatus();

        return 'Duyuru guncellendi';
    }

    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Default is success
     *
     * @param string $status
     */
    public function setStatus($status = 'success')
    {
        $this->status = $status;
    }
}