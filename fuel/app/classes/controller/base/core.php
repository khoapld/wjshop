<?php

use Fuel\Core\Controller_Hybrid;
use Fuel\Core\Config;
use Fuel\Core\Request;
use Fuel\Core\Response;
use Fuel\Core\View;
use Auth\Auth;

class Controller_Base_Core extends Controller_Hybrid
{

    protected $format = 'json';
    protected $layout = 'default';
    protected $user_id;
    protected $email;
    protected $user_info;
    public $controller;
    public $action;
    public static $method;

    public function before()
    {
        $this->template = $this->layout . '/template';
        $this->controller = Request::active()->controller;
        $this->action = Request::active()->action;
        static::$method = $this->controller . '/' . $this->action;
        parent::before();
        $this->check_maintenance();
        $this->init();
        $this->render_template();
    }

    public function after($response)
    {
        $response = parent::after($response);
        return $response;
    }

    public function check_maintenance()
    {
        $maintenance = Config::get('app.app_config.maintenance');
        if ($this->controller == 'Controller_Home' && $this->action == 'maintenance' && $maintenance !== true) {
            Response::redirect('/');
        }
        if (!in_array($this->action, ['maintenance']) && $maintenance === true) {
            Response::redirect('/maintenance');
        }
    }

    public function init()
    {
        if (Auth::check()) {
            list(, $auth_id) = Auth::get_user_id();
            $this->user_id = $auth_id;
            $this->email = Auth::get_email();
            $this->user_info = Model_User::find($auth_id);
        }
        View::set_global('base_url', Config::get('base_url'), false);
        View::set_global('controller', $this->controller, false);
        View::set_global('action', $this->action, false);
        View::set_global('user_id', $this->user_id, false);
        View::set_global('email', $this->email, false);
        View::set_global('user_info', $this->user_info, false);
    }

    public function render_template()
    {
        View::set_global('header', View::forge($this->layout . '/global/header'));
        View::set_global('footer', View::forge($this->layout . '/global/footer'));
        View::set_global('script', View::forge($this->layout . '/global/script'));
    }

    public function is_login()
    {
        if (!Model_Base_User::is_login() && !in_array($this->action, ['maintenance', 'signin', 'signup', 'logout'])) {
            Response::redirect('/signin');
        }
    }

}
