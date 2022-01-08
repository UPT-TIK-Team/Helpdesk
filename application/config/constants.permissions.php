<?PHP
# START OF DYNAMIC CONFIG # DONOT REMOVE OR CHANGE THIS LINE

#
# Users
#

# Can add a user
define('PERMISSION_USER_REGISTER', 3001);
# Can list all users
define('PERMISSION_USER_LIST', 3002);
# Can delete a user
define('PERMISSION_USER_DELETE', 3003);
# Can update user profile
define('PERMISSION_USER_UPDATE', 3004);
# Can see user dashboard
define('PERMISSION_USER_DASHBOARD', 3005);
# Can register from public
define('PERMISSION_AUTH_REGISTER', 3006);
# Can login using login form
define('PERMISSION_AUTH_LOGIN', 3007);


# END OF DYNAMIC CONFIG # DONOT REMOVE OR CHANGE THIS LINE

/**
 * This can be moved to client.config
 */
// Define different users and their numeric identifiers.
# Public user, it should be present in all cases, this refers to
define("USER_PUBLIC", 0);
# Limited user for donation mudule to donate
define("USER_LIMITED", 5);
# Deactivated user for donation mudule when he completes his 7 activate members
define("USER_DEACTIVATED", 6);
# Any normal user
define("USER_MEMBER", 10);
# Members of Resolution Team/Developer/Agent
define("USER_AGENT", 60);
# Managerial person
define("USER_MANAGER", 80);
# User with elevated permissions.
define("USER_ADMIN", 100);

/**
 * Array of all user permissions.
 */
define(
	"DEFAULT_PERMISSIONS_USERS",
	array(
		USER_PUBLIC => array(
			PERMISSION_AUTH_REGISTER => true,
			PERMISSION_AUTH_LOGIN => true,
		),
		USER_MEMBER => array(
			PERMISSION_USER_UPDATE => true,
			PERMISSION_AUTH_REGISTER => true,
			PERMISSION_USER_DASHBOARD => true,
			PERMISSION_AUTH_LOGIN => true
		),
		USER_AGENT => array(
			PERMISSION_USER_UPDATE => true,
			PERMISSION_AUTH_REGISTER => true,
			PERMISSION_USER_DASHBOARD => true,
			PERMISSION_AUTH_LOGIN => true
		),
		USER_MANAGER => array(
			PERMISSION_USER_REGISTER => true,
			PERMISSION_USER_LIST => true,
			PERMISSION_USER_UPDATE => true,
			PERMISSION_AUTH_LOGIN => true,
			PERMISSION_AUTH_REGISTER => true,
		),
		USER_ADMIN => array(
			PERMISSION_USER_REGISTER => true,
			PERMISSION_USER_LIST => true,
			PERMISSION_USER_UPDATE => true,
			PERMISSION_AUTH_LOGIN => true,
			PERMISSION_AUTH_REGISTER => true,
		),
		USER_DEACTIVATED => array(
			PERMISSION_AUTH_LOGIN => true,
			PERMISSION_AUTH_REGISTER => false,
			PERMISSION_USER_DASHBOARD => false
		)
	)
);
