<?php

namespace Fuel\Tasks;

use Fuel\Core\Config;
use Fuel\Core\Log;
use Fuel\Core\Uri;

class Tool
{

    public static function feed_fb($token, $data)
    {
        $data = json_decode(base64_decode($data));
        if (!empty($data->id)) {
            if (!defined('_PATH_PRODUCT_')) {
                define('_PATH_PRODUCT_', Config::get('base_url') . Config::get('app.path.product'));
            }
            $product = \Model_Base_Product::get_one($data->id);
            $tmp = "\r\n\r\n--------------------------------------------------\r\n\r\n";
            $message = $product['product_name'] . $tmp . $product['product_description'] . $tmp . $product['product_info'];
            $groups = \Model_Base_GroupFb::get_all();
            foreach ($groups as $group) {
                try {
                    \OpauthStrategy::serverPost(
                        'https://graph.facebook.com/v2.5/' . $group['group_id'] . '/feed', array(
                        'access_token' => $token,
                        'message' => strip_tags(html_entity_decode($message, ENT_QUOTES)),
                        'link' => Uri::create('/product/' . $product['code']),
                        'caption' => 'WJ-SHOP',
                        'name' => html_entity_decode($product['product_name'], ENT_QUOTES),
                        'description' => html_entity_decode($product['product_description'], ENT_QUOTES),
                        'picture' => _PATH_PRODUCT_ . $product['product_photo'],
                        ), null, $headers);
                } catch (\Exception $e) {
                    Log::error($e->getMessage());
                }
                sleep(3);
            }
        } elseif (!empty($data->message) && !empty($data->link)) {
            $groups = \Model_Base_GroupFb::get_all();
            foreach ($groups as $group) {
                try {
                    \OpauthStrategy::serverPost(
                        'https://graph.facebook.com/v2.5/' . $group['group_id'] . '/feed', array(
                        'access_token' => $token,
                        'message' => html_entity_decode($data->message, ENT_QUOTES),
                        'link' => $data->link
                        ), null, $headers);
                } catch (\Exception $e) {
                    Log::error($e->getMessage());
                }
                sleep(3);
            }
        }
    }

}
