<?php namespace Muhit\Http\Controllers;

use Muhit\Repositories\Tag\TagRepositoryInterface;

class TagController extends Controller
{

    /**
     * list tags
     *
     * @param TagRepositoryInterface $tagRepository
     * @param null $q
     * @return json
     * @author
     */
    public function index(TagRepositoryInterface $tagRepository, $q = null)
    {
        $tags = $tagRepository->all($q);

        return response()->api(200, 'Tags:', $tags);
    }

}
