<?PHP
define("TABLE_USER", TABLE_PREFIX . "users");
define("TABLE_GRAPHS", TABLE_PREFIX . "graph");
define("LOGIN_TABLE", TABLE_PREFIX . "login");
define("LOGIN_FIELD", "username");
define("TABLE_USER_DETAILS", TABLE_PREFIX . "users_details");
define("TABLE_KYC", TABLE_PREFIX . "kyc");
define("TABLE_LOCATIONS", TABLE_PREFIX . "locations");
define("TABLE_RANKS", TABLE_PREFIX . "ranks");
define("TABLE_BANKS", TABLE_PREFIX . "banks");
define("TABLE_BANK_DETAILS", TABLE_PREFIX. "bank_details");

# Gender Types
const GENDER_TYPE = array(
	0 => 'Male',
	1 => 'Female',
	2 => 'Other'
);

define('USER_STATUS_ACTIVE', 1);
define('USER_STATUS_INACTIVE', 0);

define("TIKTABLE_LIST_USERS_ALL", 0);
define("TIKTABLE_LIST_MEMBERS_ACTIVE", 0);
