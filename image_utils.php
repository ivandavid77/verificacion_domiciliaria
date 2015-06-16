<?php
    // http://php.net/manual/en/function.imagecopyresampled.php
    function resize_image($filename, $max_w, $max_h, $to_file=null) {
        list($src_w, $src_h) = getimagesize($filename);
        $src_ratio = $src_w/$src_h;

        if ($max_w/$max_h > $src_ratio) {
            $max_h = $max_h*$src_ratio;
        } else {
           $max_h = $max_w/$src_ratio;
        }
        $image_p = imagecreatetruecolor($max_w, $max_h);
        $image = imagecreatefromjpeg($filename);
        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $max_w, $max_h,
                           $src_w, $src_h);
        if ($to_file === null) {
            ob_start();
            imagejpeg($image_p, null, 100);
            return ob_get_clean();
        } else {
            imagejpeg($image_p, $to_file, 100);
            return $to_file;
        }
    }
