<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    require_once('../image_utils.php');
    $source = dirname(__FILE__).'/test_image_source.jpg';
    $target = dirname(__FILE__).'/test_image_target.jpg';
    resize_image($source, 200, 150, $target);
    //header('Location: test_image_target.jpg');
