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
			return "User not found";
		} else if (password_verify($password, $user['password']) && $user['status'] == USER_STATUS_ACTIVE) {
			return $user;
		} else if (password_verify($password, $user['password']) && $user['type'] === USER_AGENT) {
			return $user;
		} else if (!password_verify($password, $user['password'])) {
			return "Wrong password";
		} else {
			return "Check your email to activate your account!";
		}
	}

	public function generatePasswordResetLink($username, $token)
	{
		$url = BASE_URL . "auth/reset_password?username=$username&token=$token";
		return $url;
	}

	public function verifyPasswordResetLink($username, $token)
	{
		$user = $this->User->getUsersBy(null, array('username' => $username));
		if (count($user) < 1)
			return false;

		$user = $user[0];
		$result = $this->Session->verifyToken($user['username'], $token);
		if (!$result)
			return false;
		$newPassword = $this->generateRandomPassword(6);
		return $newPassword;
	}

	public function generateRandomPassword($n)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@$^#';
		$randomString = '';

		for ($i = 0; $i < $n; $i++) {
			$index = rand(0, strlen($characters) - 1);
			$randomString .= $characters[$index];
		}
		return $randomString;
	}


	public function setRandomPassword($username)
	{
		$random_password = $this->generateRandomPassword(8);
		$res = $this->user->update_user($username, array('password' => md5($random_password)));
		$user = $this->User->get_user_details($username);
		if ($res) {
			$body = 'Hi ' . $username . ', You recently requested a password reset. Your new password is' . $random_password;
			return $res;
		}
	}
}
