<?php
return array (
  'session' => 
  array (
    'value' => 
    array (
      'mode' => 'default',
    ),
    'readonly' => true,
  ),
  'utf_mode' => 
  array (
    'value' => true,
    'readonly' => true,
  ),
  'cache_flags' => 
  array (
    'value' => 
    array (
      'config_options' => 3600,
      'site_domain' => 3600,
    ),
    'readonly' => false,
  ),
  'cookies' => 
  array (
    'value' => 
    array (
      'secure' => false,
      'http_only' => true,
    ),
    'readonly' => false,
  ),
  'exception_handling' => 
  array (
    'value' => 
    array (
      'debug' => true,
      'handled_errors_types' => 4437,
      'exception_errors_types' => 4437,
      'ignore_silence' => false,
      'assertion_throws_exception' => true,
      'assertion_error_type' => 256,
      'log' => NULL,
    ),
    'readonly' => false,
  ),
  'connections' => 
  array (
    'value' => 
    array (
      'default' => 
      array (
        'className' => '\\Bitrix\\Main\\DB\\MysqliConnection',
        'host' => 'localhost',
        'database' => 'prod',
        'login' => 'prod',
        'password' => 'U0i3N5q5',
        'options' => 2,
      ),
    ),
    'readonly' => true,
  ),
  'cache' => 
  array (
    'value' => 
    array (
      'type' => 
      array (
        'class_name' => 'CPHPCacheMemcacheCluster',
        'extension' => 'memcache',
        'required_file' => 'modules/cluster/classes/general/memcache_cache.php',
      ),
    ),
    'readonly' => false,
  ),
);
