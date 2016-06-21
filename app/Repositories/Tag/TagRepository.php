<?php

namespace Muhit\Repositories\Tag;


use Muhit\Models\Tag;

class TagRepository implements TagRepositoryInterface
{
    private $tag;

    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }

    public function all($query)
    {
        $tags = $this->tag->orderBy('name', 'asc');

        if ($query) {
            
            $tags->where('name', 'LIKE', "%{$query}%");
        }

        return \ResponseService::createResponse('tags', $tags->get());
    }
}