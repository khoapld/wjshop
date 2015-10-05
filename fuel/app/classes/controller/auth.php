<?php

use Fuel\Core\Response;
use Fuel\Core\View;
use Fuel\Core\Validation;
use Fuel\Core\Log;
use Auth\Auth;

/**
 * The Auth Controller
 *
 * @package  app
 * @extends  Controller
 */
class Controller_Auth extends Controller_Base_Core
{

    public function before()
    {
        parent::before();
    }

    public function after($response)
    {
        $response = parent::after($response);
        return $response;
    }

    public function action_index()
    {
        return Response::redirect('/signin');
    }

    public function action_signin()
    {
        if (Model_Base_User::is_login()) {
            Response::redirect('/');
        }
        $this->template->title = 'Signin Page';
        $this->template->content = View::forge($this->layout . '/auth/signin');
    }

    public function action_signup()
    {
        if (Model_Base_User::is_login()) {
            Response::redirect('/');
        }
        $this->template->title = 'Signup Page';
        $this->template->content = View::forge($this->layout . '/auth/signup');
    }

    public function delete_signout()
    {
        Auth::dont_remember_me();
        Auth::logout();
        Response::redirect('/');
    }

    public function post_signin()
    {
        $data = [];
        $val = Validation::forge();
        $val->add_callable('MyRules');
        $val->add_field('email', 'Email', 'required|max_length[255]|valid_email|invalid_email');
        $val->add_field('password', 'Password', 'required|valid_password|min_length[8]|max_length[50]');
        $val->add_field('remember', 'Remember', 'trim');
        if ($val->run()) {
            $email = $val->validated('email');
            $password = $val->validated('password');
            $is_remember = $val->validated('remember');
            if (Model_Base_User::user_login($email, $password, $is_remember)) {
                $data['success'] = true;
                Log::write('NOTICE', 'Sign in success: ' . $email, static::$method);
            } else {
                $data['errors']['password'] = 'Password not correct';
            }
        } else {
            $data['errors'] = $val->error_message();
        }

        return $this->response($data);
    }

    public function post_signup()
    {
        $data = [];
        $val = Validation::forge();
        $val->add_callable('MyRules');
        $val->add_field('email', 'Email', 'required|valid_email|unique_email');
        $val->add_field('username', 'Username', 'required|min_length[8]|max_length[50]');
        $val->add_field('password', 'Password', 'required|valid_password|min_length[8]|max_length[50]');
        $val->add_field('confirm_password', 'Confirm Password', 'match_field[password]');
        if ($val->run()) {
            $email = strtolower($val->validated('email'));
            $props = [
                'username' => $val->validated('username'),
                'email' => $val->validated('email'),
                'password' => $val->validated('password')
            ];
            if ($user_id = Model_Base_User::insert_user($props)) {
                Auth::instance()->force_login($user_id);
                Auth::remember_me();
                Log::write('NOTICE', 'Sign up success: ' . $email, static::$method);
            } else {
                Log::write('ERROR', 'System error: Cannot signup user', static::$method);
            }
            $data['success'] = true;
        } else {
            $data['errors'] = $val->error_message();
        }

        return $this->response($data);
    }

}
