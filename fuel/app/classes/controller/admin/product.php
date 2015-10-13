<?php

use Fuel\Core\DB;
use Fuel\Core\Log;
use Fuel\Core\View;
use Fuel\Core\Validation;
use Fuel\Core\Response;
use Fuel\Core\Input;

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
        $total_page = ceil(Model_Base_Product::count_all() / _DEFAULT_LIMIT_);
        View::set_global('total_page', $total_page);
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

    public function action_edit($id = null)
    {
        if (empty($id) || !Model_Base_Product::valid_field('id', $id)) {
            Response::redirect('/admin/product');
        }
        $this->data['category'] = Model_Base_Category::get_all();
        $this->data['product'] = Model_Base_Product::get_by('id', $id);
        $this->data['product']['category'] = Model_Base_ProductCategory::get_by('product_id', $id);
        $this->data['product']['sub_photo'] = Model_Base_Product::get_sub_photo($id);
        $this->template->title = 'Edit Product Page';
        $this->template->content = View::forge($this->layout . '/product/edit', $this->data);
    }

    public function post_list()
    {
        $total = Model_Base_Product::count_all();
        $page = (int) Input::post('page') !== 0 ? (int) Input::post('page') : 1;
        $limit = _DEFAULT_LIMIT_;
        $offset = ($page * $limit - $limit < $total) ? $page * $limit - $limit : _DEFAULT_OFFSET_;

        View::set_global('total_product', $total);
        $this->data['product'] = Model_Base_Product::get_all($offset, $limit);
        return $this->response($this->data);
    }

    public function post_create()
    {
        $val = Validation::forge();
        $val->add_callable('MyRules');
        $val->add_field('category_ids', 'Category list', 'required');
        $val->add_field('product_name', 'Product name', 'required|max_length[255]');
        $val->add_field('product_description', 'Product Description', 'trim|max_length[10000]');
        if ($val->run()) {
            DB::start_transaction();
            $category_ids = $val->validated('category_ids');
            $category_name = Model_Service_Util::mb_trim($val->validated('product_name'));
            $product_description = $val->validated('product_description');
            $product_props = array(
                'product_name' => $category_name,
                'product_description' => $product_description
            );
            $product_id = Model_Base_Product::insert($product_props);
            if ($product_id && Model_Base_ProductCategory::insert($product_id, $category_ids)) {
                $photo_props = array(
                    'type' => 'main_photo',
                    'product_id' => $product_id
                );
                $upload = Model_Service_Upload::run('product', $photo_props);
                if (empty($upload['error'])) {
                    DB::commit_transaction();
                    Log::write('NOTICE', 'Create product success', static::$method);
                    $this->data['success'] = true;
                    $this->data['msg'] = 'Update photo success';
                } else {
                    DB::rollback_transaction();
                    $this->data['msg'] = $upload['error'];
                }
            } else {
                DB::rollback_transaction();
                $this->data['msg'] = 'Create product error';
            }
        } else {
            $this->data['errors'] = $val->error_message();
        }

        return $this->response($this->data);
    }

    public function post_update()
    {
        $val = Validation::forge();
        $val->add_callable('MyRules');
        $val->add_field('id', 'Product', 'required|valid_product');
        $val->add_field('category_ids', 'Category list', 'required');
        $val->add_field('product_name', 'Product name', 'required|max_length[255]');
        $val->add_field('product_description', 'Product Description', 'trim|max_length[10000]');
        if ($val->run()) {
            DB::start_transaction();
            $product_id = $val->validated('id');
            $category_ids = implode(',', $val->validated('category_ids'));
            $category_name = Model_Service_Util::mb_trim($val->validated('product_name'));
            $product_description = $val->validated('product_description');
            $product_props = array(
                'product_name' => $category_name,
                'product_description' => $product_description
            );
            if (Model_Base_Product::update($product_id, $product_props) &&
                Model_Base_ProductCategory::update($product_id, $category_ids)) {
                DB::commit_transaction();
                Log::write('NOTICE', 'Create product success', static::$method);
                $this->data['success'] = 'Update product success';
            } else {
                DB::rollback_transaction();
                $this->data['error'] = 'Update product error';
            }
        } else {
            $this->data['errors'] = $val->error_message();
        }

        return $this->response($this->data);
    }

    public function post_main_photo()
    {
        $val = Validation::forge();
        $val->add_callable('MyRules');
        $val->add_field('id', 'Product', 'required|valid_product');
        if ($val->run()) {
            $props = array(
                'type' => 'main_photo',
                'product_id' => $val->validated('id')
            );
            $upload = Model_Service_Upload::run('product', $props);
            if (empty($upload['error'])) {
                $this->data['success'] = true;
                $this->data['msg'] = 'Update photo success';
                $this->data['photo_name'] = $upload['photo_name'];
            } else {
                $this->data['msg'] = $upload['error'];
            }
        } else {
            $this->data['errors'] = $val->error_message();
        }

        return $this->response($this->data);
    }

    public function post_sub_photo()
    {
        $val = Validation::forge();
        $val->add_callable('MyRules');
        $val->add_field('id', 'Product', 'required|valid_product');
        if ($val->run()) {
            $props = array(
                'type' => 'sub_product_photo',
                'product_id' => $val->validated('id')
            );
            $upload = Model_Service_Upload::run('photo', $props);
            if (empty($upload['error'])) {
                $this->data['success'] = true;
                $this->data['msg'] = 'Update photo success';
                $this->data['photo_id'] = $upload['photo_id'];
                $this->data['photo_name'] = $upload['photo_name'];
            } else {
                $this->data['msg'] = $upload['error'];
            }
        } else {
            $this->data['errors'] = $val->error_message();
        }

        return $this->response($this->data);
    }

    public function post_status()
    {
        $val = Validation::forge();
        $val->add_callable('MyRules');
        $val->add_field('status', 'Status', 'required|valid_product_status');
        $val->add_field('product_id', 'Product', 'required|valid_product');
        if ($val->run()) {
            Model_Base_Product::update($val->validated('product_id'), array('status' => $val->validated('status')));
            $this->data['success'] = true;
        } else {
            $this->data['errors'] = $val->error_message();
        }

        return $this->response($this->data);
    }

    public function post_delete_sub_photo()
    {
        $val = Validation::forge();
        $val->add_callable('MyRules');
        $val->add_field('photo_id', 'Photo', 'required|valid_photo');
        $val->add_field('product_id', 'Product', 'required|valid_product');
        if ($val->run()) {
            $photo_id = $val->validated('photo_id');
            $photo_name = Model_Photo::find($photo_id)->photo_name;
            if (Model_Base_Photo::delete($photo_id)) {
                Model_Service_Upload::delete_photo('photo', $photo_name);
                $this->data['success'] = true;
            }
        } else {
            $this->data['errors'] = $val->error_message();
        }

        return $this->response($this->data);
    }

    public function post_sort_sub_photo()
    {
        $val = Validation::forge();
        $val->add_callable('MyRules');
        $val->add_field('photo', 'Photo', 'required');
        if ($val->run()) {
            $rank = 1;
            foreach ($val->validated('photo') as $value) {
                Model_Base_Photo::update($value, array('rank' => $rank++));
            }
            $this->data['success'] = true;
        } else {
            $this->data['errors'] = $val->error_message();
        }

        return $this->response($this->data);
    }

}
