<?php

use Fuel\Core\View;

/**
 * The Home Controller
 *
 * @package  app
 * @extends  Controller
 */
class Controller_Product extends Controller_Base_Core
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

    public function action_index()
    {
        $this->data['product'] = Model_Base_Product::get_by(array(
                'where' => array(array('status', '=', 1))
        ));
        $total_product = Model_Base_Product::count_by(array(
                'where' => array(array('status', '=', 1))
        ));
        View::set_global('total_page', ceil($total_product / _DEFAULT_LIMIT_));

        $this->template->title = 'Product List';
        $this->template->content = View::forge($this->layout . '/product/list', $this->data);
    }

    public function action_detail($id = null)
    {
        $this->data['product'] = Model_Base_Product::get_one($id, array(
                'where' => array(array('status', '=', 1))
        ));
        if (empty($this->data['product']['id'])) {
            Response::redirect('/');
        }
        $this->data['product']['sub_photo'] = Model_Base_Product::get_sub_photo($id);

        $category_ids = Model_Base_ProductCategory::get_by('category_id', 'product_id', $id);
        if (!empty($category_ids)) {
            $this->data['products'] = Model_Base_Product::get_by_category_ids($category_ids, 0, 4);
        }
        View::set_global('product', $this->data['product']);

        $this->template->title = 'Product List';
        $this->template->content = View::forge($this->layout . '/product/detail', $this->data);
    }

}
