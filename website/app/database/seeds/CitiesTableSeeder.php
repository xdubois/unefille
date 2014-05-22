<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class CitiesTableSeeder extends Seeder {

	public function run() {

    $country = new Country(); 
    $country->name = 'Switzerland';
    $country->iso_code = 'ch';
    $country->save();
    
    $parse = new ParseCitiesList('public/data/worldcitiespop.txt');
    foreach($parse->getData('ch') as $row) {
      $city = new City();
      $city->name = $row['city'];
      $city->region = $row['region'];
      $city->population = $row['population'];
      $city->latitude = $row['latitude'];
      $city->longitude = $row['longitude'];
      $city->country_id = $country->id;
      $city->save();
      print "$city->name added. \n";
    }

	}

}

