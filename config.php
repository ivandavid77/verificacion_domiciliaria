<?php
/*$config['db']['host'] = '172.16.201.40';
$config['db']['user'] = 'webverificacion';
$config['db']['password'] = 'webconsulta';
$config['db']['database'] = 'corporativo';*/
$config['db']['host'] = '172.16.202.15';
$config['db']['user'] = 'test';
$config['db']['password'] = '123456';
$config['db']['database'] = 'expediente';

$config['uploads']['varname'] = 'uploads';

$config['resize']['max_width'] = 200;
$config['resize']['max_height'] = 150;

$config['debug'] = true;

if ($config['debug']) {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}

return $config;
