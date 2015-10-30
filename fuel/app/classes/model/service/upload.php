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
                    if (Model_Base_User::update($options['user_id'], array('user_photo' => $photo_name[0]))) {
                        $old_photo = $file['saved_to'] . $type . '/' . $options['user_photo'];
                        if (File::exists($old_photo)) {
                            File::delete($old_photo);
                        }
                        $data['photo_name'] = _PATH_ICON_ . $photo_name[0];
                    } else {
                        $data['error'] = 'Save icon to database error';
                    }
                    break;
                case 'category':
                    $old_photo = $options['type'] === 'new' ? : $file['saved_to'] . $type . '/' . Model_Category::find($options['category_id'])->category_photo;
                    if (Model_Base_Category::update($options['category_id'], array('category_photo' => $photo_name[0]))) {
                        if (File::exists($old_photo)) {
                            File::delete($old_photo);
                        }
                        $data['photo_name'] = _PATH_CATEGORY_ . $photo_name[0];
                    } else {
                        $data['error'] = 'Save category photo to database error';
                    }
                    break;
                case 'product':
                    $old_photo = $file['saved_to'] . $type . '/' . Model_Product::find($options['product_id'])->product_photo;
                    if (Model_Base_Product::update($options['product_id'], array('product_photo' => $photo_name[0]))) {
                        if (File::exists($old_photo)) {
                            File::delete($old_photo);
                        }
                        $data['photo_name'] = _PATH_PRODUCT_ . $photo_name[0];
                    } else {
                        $data['error'] = 'Save product photo to database error';
                    }
                    break;
                case 'photo':
                    if ($options['type'] === 'sub_product_photo') {
                        $photo_props = array(
                            'product_id' => $options['product_id'],
                            'photo_name' => $photo_name[0]
                        );
                        if ($photo_id = Model_Base_Photo::insert($photo_props)) {
                            $data['photo_id'] = $photo_id;
                            $data['photo_name'] = _PATH_PHOTO_ . $photo_name[0];
                        } else {
                            $data['error'] = 'Save sub product photo to database error';
                        }
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
        if (File::exists($file)) {
            $rotate_number = self::exifRotation($file);
            $image_config = Config::get('app.image');
            if (!is_dir($path . $type)) {
                mkdir($path . $type, 0755);
            }
            switch ($type) {
                case 'icon':
                    @Image::load($path . $photo)
                            ->rotate($rotate_number)
                            ->resize($image_config[$type], $image_config[$type], false)
                            ->save($path . $type . '/' . $photo);
                    break;
                case 'category':
                case 'product':
                    @Image::load($path . $photo)
                            ->rotate($rotate_number)
                            ->resize($image_config[$type], null, true)
                            ->save($path . $type . '/' . $photo);
                    break;
                case 'photo':
                    foreach ($image_config[$type] as $version => $size) {
                        if (!is_dir($path . $type . '/' . $version)) {
                            mkdir($path . $type . '/' . $version, 0700);
                        }
                        @Fuel\Core\Image::load($path . $photo)
                                ->rotate($rotate_number)
                                ->resize($size, null, true)
                                ->save($path . $type . '/' . $version . '/' . $photo);
                    }
                    break;
                default:
                    break;
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

    public static function delete_photo($type, $photo_name)
    {

        $image_config = Config::get('app.image');
        switch ($type) {
            case 'photo':
                $path = Config::get('app.path.root_photo');
                foreach ($image_config[$type] as $version => $size) {
                    if (File::exists($path . $version . '/' . $photo_name)) {
                        File::delete($path . $version . '/' . $photo_name);
                    }
                }
                break;
            default:
                break;
        }
    }

}
