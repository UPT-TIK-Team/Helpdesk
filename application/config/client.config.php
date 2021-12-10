<?PHP
defined('BASEPATH') or exit('No direct script access allowed');
include_once __DIR__ . "/constants.permissions.php";

//Root Url of ur site
define('BASE_URL', getenv('BASE_URL'));

define('PAGE_LOADER', BASE_URL . 'assets/img/loading.webp');

//Client Specific site wide information
define('CLIENT_FNAME', 'UPT TIK');
define('CLIENT_MNAME', 'UNSIKA');
define('CLIENT_FULL_NAME', 'UPT TIK UNSIKA');
define('CLIENT_ADDRESS', 'Fahmi, Faisal');
define('CLIENT_CONATCT_NO', '');
define('CLIENT_PINCODE', '');

//Client Specific site wide information
define('CLIENT_TICKET_PREFIX', 'TIK-UNSIKA-');
define('CLIENT_TICKET_ID_LENGTH', 6);

// Constants for selecting theme
define('CLIENT_SYSTEM_THEME', "custom.css");
//define('CLIENT_SYSTEM_THEME', "custom-flat.css");
