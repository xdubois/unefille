<?php

class GeolocController extends \BaseController {

	private $username = 'pink';
	private $search_result_limit = 30;

	/**
	 * [getNearestCities description]
	 * @param  int  $city   adresse string
	 * @param  integer $radius radius
	 * @return Json          Array
	 */
	public function getNearestCities($city, $radius = 10) {
		$adapter = new \Geocoder\HttpAdapter\CurlHttpAdapter();
		$geocoder = new \Geocoder\Geocoder();
		$geocoder->registerProviders(array(
		  new Geocoder\Provider\CustomGeonamesProvider($adapter, $this->username))
		);

		try {
			$city = $geocoder->geocode($city);
			$coord = $city->getCoordinates();
			$geocoder->setResultFactory(new Geocoder\Result\MultipleResultFactory);
			$geocoder->limit($this->search_result_limit);
			$geocoder->getProviders()['geonames']->setRadius($radius); //THAT IS REALLY SHITTY
			$nearest_cities = $geocoder->reverse($coord[0], $coord[1]);

			return Response::json($nearest_cities);
		}
		catch (Expection $e) {

		}
		
		return Response::json('error', 400);
	}


}