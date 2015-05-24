<?php namespace Muhit\Http\Controllers;

use Muhit\Http\Controllers\Controller;
use Muhit\Models\Tag;

class TagsController extends Controller {

	/**
	 * list tags
	 *
	 * @return json
	 * @author
	 **/
	public function getList($q = null) {
		$tags = Tag::orderBy('name', 'asc');

		if ($q !== null and $q !== 'null') {
			$tags->where('name', 'LIKE', '%' . $q . '%');
		}

		$tags = $tags->get();

		if (null === $tags) {
			$tags = [];
		} else {
			$tags = $tags->toArray();
		}

		return response()->api(200, 'Tags:', $tags);
	}

}
