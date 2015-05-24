<?php namespace Muhit\Http\Controllers;

use Illuminate\Support\Str;
use Muhit\Http\Controllers\Controller;
use Muhit\Models\City;
use Muhit\Models\District;
use Muhit\Models\Hood;

class HoodsController extends Controller {

	/**
	 * get a list of cities
	 *
	 * @return json
	 * @author
	 **/
	public function getCities($q = null) {
		$cities = City::orderBy('name', 'asc');

		if ($q !== null and $q !== 'null') {
			$cities->where('name', 'LIKE', '%' . $q . '%');
		}

		$cities = $cities->get();

		if (null === $cities) {
			$cities = [];
		} else {
			$cities = $cities->toArray();
		}

		return response()->api(200, 'Cities: ', $cities);
	}

	/**
	 * get a list of districts by city or autocomplete
	 *
	 * @return json
	 * @author
	 **/
	public function getDistricts($city_id = null, $q = null) {
		$districts = District::orderBy('name', 'asc');

		if ($q !== null and $q !== 'null') {
			$districts->where('name', 'LIKE', '%' . $q . '%');
		}

		if ($city_id !== null and $city_id !== 'null') {
			$districts->where('city_id', $city_id);
		}

		$districts = $districts->get();

		if (null === $districts) {
			$districts = [];
		} else {
			$districts = $districts->toArray();
		}

		return response()->api(200, 'Districts: ', $districts);
	}

	/**
	 * get a list of hoods based on city or district or autocomplete
	 *
	 * @return json
	 * @author
	 **/
	public function getHoods($city_id = null, $district_id = null, $q = null) {
		$hoods = Hood::orderBy('name', 'asc');

		if ($q !== null and $q !== 'null') {
			$hoods->where('name', 'LIKE', '%' . $q . '%');
		}

		if ($city_id !== null and $city_id !== 'null') {
			$hoods->where('city_id', $city_id);
		}

		if ($district_id !== null and $district_id !== 'null') {
			$hoods->where('district_id', $district_id);
		}

		$hoods = $hoods->get();

		if (null === $hoods) {
			$hoods = [];
		} else {
			$hoods = $hoods->toArray();
		}

		return response()->api(200, 'Hoods: ', $hoods);
	}

}
