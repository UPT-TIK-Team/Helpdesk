<?PHP
//Developer Information
//All product and developer related information.
define('DEV_COMPANY_NAME', 'UNSIKA');
define('DEV_COMPANY_EMAIL', '');
define('DEV_COMPANY_PHONE', '');
define('DEV_COMPANY_SUPPORT_EMAIL', '');
define('DEV_COMPANY_URL', 'https://upttik.unsika.ac.id/');
define('DEV_COMPANY_LOGO', 'https://upttik.unsika.ac.id/wp-content/uploads/2020/08/tikupt.png');

/**
 * Product related information
 */
define('PRODUCT_NAME', 'UPT TIK HELPDESK');
define('PRODUCT_LOGO', 'https://upttik.unsika.ac.id/wp-content/uploads/2020/08/tikupt.png');

/**
 * Global Settings
 */
# Products global settings
define('SETTING_UPLOAD_DIR', '/uploads/');
define('SETTING_UPLOAD_PATH', FCPATH . "/uploads/");
define('SETTING_PROFILE_DIR', '/uploads/profiles/');
define('SETTING_PROFILE_PATH', FCPATH . SETTING_PROFILE_DIR);



/**
 * Dynamic Constants
 */
define('BRAND_NAME', '<span style="color: #FFF;">' . CLIENT_FNAME . '  </span><span class="text-danger">' . CLIENT_MNAME . ' </span>');
define('CLIENT_NAME', CLIENT_FNAME . ' ' . CLIENT_MNAME);
define('CLIENT_LOGO', SETTING_UPLOAD_DIR . '/logo.png');
define('CLIENT_LOGO_INVERSE', SETTING_UPLOAD_DIR . '/logo-inverse.png');


/**
 * URL's
 */
define('URL_LANDING', BASE_URL . 'auth/login');
define('URL_UNAUTHORIZED', BASE_URL . 'auth/login');
define('URL_NO_PERMISSION', BASE_URL . 'auth/unauthorized');
define('URL_ERROR', BASE_URL . 'auth/error');
define('URL_LOGIN', BASE_URL . 'auth/login');
define('URL_POST_LOGIN_USER', BASE_URL . 'user/dashboard');
define('URL_POST_LOGIN_AGENT', BASE_URL . 'user/dashboard');
define('URL_POST_LOGIN_MANAGER', BASE_URL . 'user/dashboard');
define('URL_POST_LOGIN_ADMIN', BASE_URL . 'user/dashboard');
define('URL_POST_LOGIN_LIMITED', BASE_URL . 'user/dashboard');

define('URL_REGISTER', BASE_URL . '/auth/register');
