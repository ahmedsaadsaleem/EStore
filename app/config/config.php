<?php

if(!defined('DS')){
    define('DS', DIRECTORY_SEPARATOR);
}

define('APP_PATH', realpath(dirname(__FILE__)) . DS . '..');
define('VIEWS_PATH', APP_PATH . DS . 'views' . DS);
define('TEMPLATE_PATH', APP_PATH . DS . 'template' . DS);
define('LANGUAGES_PATH', APP_PATH . DS . 'languages' . DS);

define('CSS', DS . 'css' . DS);
define('JS', DS . 'js' . DS);

// Database Credentails
defined('DATABASE_HOST_NAME')       ? null : define('DATABASE_HOST_NAME', 'localhost');
defined('DATABASE_USER_NAME')       ? null : define('DATABASE_USER_NAME', 'root');
defined('DATABASE_PASSWORD')        ? null : define('DATABASE_PASSWORD', '123456789');
defined('DATABASE_DB_NAME')         ? null : define('DATABASE_DB_NAME', 'storedb');
defined('DATABASE_PORT_NUMBER')     ? null : define('DATABASE_PORT_NUMBERE', 3307);
defined('DATABASE_CONN_DRIVER')     ? null : define('DATABASE_CONN_DRIVER', 1);

// Default appliction Language
defined('APP_DEFAULT_LANGUAGE')     ? null : define('APP_DEFAULT_LANGUAGE', 'ar');

// Session configrations
defined('SESSION_NAME')             ? null : define('SESSION_NAME', '_ESTORE_SESSION');
defined('SESSION_LIFE_TIME')        ? null : define('SESSION_LIFE_TIME', 0);
defined('SESSION_SAVE_PATH')        ? null : define('SESSION_SAVE_PATH', APP_PATH . DS . '..' . DS . 'sessions');

// App Salt
defined('APP_SALT')                 ? null : define('APP_SALT', '$2a$07$Odiz44NzIba8UCsEV71G3Z$');

// Check for access privileges
defined('CHECK_FOR_PRIVILEGES')     ? null : define('CHECK_FOR_PRIVILEGES', 1);

// Define the path of our files uploaded
defined('UPLOAD_STORAGE')           ? null : define('UPLOAD_STORAGE', APP_PATH . DS . '..' . DS . 'public' . DS . 'uploads');
defined('IMAGES_UPLOAD_STORAGE')    ? null : define('IMAGES_UPLOAD_STORAGE', UPLOAD_STORAGE . DS . 'images');
defined('DOCUMENTS_UPLOAD_STORAGE') ? null : define('DOCUMENTS_UPLOAD_STORAGE', UPLOAD_STORAGE . DS . 'documents');
// Max file size allowed to upload
defined('MAX_FILE_SIZE_ALLOWED') ? null : define('MAX_FILE_SIZE_ALLOWED', ini_get('upload_max_filesize'));
