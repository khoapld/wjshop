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

}
