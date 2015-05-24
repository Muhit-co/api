<?php namespace Muhit\Http\Controllers;

use Muhit\Http\Controllers\Controller;
use Request;

class IssuesController extends Controller {

	/**
	 * creates a new issues
	 *
	 * @return json
	 * @author
	 **/
	public function postAdd() {
		$data = Request::all();

	}

	/**
	 * list issues
	 *
	 * @return json
	 * @author
	 **/
	public function getList($start = 0) {
	}

	/**
	 * search issues
	 *
	 * @return json
	 * @author
	 **/
	public function postSearch() {
	}

	/**
	 * issue detail
	 *
	 * @return json
	 * @author
	 **/
	public function getView($id = null) {
	}

	/**
	 * get popular issues via paginate
	 *
	 * @return json
	 * @author
	 **/
	public function getPopular($start = 0) {

	}

	/**
	 * get latest issues via paginate
	 *
	 * @return json
	 * @author
	 **/
	public function getLatest($start = 0) {

	}

	/**
	 * get issues via tag
	 *
	 * @return json
	 * @author
	 **/
	public function getByTag($tag_id = null, $start = 0) {

	}

	/**
	 * get issues by hood
	 *
	 * @return json
	 * @author
	 **/
	public function getByHood($hood_id = null, $start = 0) {
	}

	/**
	 * get issues by district
	 *
	 * @return json
	 * @author
	 **/
	public function getByDistrict($district_id = null, $start = 0) {
	}

	/**
	 * get issues by city
	 *
	 * @return json
	 * @author
	 **/
	public function getByCity($city_id = null, $start = 0) {
	}

	/**
	 * get issues by user
	 *
	 * @return json
	 * @author
	 **/
	public function getByUser($user_id = null, $start = 0) {
	}

	/**
	 * get issues by status
	 *
	 * @return json
	 * @author
	 **/
	public function getByStatus($status = null, $start = 0) {
	}

	/**
	 * get issues by sporter id
	 *
	 * @return json
	 * @author
	 **/
	public function getBySupporter($user_id = null, $start = 0) {
	}
}
