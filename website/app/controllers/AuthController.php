<?php

class AuthController extends BaseController {

  protected $default_redirect = 'home';

  /**
   * Account sign in.
   *
   * @return View
   */
  public function signin() {
    // Is the user logged in?
    if (Sentry::check()) {
      return Redirect::route($this->default_redirect);
    }
    // Show the page
    return View::make('front.auth.signin');
  }

  /**
   * Account sign in form processing.
   *
   * @return Redirect
   */
  public function login() {
    // Declare the rules for the form validation
    $rules = array(
      'email' => 'required|email',
      'password' => 'required|between:3,32',
    );
    // Create a new validator instance from our validation rules
    $validator = Validator::make(Input::all(), $rules);
    // If validation fails, we'll exit the operation now.
    if ($validator->fails()) {
      // Ooops.. something went wrong
      return Redirect::back()->withInput()->withErrors($validator);
    }

    try {
      // Try to log the user in
      Sentry::authenticate(Input::only('email', 'password'), Input::get('remember-me', 0));
      // Get the page we were before
      $redirect = Session::get('loginRedirect', '.');
      // Unset the page we were before from the session
      Session::forget('loginRedirect');
      // Redirect to the users page
      return Redirect::to($redirect)->with('success', Lang::get('auth.signin.success'));
    }
    catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
      $this->messageBag->add('email', Lang::get('auth.account_not_found'));
    }
    catch (Cartalyst\Sentry\Users\UserNotActivatedException $e) {
      $this->messageBag->add('email', Lang::get('auth.account_not_activated'));
    }
    catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e) {
      $this->messageBag->add('email', Lang::get('auth.account_suspended'));
    }
    catch (Cartalyst\Sentry\Throttling\UserBannedException $e) {
      $this->messageBag->add('email', Lang::get('auth.account_banned'));
    }
    // Ooops.. something went wrong
    return Redirect::back()->withInput()->withErrors($this->messageBag);
  }

  /**
   * Account sign up.
   *
   * @return View
   */
  public function signup() {
    // Is the user logged in?
    if (Sentry::check()) {
      return Redirect::route($this->default_redirect);
    }

    return View::make('front.auth.signup');
  }

  /**
   * Account sign up form processing.
   *
   * @return Redirect
   */
  public function store() {

    $inputs = array_except(Input::all(), array('_method'));

    // Create a new validator instance from our validation rules
    $validator = Validator::make($inputs, User::$signup_rules);
    // If validation fails, we'll exit the operation now.
    if ($validator->fails()) {
      // Ooops.. something went wrong
      return Redirect::back()->withInput()->withErrors($validator);
    }
    try {

      // Register the user
      $user = Sentry::register(array(
        'email' => Input::get('email'),
        'password' => Input::get('password'),
        'first_name' => Input::get('first_name'),
        'last_name' => Input::get('last_name'),
        'activated' => TRUE,
      ));

      // If not we redirect him to the company creation form
      return Redirect::route('signin')->with('success', Lang::get('auth.signup.success'));

      // Data to be used on the email view
      // $data = array(
      //   'user' => $user,
      //   'activationUrl' => URL::route('activate', $user->getActivationCode()),
      // );
      // // Send the activation code through email
      // Mail::send('emails.register-activate', $data, function($m) use ($user) {
      //   $m->to($user->email, $user->first_name . ' ' . $user->last_name);
      //   $m->subject('Welcome ' . $user->first_name);
      // });
      // // Redirect to the register page

    }
    catch (Cartalyst\Sentry\Users\UserExistsException $e) {
      $this->messageBag->add('email', Lang::get('auth.account_already_exists'));
    }
    // Ooops.. something went wrong
    return Redirect::back()->withInput()->withErrors($this->messageBag);
  }

  /**
   * User account activation page.
   *
   * @param  string  $actvationCode
   * @return
   */
  public function activate($activationCode = null) {
    // Is the user logged in?
    if (Sentry::check()) {
      return Redirect::route($this->default_redirect);
    }

    try {
      // Get the user we are trying to activate
      $user = Sentry::getUserProvider()->findByActivationCode($activationCode);

      // Try to activate this user account
      if ($user->attemptActivation($activationCode)) {
        // Redirect to the login page
        return Redirect::route('signin')->with('success', Lang::get('auth.activate.success'));
      }

      // The activation failed.
      $error = Lang::get('auth.activate.error');
    }
    catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
      $error = Lang::get('auth.activate.error');
    }

    // Ooops.. something went wrong
    return Redirect::route('signin')->with('error', $error);
  }

  /**
   * Forgot password page.
   *
   * @return View
   */
  public function forgotPassword() {
    // Show the page
    return View::make('front.auth.forgot-password');
  }

  /**
   * Forgot password form processing page.
   *
   * @return Redirect
   */
  public function sendForgotPassword() {
    // Declare the rules for the validator
    $rules = array(
      'email' => 'required|email',
    );

    // Create a new validator instance from our dynamic rules
    $validator = Validator::make(Input::all(), $rules);

    // If validation fails, we'll exit the operation now.
    if ($validator->fails()) {
      // Ooops.. something went wrong
      return Redirect::route('forgot-password')->withInput()->withErrors($validator);
    }

    try {
      // Get the user password recovery code
      $user = Sentry::getUserProvider()->findByLogin(Input::get('email'));

      // Data to be used on the email view
      $data = array(
        'user' => $user,
        'forgotPasswordUrl' => URL::route('forgot-password-confirm', $user->getResetPasswordCode()),
      );

      // Send the activation code through email
      Mail::send('emails.forgot-password', $data, function($m) use ($user) {
                $m->to($user->email, $user->first_name . ' ' . $user->last_name);
                $m->subject('Account Password Recovery');
              });
    }
    catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
      // Even though the email was not found, we will pretend
      // we have sent the password reset code through email,
      // this is a security measure against hackers.
    }

    //  Redirect to the forgot password
    return Redirect::route('forgot-password')->with('success', Lang::get('auth.forgot-password.success'));
  }

  /**
   * Forgot Password Confirmation page.
   *
   * @param  string  $passwordResetCode
   * @return View
   */
  public function confirmForgotPassword($passwordResetCode = null) {
    try {
      // Find the user using the password reset code
      $user = Sentry::getUserProvider()->findByResetPasswordCode($passwordResetCode);
    }
    catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
      // Redirect to the forgot password page
      return Redirect::route('forgot-password')->with('error', Lang::get('auth.account_not_found'));
    }
    // Show the page
    return View::make('front.auth.forgot-password-confirm');
  }

  /**
   * Forgot Password Confirmation form processing page.
   *
   * @param  string  $passwordResetCode
   * @return Redirect
   */
  public function chooseNewPassword ($passwordResetCode = null) {
    // Declare the rules for the form validation
    $rules = array(
      'password' => 'required',
      'password_confirm' => 'required|same:password'
    );
    // Create a new validator instance from our dynamic rules
    $validator = Validator::make(Input::all(), $rules);
    // If validation fails, we'll exit the operation now.
    if ($validator->fails()) {
      // Ooops.. something went wrong
      return Redirect::route('forgot-password-confirm', $passwordResetCode)->withInput()->withErrors($validator);
    }

    try {
      // Find the user using the password reset code
      $user = Sentry::getUserProvider()->findByResetPasswordCode($passwordResetCode);

      // Attempt to reset the user password
      if ($user->attemptResetPassword($passwordResetCode, Input::get('password'))) {
        // Password successfully reseted
        return Redirect::route('signin')->with('success', Lang::get('auth.forgot-password-confirm.success'));
      }
      else {
        // Ooops.. something went wrong
        return Redirect::route('signin')->with('error', Lang::get('auth.forgot-password-confirm.error'));
      }
    }
    catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
      // Redirect to the forgot password page
      return Redirect::route('forgot-password')->with('error', Lang::get('auth.account_not_found'));
    }
  }

  /**
   * Logout page.
   *
   * @return Redirect
   */
  public function logout() {
    // Log the user out
    Sentry::logout();

    // Redirect to the users page
    return Redirect::route($this->default_redirect)->with('success', 'You have successfully logged out!');
  }

}
