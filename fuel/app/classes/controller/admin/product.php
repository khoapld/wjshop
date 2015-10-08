<?php

use Fuel\Core\Log;
use Fuel\Core\View;
use Fuel\Core\Validation;
use Fuel\Core\DB;

class Controller_Admin_Product extends Controller_Base_Admin
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
        $this->data['category'] = Model_Base_Category::get_all();
        $this->data['product'] = Model_Base_Product::get_all();
        $this->template->title = 'Product Page';
        $this->template->content = View::forge($this->layout . '/product/index', $this->data);
    }

    public function action_new()
    {
        $this->data['category'] = Model_Base_Category::get_all();
        $this->template->title = 'Add Product Page';
        $this->template->content = View::forge($this->layout . '/product/new', $this->data);
    }

    public function post_create()
    {
        $val = Validation::forge();
        $val->add_callable('MyRules');
        $val->add_field('id', 'Product', 'trim|valid_product');
        $val->add_field('category_ids', 'Category list', 'required');
        $val->add_field('product_name', 'Product name', 'required|max_length[255]');
        $val->add_field('product_description', 'Product Description', 'trim|max_length[10000]');
        if ($val->run()) {
            DB::start_transaction();
            $product_id = $val->validated('id');
            $category_ids = $val->validated('parent_category_id');
            $product_props = array(
                'product_name' => Model_Service_Util::mb_trim($val->validated('product_name')),
                'product_description' => $val->validated('product_description')
            );
            $type = !empty($id) ? 'update' : 'new';
            $create = !empty($product_id) ? Model_Base_Product::update($product_id, $product_props) : Model_Base_Product::insert($product_props);

            if ($create) {
                $product_id = !empty($product_id) ? : $create;
                $photo_props = array(
                    'type' => $type,
                    'product_id' => $product_id
                );
                $upload = Model_Service_Upload::run('product', $photo_props);
                if (empty($upload['error'])) {
                    DB::commit_transaction();
                    $this->data['product'] = array(
                        'type' => $type,
                        'id' => $product_id,
                        'product_name' => $val->validated('product_name'),
                        'product_description' => $val->validated('product_description'),
                        'product_photo_display' => empty($upload['photo_name']) ? : $upload['photo_name'],
                        'no_image' => _PATH_NO_IMAGE_
                    );
                    Log::write('NOTICE', 'Create product success', static::$method);
                } else {
                    DB::rollback_transaction();
                }

                $this->data['success'] = empty($upload['error']) ? true : false;
                $this->data['error'] = empty($upload['error']) ? 'Create product success' : $upload['error'];
            } else {
                $this->data['errors']['create_product'] = 'Create product error';
            }
        } else {
            $this->data['errors'] = $val->error_message();
        }

        return $this->response($this->data);
    }

}
