<?PHP

require_once __DIR__ . "/User_model.php";
require_once __DIR__ . "/constants.php";
require_once __DIR__ . "/../core/Session_model.php";


class Auth_model extends BaseMySQL_model
{
	public function __construct()
	{
		parent::__construct(TABLE_USER);
		$this->User = new User_model();
		$this->Session = new Session_model();

		$this->type_forgot = "forgot_password";
	}

	public function login($data)
	{
		$email = trim($data['email']);
		$password = $data['password'];
		$user = $this->User->getBy(null, ['email' => $email]);

		// Check for user details and send spesific error message
		if (!$user) {
			return "Pengguna tidak ditemukan";
		} else if (password_verify($password, $user['password']) && $user['status'] == USER_STATUS_ACTIVE) {
			return $user;
		} else if (password_verify($password, $user['password']) && (int)$user['type'] === USER_AGENT) {
			return $user;
		} else if (!password_verify($password, $user['password'])) {
			return "Password salah";
		}
	}

	public function generatePasswordResetLink($username, $token)
	{
		$url = BASE_URL . "auth/reset_password?username=$username&token=$token";
		return $url;
	}
}
