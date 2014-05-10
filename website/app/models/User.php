<?php
use Cartalyst\Sentry\Users\Eloquent\User as SentryUserModel;

class User extends SentryUserModel {

	public static $signup_rules = array(
	   	'first_name' => 'required',
      'last_name' => 'required',
      'email'    => 'required|email',
      'password' => 'required|between:3,32',
    );

	/**
	 * Indicates if the model should soft delete.
	 *
	 * @var bool
	 */
	protected $softDelete = true;

	/**
	 * Returns the user full name, it simply concatenates
	 * the user first and last name.
	 *
	 * @return string
	 */
	public function fullName() {
		return "{$this->first_name} {$this->last_name}";
	}

}