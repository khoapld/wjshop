<?php

use Fuel\Core\View;

/**
 * The Home Controller
 *
 * @package  app
 * @extends  Controller
 */
class Controller_Category extends Controller_Base_Core
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

    public function action_list($category_id = null)
    {
        $this->template->title = 'Category Page';
        $this->template->content = View::forge($this->layout . '/category/list', $this->data);
    }

}
