<?php
$config['db']['host'] = '172.16.201.40';
$config['db']['user'] = 'webverificacion';
$config['db']['password'] = 'webconsulta';
//$config['db']['database'] = 'expediente';
$config['db']['database'] = 'corporativo';

$config['uploads']['uploads_dir'] = 'uploads';
$config['uploads']['varname'] = 'uploads';

$config['resize']['max_width'] = 1024;
$config['resize']['max_height'] = 1024;

$config['debug'] = true;

if ($config['debug']) {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}

return $config;
