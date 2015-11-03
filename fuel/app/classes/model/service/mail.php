<?php

use Fuel\Core\Fuel;
use Fuel\Core\Config;
use Fuel\Core\Log;
use Fuel\Core\View;
use Email\Email;

class Model_Service_Mail
{

    public static function send($option = null)
    {
        try {
            $email = Email::forge();
            $email->from(
                Config::get('email.defaults.from.email'), Config::get('email.defaults.from.name')
            );

            $to = $option->to;
            if (is_string($to)) {
                $email->to($to);
            } elseif (is_array($to)) {
                $email->to(Config::get('email.defaults.from.email'), Config::get('email.defaults.from.name'));
                $email->bcc($to);
            }

            $email->subject(html_entity_decode($option->subject, ENT_QUOTES));

            if (!empty($option->attach)) {
                $email->attach(DOCROOT . $option->attach);
            }

            $email->html_body(View::forge('email/' . $option->view, $option->content));

            $email->send();
        } catch (\EmailSendingFailedException $e) {
            Log::write('ERROR', $e->getMessage(), 'Send_email');
            return false;
        } catch (\EmailValidationFailedException $e) {
            Log::write('ERROR', $e->getMessage(), 'Validation_email');
            return false;
        } catch (Exception $e) {
            Log::write('ERROR', $e->getMessage(), 'Exception');
            return false;
        }

        return true;
    }

    public static function send_mail($option = null)
    {
        $option = base64_encode(json_encode($option));
        $oil_path = str_replace('\\', '/', realpath(APPPATH . '/../../'));
        $command = "php $oil_path/oil r tool:send_mail '$option' ";
        try {
            exec($command);
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        return true;
    }

}
