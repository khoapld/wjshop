<?php

use Fuel\Core\DB;
use Fuel\Core\Config;
use Fuel\Core\Session;
use Fuel\Core\Log;
use Fuel\Core\Date;
use Auth\Auth;
use Auth\Auth_Opauth;

class Model_Base_User
{

    public static function is_login()
    {
        return (Auth::check());
    }

    public static function is_admin()
    {
        list(list(, $group_id)) = Auth::get_groups();
        return ($group_id == 100);
    }

    public static function user_login($username_or_email, $password, $is_remember = false)
    {
        if (Auth::instance()->login($username_or_email, $password)) {
            if ($is_remember) {
                Auth::remember_me();
            }
            return true;
        }
        return false;
    }

    public static function admin_login($username_or_email, $password)
    {
        if (Auth::instance()->login($username_or_email, $password)) {
            list(list(, $group_id)) = Auth::get_groups();
            if ($group_id == 100) {
                return true;
            }
        }
        return false;
    }

    public static function insert($data)
    {
        try {
            $props = [
                'username' => $data['username'],
                'email' => strtolower($data['email']),
                'password' => Model_Service_Util::hash_password($data['password']),
                'created_at' => date('Y-m-d H:i:s', Date::forge()->get_timestamp())
            ];

            $new = Model_User::forge($props);
            $new->save();
            return $new->id;
        } catch (Exception $e) {
            Log::write('ERROR', $e->getMessage());
            return false;
        }
    }

    public static function update($id, $data)
    {
        try {
            $data['updated_at'] = date('Y-m-d H:i:s', Date::forge()->get_timestamp());
            $query = Model_User::find($id);
            $query->set($data);
            $query->save();
        } catch (Exception $e) {
            Log::write('ERROR', $e->getMessage());
            return false;
        }

        return true;
    }

    public static function get_user_info($id)
    {
        $user = Model_User::find($id);
        if ($user) {
            $user_config = Model_Service_Util::get_app_config('user');
            return array(
                'username' => $user->username,
                'email' => $user->email,
                'group' => $user->group,
                'group_display' => $user_config['group'][$user->group],
                'full_name' => $user->full_name,
                'gender' => $user->gender,
                'gender_display' => $user_config['gender'][$user->gender],
                'birthday' => $user->birthday,
                'address' => $user->address,
                'telephone' => $user->telephone,
                'user_photo' => $user->user_photo,
                'user_photo_display' => empty($user->user_photo) ? _PATH_NO_ICON_ : _PATH_ICON_ . $user->user_photo
            );
        }

        return false;
    }

    public static function valid_field($field, $val)
    {
        $result = Model_User::query()->where(array($field => $val));
        return ($result->count() > 0);
    }

    public static function get_user_id_by_fb_uid()
    {
        if ($authentication = Session::get('auth-strategy.authentication', [])) {
            $query = Model_UserProvider::query()->where(array('uid' => $authentication['uid'], 'provider' => $authentication['provider']));
            return $query->count() > 0 ? $query->get_one()->user_id : false;
        }

        return false;
    }

    public static function check_user_provider()
    {
        if ($authentication = Session::get('auth-strategy.authentication', [])) {
            $query = Model_UserProvider::query()->where(array('uid' => $authentication['uid'], 'provider' => $authentication['provider']));
            return ($query->count() > 0);
        }

        return false;
    }

    public static function link_provider($user_id)
    {
        if ($authentication = Session::get('auth-strategy.authentication', [])) {
            $opauth = Auth_Opauth::forge(false);
            $insert_id = $opauth->link_provider([
                'parent_id' => $user_id,
                'provider' => $authentication['provider'],
                'uid' => $authentication['uid'],
                'access_token' => $authentication['access_token'],
                'secret' => $authentication['secret'],
                'refresh_token' => $authentication['refresh_token'],
                'expires' => $authentication['expires'],
                'created_at' => date('Y-m-d H:i:s', Date::forge()->get_timestamp())
            ]);
        }
    }

    public static function get_user_fb($parent_id)
    {
        $query = Model_UserProvider::query()->where(array('parent_id' => $parent_id));
        if ($query->count() > 0) {
            $user_fb = $query->get_one();
            return array(
                'parent_id' => $user_fb->parent_id,
                'provider' => $user_fb->provider,
                'uid' => $user_fb->uid,
                'access_token' => $user_fb->access_token,
                'expires' => $user_fb->expires
            );
        }

        return false;
    }

    public static function delete_user_provider($parent_id)
    {
        try {
            DB::delete('user_providers')->where('parent_id', '=', $parent_id)->execute();
        } catch (Exception $e) {
            Log::write('ERROR', $e->getMessage());
            return false;
        }

        return true;
    }

}
