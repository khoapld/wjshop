<?php

use Fuel\Core\Lang;
use Fuel\Core\View;
use Fuel\Core\Validation;

class Controller_Admin_Dashboard extends Controller_Base_Admin
{

    public function before()
    {
        parent::before();
        $this->is_admin();
    }

    public function after($response)
    {
        $response = parent::after($response);
        return $response;
    }

    public function action_index()
    {
        $this->data['config'] = Model_Config::find('first');
        $this->template->content = View::forge($this->layout . '/dashboard/index', $this->data);
    }

    public function post_maintenance()
    {
        $val = Validation::forge();
        $val->add_callable('MyRules');
        $val->add_field('maintenance', Lang::get('label.maintenance'), 'required');
        if ($val->run()) {
            Model_Base_Config::update(array('maintenance' => $val->validated('maintenance')));
            $this->data['success'] = true;
        } else {
            $this->data['errors'] = $val->error_message();
        }

        return $this->response($this->data);
    }

    public function post_update_config()
    {
        $val = Validation::forge();
        $val->add_callable('MyRules');
        $val->add_field('email', Lang::get('label.email'), 'required|valid_email|max_length[255]');
        $val->add_field('telephone', Lang::get('label.telephone'), 'trim|valid_numeric|max_length[12]');
        $val->add_field('address', Lang::get('label.address'), 'trim|max_length[255]');
        $val->add_field('fb_url', Lang::get('label.fb_url'), 'required|valid_url');
        $val->add_field('shop_name', Lang::get('label.shop_name'), 'required|max_length[255]');
        if ($val->run()) {
            $props = array(
                'email' => $val->validated('email'),
                'telephone' => $val->validated('telephone'),
                'address' => $val->validated('address'),
                'fb_url' => $val->validated('fb_url'),
                'shop_name' => $val->validated('shop_name'),
            );
            Model_Base_Config::update($props);
            $this->data['success'] = Lang::get($this->controller . '.' . $this->action . '.success');
        } else {
            $this->data['errors'] = $val->error_message();
        }

        return $this->response($this->data);
    }

}
