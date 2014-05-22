<?php

class Country extends \Eloquent {
	protected $fillable = [];

  protected $table = 'countries';

  public function cities() {
    return $this->hasMany('City');
  }
}