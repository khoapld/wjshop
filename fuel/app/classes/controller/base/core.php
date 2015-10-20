<?php

use Fuel\Core\Controller_Hybrid;
use Fuel\Core\Config;
use Fuel\Core\Request;
use Fuel\Core\Response;
use Fuel\Core\View;

class Controller_Base_Core extends Controller_Hybrid
{

    protected $format = 'json';
    protected $layout = 'default';
    public $controller;
    public $action;
    public $data = array();
    public static $method;

    public function before()
    {
        $this->template = $this->layout . '/template';
        $this->controller = Request::active()->controller;
        $this->action = Request::active()->action;
        static::$method = $this->controller . '/' . $this->action;
        $this->render_template();
        parent::before();
        $this->set_path();
        $this->check_maintenance();
        $this->init();
    }

    public function after($response)
    {
        $response = parent::after($response);
        return $response;
    }

    public function check_maintenance()
    {
        $maintenance = (int) Model_Config::find('first')->maintenance;
        if ($this->action === 'maintenance' && $maintenance !== 1) {
            Response::redirect('/');
        }
        if (!in_array($this->action, ['maintenance']) && $maintenance === 1) {
            Response::redirect('/maintenance');
        }
    }

    public function render_template()
    {
        switch ($this->action) {
            case 'not_found':
                $this->template = $this->layout . '/home/not_found';
                break;
            case 'maintenance':
                $this->template = $this->layout . '/home/maintenance';
                break;
            default:
                $this->template = $this->layout . '/template';
                break;
        }
    }

    public function init()
    {
        View::set_global('base_url', Config::get('base_url'));
        View::set_global('controller', Request::active()->controller);
        View::set_global('action', Request::active()->action);

        View::set_global('category', Model_Base_Category::get_all(array(
                'where' => array(array('status', '=', 1))
        )));

        View::set_global('head', View::forge($this->layout . '/global/head'));
        View::set_global('header', View::forge($this->layout . '/global/header'));
        View::set_global('footer', View::forge($this->layout . '/global/footer'));
        View::set_global('script', View::forge($this->layout . '/global/script'));
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
            define('_PATH_PRODUCT_', $base_url . $path_config['product']);
            define('_PATH_ROOT_PHOTO_', $base_url . $path_config['root_photo']);
            define('_PATH_PHOTO_', $base_url . $path_config['photo']);
        }
    }

}
