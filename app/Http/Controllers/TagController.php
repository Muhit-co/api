<?php namespace Muhit\Http\Controllers;

use Muhit\Repositories\Tag\TagRepositoryInterface;

class TagController extends Controller
{
    public function index(TagRepositoryInterface $tagRepository, $query = null)
    {
        $tags = $tagRepository->all($query);

        return $tags;
    }

}
