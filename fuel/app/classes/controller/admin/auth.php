<?php

use Fuel\Core\Lang;
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
        $this->template->content = View::forge($this->layout . '/auth/signin');
    }

    public function post_signin()
    {
        $val = Validation::forge();
        $val->add_callable('MyRules');
        $val->add_field('email', Lang::get('label.email'), 'required|valid_email|max_length[255]');
        $val->add_field('password', Lang::get('label.password'), 'required|valid_password|min_length[8]|max_length[50]');
        if ($val->run()) {
            $email = $val->validated('email');
            $password = $val->validated('password');
            if (Model_Base_User::admin_login($email, $password)) {
                $this->data['success'] = true;
            } else {
                $this->data['errors']['signin'] = Lang::get($this->controller . '.' . $this->action . '.error');
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
