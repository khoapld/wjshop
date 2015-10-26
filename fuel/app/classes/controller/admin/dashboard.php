<?php

use Fuel\Core\View;
use Fuel\Core\Response;

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
        $this->template->title = 'Dashboard Page';
        $this->template->content = View::forge($this->layout . '/dashboard/index', $this->data);
    }

    public function post_maintenance()
    {
        $val = Validation::forge();
        $val->add_callable('MyRules');
        $val->add_field('maintenance', 'Maintenance', 'required');
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
        $val->add_field('email', 'Email', 'required|valid_email|max_length[255]');
        $val->add_field('telephone', 'Telephone', 'trim|valid_numeric|max_length[12]');
        $val->add_field('address', 'Address', 'trim|max_length[255]');
        $val->add_field('fb_url', 'FB URL', 'required|valid_url');
        $val->add_field('shop_name', 'Shop Name', 'required|max_length[255]');
        if ($val->run()) {
            $props = array(
                'email' => $val->validated('email'),
                'telephone' => $val->validated('telephone'),
                'address' => $val->validated('address'),
                'fb_url' => $val->validated('fb_url'),
                'shop_name' => $val->validated('shop_name'),
            );
            Model_Base_Config::update($props);
            $this->data['success'] = 'Update config success';
        } else {
            $this->data['errors'] = $val->error_message();
        }

        return $this->response($this->data);
    }

}
