<?php

use Fuel\Core\View;
use Fuel\Core\Response;
use Fuel\Core\Input;

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

    public function action_index($category_id = null)
    {
        if (empty($category_id) || !Model_Base_Category::valid_by(array(
                array('id' => $category_id),
                array('status' => 1)
            ))) {
            Response::redirect('/');
        }
        $total_page = ceil(Model_Base_Product::count_by_category($category_id) / _DEFAULT_LIMIT_);
        View::set_global('total_page', $total_page);
        $this->data['products'] = Model_Base_Product::get_by_category($category_id);
        $this->template->title = 'Category Page';
        $this->template->content = View::forge($this->layout . '/category/list', $this->data);
    }

    public function post_list()
    {
        $page = (int) Input::post('page') !== 0 ? (int) Input::post('page') : 1;
        $category_id = Input::post('category_id');
        $total = Model_Base_Product::count_by_category($category_id);
        $limit = _DEFAULT_LIMIT_;
        $offset = ($page * $limit - $limit < $total) ? $page * $limit - $limit : _DEFAULT_OFFSET_;
        $this->data['products'] = Model_Base_Product::get_by_category($category_id, $offset, $limit);
        $this->data['success'] = true;

        return $this->response($this->data);
    }

}
