<?php

use Fuel\Core\Config;
use Fuel\Core\Log;
use Fuel\Core\Date;
use Auth\Auth;

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

    public static function insert_user($data)
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

    public static function update_user($id, $data)
    {
        try {
            $user = Model_User::find($id);
            $user->set($data);
            $user->save();
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
            $user_config = self::get_app_config('user');
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
                'photo' => empty($user->user_photo) ? _PATH_NO_ICON_ : _PATH_ICON_ . $user->user_photo
            );
        }
        return false;
    }

    public static function get_app_config($name, $option = array())
    {
        $data = array();
        $config = Config::get('app.' . $name);
        foreach ($option as $key) {
            $data[$key] = $config[$key];
        }

        return !empty($option) ? $data : $config;
    }

    public static function valid_user_field($field, $val)
    {
        $result = Model_User::query()->where(array($field => $val));
        return ($result->count() > 0);
    }

}
