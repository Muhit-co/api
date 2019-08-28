<?php namespace Muhit\Http\Controllers;

use Auth;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Log;
use Muhit\Models\Hood;
use Muhit\Models\User;
use Muhit\Models\Comment;
use Muhit\Repositories\Admin\AdminRepositoryInterface;
use Storage;

class AdminController extends Controller
{
    private $admin;

    public function __construct(AdminRepositoryInterface $admin)
    {
        parent::__construct();
        $this->admin = $admin;
    }

    public function getMembers(Request $request)
    {
        $members = $this->admin->getMembers($request);

        return response()->app(200, 'admin.members.index', ['members' => $members, 'filters' => $request->all()]);
    }

    public function getViewMember($id = null)
    {
        $member = $this->admin->getMember($id);

        if (!$member) {

            return redirect('/admin/members')
                ->with('error', 'Aradığınız kullanıcı bulunamıyor. ');
        }

        $updates = $this->admin->getUpdates($id);

        return response()->app(200, 'admin.members.show', compact('member', 'updates'));
    }

    public function getEditMember($id = null)
    {
        $member = $this->admin->getMember($id);

        if (!$member) {

            return redirect('/admin/members')
                ->with('error', 'Aradığınız kullanıcı bulunamıyor. ');
        }

        return response()->app(200, 'admin.members.edit', compact('member'));
    }

    public function getRejectMuhtar($id = null)
    {
        $member = $this->admin->getMember($id);

        if (!$member) {

            return redirect('/admin/members')
                ->with('error', 'Aradığınız kullanıcı bulunamıyor. ');
        }

        if ($member->level != 4) {

            return redirect('/admin/members')
                ->with('error', 'Muhtar onay beklemiyor, onay beklemeyen muhtarları reject edemezsin.');
        }

        $response = $this->admin->rejectMuhtar($member);

        if (!$response) {

            return redirect('/admin/members')
                ->with('error', 'Muhtar güncellenirken bir hata oldu.');
        }

        return redirect('/admin/view-member/' . $member->id)
            ->with('success', 'Muhtar reject edildi.');
    }

    public function getApproveMuhtar($id = null)
    {
        $member = $this->admin->getMember($id);

        if (!$member) {

            return redirect('/admin/members')
                ->with('error', 'Aradığınız kullanıcı bulunamıyor. ');
        }

        if ($member->level != 4) {

            return redirect('/admin/members')
                ->with('error', 'Muhtar onay beklemiyor, onay beklemeyen muhtarları approve edemezsin.');
        }

        $response = $this->admin->approveMuhtar($member);

        if (!$response) {

            return redirect('/admin/members')
                ->with('error', 'Muhtar güncellenirken bir hata oldu.');
        }

        return redirect('/admin/view-member/' . $member->id)
            ->with('success', 'Muhtar onaylandı.');
    }

    /**
     * saves a member information
     *
     * @param Request $request
     * @return redirect
     * @author gcg
     */
    public function postSaveMember(Request $request)
    {
        $data = $request->all();

        $user = User::find($data['id']);

        if (empty($user)) {
            return redirect('/admin/members')
                ->with('error', 'Kullanıcı bulanamdı.');
        }

        if (isset($data['email']) and filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $user->email = $data['email'];
            $user->is_verified = 0;
        }

        #lets figure out the location.
        $location_parts = explode(",", $data['location']);
        $hood = false;
        if (count($location_parts) === 3) {
            $hood = Hood::fromLocation($data['location']);
        }

        if (isset($hood) and isset($hood->id)) {
            $user->hood_id = $hood->id;
        }

        if (isset($data['username']) and !empty($data['username'])) {
            $data['username'] = Str::slug($data['username']);
            $check_slug = (int)DB::table('users')
                ->where('username', $data['username'])
                ->where('id', '<>', $data['id'])
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
        if (isset($data['phone']) and !empty($data['phone'])) {
            $user->phone = $data['phone'];
        }

        if (!empty($data['image']) and is_array($data['image'])) {
            try {
                $name = str_replace('.', '', microtime(true));
                Storage::put('users/' . $name, base64_decode($data['image']));
                $user->picture = $name;
            } catch (Exception $e) {
                Log::error('AdminController/postSaveMember/SavingTheImage', (array)$e);
            }
        }

        try {
            $user->save();
        } catch (Exception $e) {
            Log::error('AdminController/postSaveMember', (array)$e);

            return redirect('/admin/edit-member/' . $data['id'])
                ->with('error', 'Profili güncellerken bir hata meydana geldi.');
        }

        return redirect('/admin/view-member/' . $data['id'])
            ->with('success', 'Profiliniz güncellendi.');

    }

    /**
     * deletes a member from the database
     *
     * @return redirect
     * @author gcg
     */
    public function getDeleteMember($id = null)
    {
        $member = User::find($id);

        if (empty($member)) {
            return redirect('/admin/members')
                ->with('error', 'Aradığınız kullanıcı bulunamıyor. ');
        }

        $tmp = [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'source_id' => Auth::user()->id,
            'previous_level' => $member->level,
            'current_level' => 0,
            'user_id' => $member->id,
        ];

        try {
            $member->delete();
            DB::table('user_updates')->insert($tmp);
        } catch (Exception $e) {
            Log::error('AdminController/getDeleteMember', (array)$e);
            return redirect('/admin/members')
                ->with('error', 'Üye silinirken bir hata oluştu.');
        }

        return redirect('/admin/members')
            ->with('success', 'Üye silindi.');

    }

    /**
     * deletes a comment
     *
     * @param null $id
     * @return redirect
     * @author gcg
     */
    public function getDeleteComment($id = null)
    {
        $comment = Comment::find($id);
        if (empty($comment)) {
            return redirect('/')
                ->with('error', 'Silmek istediğiniz yorum sistemde bulunmuyor...');
        }

        try {

            $comment->delete();

        } catch (Exception $e) {
            Log::error('AdminController/getDeleteComment', (array)$e);
            return redirect('/issues/view/' . $comment->issue_id)
                ->with('error', 'Yorum silerken teknik bir hata meydana geldi. ');
        }
        return redirect('/issues/view/' . $comment->issue_id)
            ->with('success', 'Yaptığınız yorumu sildiniz.');
    }

    /**
     * edits a comment
     *
     * @param null $id
     * @return view
     * @author gcg
     */
    public function getEditComment($id = null)
    {
        $comment = Comment::find($id);

        if (empty($comment)) {
            return redirect('/')
                ->with('error', 'Düzenlemek istediğiniz yorum sistemde bulunmuyor...');
        }

        return response()->app(200, 'comments.edit', ['comment' => $comment]);
    }

    /**
     * saves an editted comment
     *
     * @return view
     * @author gcg
     */
    public function postEditComment($id = null, Request $request)
    {
        $comment = Comment::find($id);

        if (empty($comment)) {

            return redirect('/')
                ->with('error', 'Düzenlemek istediğiniz yorum sistemde bulunmuyor...');
        }

        if ($request->has('comment')) {
            $comment->comment = $request->get('comment');
            try {
                $comment->save();
            } catch (Exception $e) {
                Log::error('AdminController/postEditComment', (array)$e);

                return redirect('/issues/view/' . $comment->issue_id)
                    ->with('error', 'Yorumunuzu düzenlerken teknik bir hata meydana geldi.');
            }

            return redirect('/issues/view/' . $comment->issue_id . '#comment-' . $comment->id)
                ->with('success', 'Yorumunuz başarılı bir şekilde güncellendi');

        } else {
            return redirect('/issues/view/' . $comment->issue_id)
                ->with('error', 'Lütfen yorumunuzu yazıp tekrar deneyin.');
        }
    }
}
