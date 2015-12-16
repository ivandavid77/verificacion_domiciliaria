<?php
$config['db_expediente']['host'] = '172.16.200.23';
$config['db_expediente']['user'] = 'verificador';
$config['db_expediente']['password'] = 'verificador';
$config['db_expediente']['database'] = 'expediente';

$config['db_corporativo']['host'] = '172.16.200.3';
$config['db_corporativo']['user'] = 'verificador';
$config['db_corporativo']['password'] = 'verificador';
$config['db_corporativo']['database'] = 'corporativo';

$config['resize']['max_width'] = 800;
$config['resize']['max_height'] = 450;

$config['session_timeout_duration'] = 900;

$config['debug'] = true;

if ($config['debug']) {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}

return $config;
