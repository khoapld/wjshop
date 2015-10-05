<?php

use Fuel\Core\Config;
use Fuel\Core\Upload;
use Fuel\Core\File;
use Fuel\Core\Image;

class Model_Service_Upload
{

    public static function run($type = null, $options = array())
    {
        $data = array();
        $photo_name = array();

        try {
            Upload::process();
        } catch (Exception $e) {
            $data['error'] = 'No file to upload';
            return $data;
        }
        if (Upload::is_valid()) {
            Upload::save();
        }
        foreach (Upload::get_errors() as $file) {
            $data['error'] = $file['errors']['0']['message'];
            return $data;
        }
        foreach (Upload::get_files() as $file) {
            $resize = self::resize_photo($file['saved_to'], $file['saved_as'], $type);
            $photo_name[] = $file['saved_as'];
        }
        if ($resize) {
            switch ($type) {
                case 'icon':
                    if (Model_Base_User::update_user($options['user_id'], array('user_photo' => $photo_name[0]))) {
                        $old_photo = $file['saved_to'] . $type . '/' . $options['user_photo'];
                        if (file_exists($old_photo)) {
                            File::delete($old_photo);
                        }
                        $data['photo_name'] = _PATH_ICON_ . $photo_name[0];
                    } else {
                        $data['error'] = 'Save icon to database error';
                    }
                    break;
                default:
                    $data['error'] = 'No type';
                    break;
            }
        } else {
            $data['error'] = 'System error';
        }

        return $data;
    }

    public static function resize_photo($path, $photo, $type = null)
    {
        $file = $path . $photo;
        if (file_exists($file)) {
            $rotate_number = self::exifRotation($file);
            $image_config = Config::get('app.image');
            if ($type == 'icon') {
                if (!is_dir($path . $type)) {
                    mkdir($path . $type, 0700);
                }
                @Image::load($path . $photo)
                        ->rotate($rotate_number)
                        ->resize($image_config[$type], $image_config[$type], false)
                        ->save($path . $type . '/' . $photo);
            } else {
//                foreach ($s3_config['versions'] as $version => $size) {
//                    if (!is_dir($path . $version)) {
//                        mkdir($path . $version, 0700);
//                    }
//                    @Image::load($path . $photo)
//                            ->rotate($rotate_number)
//                            ->resize($size, null, true)
//                            ->save($path . $version . '/' . $photo);
//                }
            }
            File::delete($path . $photo);

            return true;
        }

        return false;
    }

    public static function exifRotation($file)
    {
        $exif = @exif_read_data($file);
        if (!$exif) {
            return false;
        }
        $ort = @$exif['IFD0']['Orientation'];
        if (!$ort) {
            $ort = @$exif['Orientation'];
        }
        switch ($ort) {
            case 3: // image upside down
                return '180';
            case 6: // 90 rotate right & switch max sizes
                return '90';
            case 8: // 90 rotate left & switch max sizes
                return '-90';
            default:
                return '360';
        }
    }

}