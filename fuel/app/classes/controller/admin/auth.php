<?php

use Fuel\Core\Log;
use Fuel\Core\View;
use Fuel\Core\Response;
use Fuel\Core\Validation;
use Auth\Auth;

class Controller_Admin_Auth extends Controller_Base_Admin
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

    public function action_signin()
    {
        if (Model_Base_User::is_admin()) {
            Response::redirect('/admin');
        }
        $this->template->title = 'Signin Page';
        $this->template->content = View::forge($this->layout . '/auth/signin');
    }

    public function post_signin()
    {
        $val = Validation::forge();
        $val->add_callable('MyRules');
        $val->add_field('email', 'Email', 'required|valid_email|max_length[255]');
        $val->add_field('password', 'Password', 'required|valid_password|min_length[8]|max_length[50]');
        if ($val->run()) {
            $email = $val->validated('email');
            $password = $val->validated('password');
            if (Model_Base_User::admin_login($email, $password)) {
                Log::write('NOTICE', 'Sign in success: ' . $email, static::$method);
                $this->data['success'] = true;
            } else {
                $this->data['errors']['signin'] = 'Your username or password are not correct!!!';
            }
        } else {
            $this->data['errors'] = $val->error_message();
        }

        return $this->response($this->data);
    }

    public function action_signout()
    {
        Auth::dont_remember_me();
        Auth::logout();
        Response::redirect('/admin/signin');
    }

}
