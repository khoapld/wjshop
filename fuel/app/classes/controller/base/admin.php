<?php

use Fuel\Core\Controller_Hybrid;
use Fuel\Core\Config;
use Fuel\Core\Request;
use Fuel\Core\Response;
use Fuel\Core\View;
use Auth\Auth;

class Controller_Base_Admin extends Controller_Hybrid
{

    protected $format = 'json';
    protected $layout = 'admin';
    public static $method;
    public $controller;
    public $action;
    public $data = array();
    public $user_id;
    public $user_info;

    public function before()
    {
        $this->controller = Request::active()->controller;
        $this->action = Request::active()->action;
        static::$method = $this->controller . '/' . $this->action;
        $this->render_template();
        parent::before();
        $this->set_path();
        $this->init();
    }

    public function after($response)
    {
        $response = parent::after($response);
        return $response;
    }

    public function is_admin()
    {
        list(list(, $group_id)) = Auth::get_groups();
        if ($group_id != 100) {
            Response::redirect('/admin/signin');
        }
    }

    public function render_template()
    {
        switch ($this->action) {
            case 'signin':
                $this->template = $this->layout . '/auth/signin';
                break;
            default:
                $this->template = $this->layout . '/template';
                break;
        }
    }

    public function init()
    {
        View::set_global('controller', Request::active()->controller);
        View::set_global('action', Request::active()->action);
        if (Model_Base_User::is_login()) {
            View::set_global('head', View::forge($this->layout . '/global/head'));
            View::set_global('header', View::forge($this->layout . '/global/header'));
            View::set_global('sidebar', View::forge($this->layout . '/global/sidebar'));
            View::set_global('script', View::forge($this->layout . '/global/script'));

            list(, $auth_id) = Auth::get_user_id();
            $this->user_id = $auth_id;
            $this->user_info = Model_Base_User::get_user_info($auth_id);

            View::set_global('user', $this->user_info);
            View::set_global('base_url', Config::get('base_url'));
        }
    }

    public function set_path()
    {
        $path_config = Config::get('app.path');
        $base_url = Config::get('base_url');
        if (!defined('_PATH_NO_ICON_')) {
            define('_PATH_NO_ICON_', $base_url . $path_config['no_icon']);
            define('_PATH_NO_IMAGE_', $base_url . $path_config['no_image']);
            define('_PATH_ICON_', $base_url . $path_config['icon']);
            define('_PATH_CATEGORY_', $base_url . $path_config['category']);
            define('_PATH_PHOTO_', $base_url . $path_config['photo']);
        }
    }

}
