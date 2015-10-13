<?php

use Fuel\Core\Log;
use Fuel\Core\View;
use Fuel\Core\Validation;
use Auth\Auth;

class Controller_Admin_Profile extends Controller_Base_Admin
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
        $this->data['user_config'] = Model_Service_Util::get_app_config('user', array('gender', 'group'));
        $this->template->title = 'Profile Page';
        $this->template->content = View::forge($this->layout . '/profile/index', $this->data);
    }

    public function post_update_username()
    {
        $val = Validation::forge();
        $val->add_callable('MyRules');
        $val->add_field('username', 'Username', 'required|valid_username|min_length[6]|max_length[50]|unique_username');
        if ($val->run()) {
            $props = array(
                'username' => $val->validated('username')
            );
            if (Model_Base_User::update($this->user_id, $props)) {
                Auth::force_login($this->user_id);
                Log::write('NOTICE', 'Update username success: ' . $this->user_info['email'], static::$method);
                $this->data['success'] = 'Update username success';
            } else {
                $this->data['error'] = 'Update username error';
            }
        } else {
            $this->data['errors'] = $val->error_message();
        }

        return $this->response($this->data);
    }

    public function post_update_email()
    {
        $val = Validation::forge();
        $val->add_callable('MyRules');
        $val->add_field('email', 'Email', 'required|valid_email|max_length[255]|unique_email');
        if ($val->run()) {
            $props = array(
                'email' => strtolower($val->validated('email'))
            );
            if (Model_Base_User::update($this->user_id, $props)) {
                Log::write('NOTICE', 'Update email success: ' . $this->user_info['email'], static::$method);
                $this->data['success'] = 'Update email success';
            } else {
                $this->data['error'] = 'Update email error';
            }
        } else {
            $this->data['errors'] = $val->error_message();
        }

        return $this->response($this->data);
    }

    public function post_update_info()
    {
        $val = Validation::forge();
        $val->add_callable('MyRules');
        $val->add_field('full_name', 'Full name', 'trim|max_length[255]');
        $val->add_field('gender', 'Gender', 'trim|valid_gender');
        $val->add_field('birthday', 'Birthday', 'trim|exact_length[10]');
        $val->add_field('telephone', 'Phone number', 'trim|valid_numeric|max_length[12]');
        $val->add_field('address', 'Address', 'trim|max_length[255]');
        if ($val->run()) {
            $props = array(
                'full_name' => Model_Service_Util::mb_trim($val->validated('full_name')),
                'gender' => $val->validated('gender'),
                'birthday' => $val->validated('birthday'),
                'telephone' => $val->validated('telephone'),
                'address' => Model_Service_Util::mb_trim($val->validated('address'))
            );
            if (Model_Base_User::update($this->user_id, $props)) {
                Log::write('NOTICE', 'Update info success: ' . $this->user_info['email'], static::$method);
                $this->data['success'] = 'Update info success';
            } else {
                $this->data['error'] = 'Update info error';
            }
        } else {
            $this->data['errors'] = $val->error_message();
        }

        return $this->response($this->data);
    }

    public function post_update_password()
    {
        $val = Validation::forge();
        $val->add_callable('MyRules');
        $val->add_field('password', 'Password', 'required|valid_password|min_length[8]|max_length[50]');
        $val->add_field('confirm_password', 'Confirm Password', 'match_field[password]');
        if ($val->run()) {
            $props = array(
                'password' => Model_Service_Util::hash_password($val->validated('password'))
            );
            if (Model_Base_User::update($this->user_id, $props)) {
                Log::write('NOTICE', 'Update password success: ' . $this->user_info['email'], static::$method);
                $this->data['success'] = 'Update password success';
            } else {
                $this->data['error'] = 'Update password error';
            }
        } else {
            $this->data['errors'] = $val->error_message();
        }

        return $this->response($this->data);
    }

    public function post_update_icon()
    {
        $props = array(
            'user_id' => $this->user_id,
            'user_photo' => $this->user_info['user_photo']
        );
        $upload = Model_Service_Upload::run('icon', $props);
        if (empty($upload['error'])) {
            $this->data['success'] = true;
            $this->data['msg'] = 'Change user icon success';
            $this->data['photo_name'] = $upload['photo_name'];
        } else {
            $this->data['error'] = $upload['error'];
        }

        return $this->response($this->data);
    }

}
