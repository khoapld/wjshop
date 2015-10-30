<?php

use Fuel\Core\View;
use Fuel\Core\Response;
use Fuel\Core\Validation;
use Fuel\Core\Session;
use Auth\Auth_Opauth;

class Controller_Admin_Facebook extends Controller_Base_Admin
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

    public function action_login($provider = null)
    {
        if ($provider === null) {
            Response::redirect_back();
        }
        try {
            Auth_Opauth::forge();
        } catch (Exception $e) {
            Response::redirect_back();
        }
    }

    public function action_callback()
    {
        try {
            $opauth = Auth_Opauth::forge(false);
            $opauth->login_or_register();
            Response::redirect('/admin/facebook');
        } catch (\OpauthException $e) {
            Response::redirect('/admin');
        } catch (\OpauthCancelException $e) {
            Response::redirect('/admin');
        }
    }

    public function action_index()
    {
        $this->data['is_login_fb'] = !empty($this->user_fb) && ($this->user_fb['expires'] > (time() + 172800)) ? false : true;
        $this->data['group'] = Model_Base_GroupFb::get_all();
        $this->template->title = 'Facebook Page';
        $this->template->content = View::forge($this->layout . '/facebook/index', $this->data);
    }

    public function post_feed()
    {
        $val = Validation::forge();
        $val->add_callable('MyRules');
        $val->add_field('message', 'Message', 'required|max_length[10000]');
        $val->add_field('link', 'Link', 'required|valid_url');
        if ($val->run()) {
            $props = array(
                'message' => $val->validated('message'),
                'link' => $val->validated('link')
            );
            Model_Service_Facebook::feed_fb($this->user_fb['access_token'], $props);
            $this->data['success'] = 'Feed FB success';
        } else {
            $this->data['errors'] = $val->error_message();
        }

        return $this->response($this->data);
    }

    public function post_feed_product()
    {
        $val = Validation::forge();
        $val->add_callable('MyRules');
        $val->add_field('id', 'Product', 'required|valid_product');
        if ($val->run()) {
            $props = array('id' => $val->validated('id'));
            Model_Service_Facebook::feed_fb($this->user_fb['access_token'], $props);
            $this->data['success'] = 'Feed FB success';
        } else {
            $this->data['error'] = $val->error_message('id');
        }

        return $this->response($this->data);
    }

    public function post_add_group()
    {
        $val = Validation::forge();
        $val->add_callable('MyRules');
        $val->add_field('group', 'Group', 'required');
        if ($val->run()) {
            $group = $val->validated('group');
            $group_data = $this->check_group_id($group);
            if (!empty($group_data)) {
                if (Model_Base_GroupFb::valid_field('group_id', $group_data->id)) {
                    $this->data['error'] = 'This group is exist';
                } else {
                    $group_props = array(
                        'group_id' => $group_data->id,
                        'group_name' => $group_data->name,
                        'privacy' => $group_data->privacy
                    );
                    if ($id = Model_Base_GroupFb::insert($group_props)) {
                        $this->data['success'] = 'Add group fb success';
                        $this->data['group'] = array(
                            'id' => $id,
                            'name' => $group_data->name
                        );
                    } else {
                        $this->data['error'] = 'This group is exist';
                    }
                }
            } else {
                $this->data['error'] = 'Add group fb error';
            }
        } else {
            $this->data['errors'] = $val->error_message();
        }

        return $this->response($this->data);
    }

    public function post_check_group()
    {
        $val = Validation::forge();
        $val->add_callable('MyRules');
        $val->add_field('group', 'Group', 'required');
        if ($val->run()) {
            $group = $val->validated('group');
            $group_data = $this->check_group_name($group);
            if (!empty($group_data)) {
                foreach ($group_data as $k => $v) {
                    $this->data['group'][$k]['value'] = $v->id;
                    $this->data['group'][$k]['label'] = $v->name;
                }
                $this->data['success'] = true;
            }
        }

        return $this->response($this->data);
    }

    public function post_delete_group()
    {
        $val = Validation::forge();
        $val->add_callable('MyRules');
        $val->add_field('group', 'Group FB', 'required|valid_group_fb');
        if ($val->run()) {
            $id = $val->validated('group');
            if (Model_Base_GroupFb::delete($id)) {
                $this->data['success'] = true;
            }
        } else {
            $this->data['errors'] = $val->error_message();
        }

        return $this->response($this->data);
    }

    private function check_group_id($group_id)
    {
        if (!empty($this->user_fb['access_token'])) {
            try {
                $data = OpauthStrategy::serverGet('https://graph.facebook.com/v2.5/' . $group_id, array('access_token' => $this->user_fb['access_token']), null, $headers);
                if (!empty($data)) {
                    $group = json_decode($data);
                    return !empty($group->id) ? $group : false;
                }
            } catch (Exception $e) {
                //
            }
        }

        return false;
    }

    private function check_group_name($group_name)
    {
        if (!empty($this->user_fb['access_token'])) {
            try {
                $data = OpauthStrategy::serverGet('https://graph.facebook.com/v2.5/search', array('access_token' => $this->user_fb['access_token'], 'q' => html_entity_decode($group_name, ENT_QUOTES), 'type' => 'group'), null, $headers);
                if (!empty($data)) {
                    $group = json_decode($data);
                    return !empty($group->data[0]->id) ? $group->data : false;
                }
            } catch (Exception $e) {
                //
            }
        }

        return false;
    }

    private function fb_get_me($access_token = null)
    {
        if (!empty($access_token)) {
            try {
                $me = OpauthStrategy::serverGet('https://graph.facebook.com/me', array('access_token' => $access_token, 'locale' => 'ja_JP'), null, $headers);
                if (!empty($me)) {
                    $me_info = json_decode($me);
                    if (!empty($me_info->last_name))
                        Session::set('auth-strategy.user.last_name', $me_info->last_name);
                    if (!empty($me_info->first_name))
                        Session::set('auth-strategy.user.first_name', $me_info->first_name);
                }
            } catch (Exception $e) {
                //
            }
        } else {
            Response::redirect('/user/facebook');
        }
    }

}
