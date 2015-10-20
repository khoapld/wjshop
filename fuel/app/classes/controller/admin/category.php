<?php

use Fuel\Core\Log;
use Fuel\Core\View;
use Fuel\Core\Validation;
use Fuel\Core\Input;
use Fuel\Core\DB;

class Controller_Admin_Category extends Controller_Base_Admin
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
        $this->template->title = 'Category Page';
        $this->template->content = View::forge($this->layout . '/category/index', $this->data);
    }

    public function post_create()
    {
        $val = Validation::forge();
        $val->add_callable('MyRules');
        $val->add_field('category_name', 'Category name', 'required|max_length[255]');
        $val->add_field('id', 'Category', 'trim|valid_numeric|valid_category');
        $val->add_field('parent_category_id', 'Parent category', 'trim|valid_numeric|valid_category');
        if ($val->run()) {
            DB::start_transaction();
            $category_id = $val->validated('id');
            $parent_category_id = (int) $val->validated('parent_category_id');
            $category_props = array(
                'category_name' => Model_Service_Util::mb_trim($val->validated('category_name')),
                'parent_category_id' => $parent_category_id,
                'level' => !empty($parent_category_id) ? Model_Category::find($parent_category_id)->level + 1 : 1,
            );
            $create_id = !empty($category_id) ? Model_Base_Category::update($category_id, $category_props) : Model_Base_Category::insert($category_props);
            if ($create_id) {
                $type = !empty($category_id) ? 'update' : 'new';
                $category_id = !empty($category_id) ? $category_id : $create_id;
                $photo_props = array(
                    'type' => $type,
                    'category_id' => $category_id
                );
                if ($type === 'new' || Input::file('category_photo')) {
                    $upload = Model_Service_Upload::run('category', $photo_props);
                }
                if (empty($upload['error'])) {
                    DB::commit_transaction();
                    Log::write('NOTICE', 'Create category success', static::$method);
                    $this->data['category'] = array(
                        'type' => $type,
                        'id' => $category_id,
                        'parent_category_id' => $parent_category_id,
                        'category_name' => $val->validated('category_name'),
                        'category_name_display' => Model_Base_Category::get_parent($category_id),
                        'category_photo_display' => empty($upload['photo_name']) ? : $upload['photo_name'],
                        'no_image' => _PATH_NO_IMAGE_
                    );
                    $this->data['success'] = true;
                    $this->data['msg'] = 'Create category success';
                } else {
                    DB::rollback_transaction();
                    $this->data['msg'] = $upload['error'];
                }
            } else {
                DB::rollback_transaction();
                $this->data['msg'] = 'Create category error';
            }
        } else {
            $this->data['errors'] = $val->error_message();
        }

        return $this->response($this->data);
    }

    public function post_sort()
    {
        $val = Validation::forge();
        $val->add_callable('MyRules');
        $val->add_field('category', 'Category', 'required');
        if ($val->run()) {
            $rank = 1;
            foreach ($val->validated('category') as $value) {
                Model_Base_Category::update($value, array('rank' => $rank++));
            }
            $this->data['success'] = true;
        } else {
            $this->data['errors'] = $val->error_message();
        }

        return $this->response($this->data);
    }

    public function post_status()
    {
        $val = Validation::forge();
        $val->add_callable('MyRules');
        $val->add_field('status', 'Status', 'required|valid_category_status');
        $val->add_field('category_id', 'Category', 'required|valid_category');
        if ($val->run()) {
            Model_Base_Category::update($val->validated('category_id'), array('status' => $val->validated('status')));
            $this->data['success'] = true;
        } else {
            $this->data['errors'] = $val->error_message();
        }

        return $this->response($this->data);
    }

}
