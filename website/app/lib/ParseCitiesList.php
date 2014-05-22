<?php

class ParseCitiesList {

  private $file;
  private $rows;

  public function __construct($filename) {
    $this->file = file_get_contents($filename);
    $this->rows = explode("\n", $this->file);
    array_shift($this->rows);
  }

  public function getData($country_code) {
    // Country,City,AccentCity,Region,Population,Latitude,Longitude
    $result = array();
    foreach($this->rows as $row => $data) {
      $row_data = explode(',', $data);
      if ($row_data[0] == $country_code) {
        $result[$row]['country'] = $row_data[0];
        $result[$row]['city'] = $row_data[2];
        $result[$row]['region'] = $row_data[3];
        $result[$row]['population'] = $row_data[4];
        $result[$row]['latitude'] = $row_data[5];
        $result[$row]['longitude'] = $row_data[6];
      }
    }

    return $result;
  }



}