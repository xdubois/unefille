<?php

class City extends \Eloquent {
	protected $fillable = [];

  protected $table = 'cities';

  public function country() {
    $this->belongsTo('Country');
  }
}