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
        $this->template->title = 'Dashboard Page';
        $this->template->content = View::forge($this->layout . '/dashboard/index');
    }

}
