<?php

use Fuel\Core\Str;

class MyRules
{

    public static function _empty($val)
    {
        return ($val === false or $val === null or $val === '' or $val === []);
    }

    public static function _validation_required($val)
    {
        return !self::_empty($val);
    }

    public static function _validation_valid_numeric($val)
    {
        if (self::_empty($val)) {
            return true;
        }
        $pattern = '/^([0-9])+$/';
        return preg_match($pattern, $val) > 0;
    }

    public static function _validation_valid_username($val)
    {
        if (self::_empty($val)) {
            return true;
        }
        $pattern = '/^([a-z0-9])+$/u';
        return (preg_match($pattern, $val) > 0);
    }

    public static function _validation_unique_username($val)
    {
        return !Model_Base_User::valid_field('username', $val);
    }

    public static function _validation_unique_email($val)
    {
        return !Model_Base_User::valid_field('email', $val);
    }

    public static function _validation_valid_password($val)
    {
        if (self::_empty($val)) {
            return true;
        }
        $pattern = '/^([a-zA-Z0-9])+$/u';
        return preg_match($pattern, $val) > 0;
    }

    public static function _validation_valid_gender($val)
    {
        if (self::_empty($val)) {
            return true;
        }
        $_config = Model_Service_Util::get_app_config('user', array('gender'));
        return array_key_exists($val, $_config['gender']);
    }

    public static function _validation_valid_group($val)
    {
        if (self::_empty($val)) {
            return true;
        }
        $_config = Model_Service_Util::get_app_config('user', array('group'));
        return array_key_exists($val, $_config['group']);
    }

    public static function _validation_valid_category($val)
    {
        if (self::_empty($val)) {
            return true;
        }
        return Model_Base_Category::valid_field('id', $val);
    }

    public static function _validation_valid_category_status($val)
    {
        if (self::_empty($val)) {
            return true;
        }
        $_config = Model_Service_Util::get_app_config('category', array('status'));
        return array_key_exists($val, $_config['status']);
    }

    public static function _validation_valid_product($val)
    {
        if (self::_empty($val)) {
            return true;
        }
        return Model_Base_Product::valid_field('id', $val);
    }

    public static function _validation_valid_product_status($val)
    {
        if (self::_empty($val)) {
            return true;
        }
        $_config = Model_Service_Util::get_app_config('product', array('status'));
        return array_key_exists($val, $_config['status']);
    }

    public static function _validation_valid_product_highlight($val)
    {
        if (self::_empty($val)) {
            return true;
        }
        $_config = Model_Service_Util::get_app_config('product', array('highlight'));
        return array_key_exists($val, $_config['highlight']);
    }

    public static function _validation_valid_photo($val)
    {
        if (self::_empty($val)) {
            return true;
        }
        return Model_Base_Photo::valid_field('id', $val);
    }

//    public static function _validation_required($val)
//    {
//        $val = Model_Service_Util::mb_trim($val);
//        return !Model_Service_Util::_empty($val);
//    }
//
//
//    public static function _validation_max_length($val, $length)
//    {
//        $val = preg_replace('/\r\n/', ' ', $val);
//        $val = html_entity_decode($val, ENT_QUOTES);
//        return Model_Service_Util::_empty($val) || Str::length($val) <= $length;
//    }
//
//    public static function _validation_unique_email($val)
//    {
//        return !Model_Base_User::valid_email($val);
//    }
//
//
//    public static function _validation_input_notcontain_email($val)
//    {
//        $matches = array();
//        $pattern = '/[A-Za-z0-9_-]+@[A-Za-z0-9_-]+\.([A-Za-z0-9_-][A-Za-z0-9_]+)/';
//        preg_match($pattern, $val, $matches);
//        if (!empty($matches) && count($matches) > 0) {
//            return false;
//        } else {
//            return true;
//        }
//    }
}
