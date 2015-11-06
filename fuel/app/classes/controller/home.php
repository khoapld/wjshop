<?php

use Fuel\Core\View;

/**
 * The Home Controller
 *
 * @package  app
 * @extends  Controller
 */
class Controller_Home extends Controller_Base_Core
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

    public function action_home()
    {
        $this->data['highlight_product'] = Model_Base_Product::get_by(array(
                'where' => array(array('highlight', '=', 1), array('status', '=', 1)),
                'limit' => 5
        ));
        $this->data['new_product'] = Model_Base_Product::get_by(array(
                'where' => array(array('status', '=', 1)),
                'limit' => 8
        ));
        $this->data['product_category'] = Model_Base_Category::get_all(array(
                'where' => array(array('parent_category_id', '=', 0), array('status', '=', 1))
        ));
        foreach ($this->data['product_category'] as $key => $value) {
            $this->data['product_category'][$key]['product'] = Model_Base_Product::get_by_category($value['id'], 0, 4);
        }
        $this->template->title = 'Home Page';
        $this->template->content = View::forge($this->layout . '/home/home', $this->data);
    }

    public function action_contact()
    {
        $this->template->title = 'Contact Page';
        $this->template->content = View::forge($this->layout . '/home/contact');
    }

    public function action_not_found()
    {
        $this->template->title = 'Page not found';
        $this->template->content = View::forge($this->layout . '/home/not_found');
    }

    public function action_maintenance()
    {
        $this->template->title = 'Maintenance Page';
        $this->template->content = View::forge($this->layout . '/home/maintenance');
    }

    public function post_contact()
    {
        $val = Validation::forge();
        $val->add_callable('MyRules');
        $val->add_field('name', 'Name', 'required|max_length[100]');
        $val->add_field('email', 'Email', 'required|valid_email|max_length[255]');
        $val->add_field('subject', 'Subject', 'required|max_length[255]');
        $val->add_field('message', 'Message', 'required|max_length[1000]');
        if ($val->run()) {
            $props = array(
                'to' => $val->validated('email'),
                'subject' => Model_Service_Util::mb_trim($val->validated('subject')),
                'content' => array(
                    'name' => Model_Service_Util::mb_trim($val->validated('name')),
                    'body' => Model_Service_Util::mb_trim($val->validated('message'))
                ),
                'view' => 'contact'
            );
            Model_Service_Mail::send_mail($props);
            $this->data['success'] = 'Gửi tin nhắn thành công';
        } else {
            $this->data['errors'] = $val->error_message();
        }

        return $this->response($this->data);
    }

}
