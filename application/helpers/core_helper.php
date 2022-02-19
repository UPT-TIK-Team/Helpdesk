<?php

/**
 * Return string list of constant by prefix and value
 * if value is defined first constant with that value is returned, set to null if you don't want to search by value.
 * @param $prefix
 * @param null $valueToSearch
 * @return array
 */
function getConstantsByPrefix($prefix, $valueToSearch = null)
{
	$dump = [];
	foreach (get_defined_constants() as $key => $value)
		if (substr($key, 0, strlen($prefix)) == $prefix) {
			$dump[$key] = $value;
			if ($valueToSearch != null && $value == $valueToSearch)
				return $key;
		}
	return $dump;
}

/**
 * Escape any value for preventing XSS, Use this whereever you are echoing user input.
 * @param $string
 * @return string
 */
function escapeXSS($string)
{
	return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Use it inplace of echo, this sanitizes all inputs.
 * @param $value
 * @return bool
 */
function ticho($value)
{
	echo escapeXSS($value);
	return true;
}




/**
 * Tells if a given array is Associative or not.
 * @param array $array
 * @return bool
 */
function isAssoc(array $array)
{
	// Keys of the array
	$keys = array_keys($array);

	// If the array keys of the keys match the keys, then the array must
	// not be associative (e.g. the keys array looked like {0:0, 1:1...}).
	return array_keys($keys) !== $keys;
}


/**
 * Return item from array for a given key if not found $defVal is returned.
 * @param $item
 * @param $key
 * @param $defVal
 * @return mixed
 */
function getDefault($item, $key, $defVal)
{
	if (isset($item) && isset($item[$key]) && !empty($item[$key]))
		return $item[$key];
	return $defVal;
}


/**
 * Return only specified keys from array.
 * @param $arr
 * @param $keys
 * @param array $removeKeysWithValue
 * @return array
 */
function getValuesOfKeys($arr, $keys, $removeKeysWithValue = null)
{
	$ar = array();

	if (isAssoc($keys)) {
		foreach ($keys as $key => $val) {
			$v = (isset($arr[$key]) ? $arr[$key] : $val);
			if (!is_array($removeKeysWithValue) or !in_array($v, $removeKeysWithValue))
				$ar[$key] = $v;
		}
	} else {
		foreach ($keys as $key) {
			$v = (isset($arr[$key]) ? $arr[$key] : null);
			if (!is_array($removeKeysWithValue) or !in_array($v, $removeKeysWithValue))
				$ar[$key] = $v;
		}
	}

	return $ar;
}



/**
 * Handle unauthorized cases, it simply redirects user to a page with messages and few conditions.
 *
 * @param null $message string Message you want to show in frontend.
 * @param null $permissionLevels Array|string of permission number incase user doesn't has certain permission and we know which is required.
 */
function unauthorized($message = null, $permissionLevels = null)
{
	if ($permissionLevels !== null && is_int($permissionLevels))
		$permissionLevels = array($permissionLevels);


	redirect(
		URL_NO_PERMISSION . "?_=" . time() . "&from=" . urlencode($_SERVER['REQUEST_URI']) .
			($message !== null ? '&m=' . $message : '') .
			(is_array($permissionLevels) ? '&p=' . implode(';', $permissionLevels) : ''),
		'auto',
		302
	);
}

/**
 * Generate random password
 */
function generate_random_password()
{
	$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
	$pass = array(); //remember to declare $pass as an array
	$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
	for ($i = 0; $i < 8; $i++) {
		$n = rand(0, $alphaLength);
		$pass[] = $alphabet[$n];
	}
	return implode($pass); //turn the array into a string
}

/**
 * Function for send email via SMTP
 * @param Token 
 * @param Type
 * @return Bool 
 */
function sendEmail($type = '', $data = array())
{
	$CI = &get_instance();
	$CI->load->library('email');

	// Set config for sent email
	$config = [
		'protocol' => 'smtp',
		'smtp_host' => 'ssl://smtp.googlemail.com',
		'smtp_user' => getenv("EMAIL_ADDRESS"),
		'smtp_pass' => getenv("EMAIL_PASSWORD"),
		'smtp_port' => 465,
		'mailtype' => 'html',
		'charset' => 'utf-8',
		'newline' => "\r\n"
	];
	$CI->email->initialize($config);
	$CI->email->from(getenv("EMAIL_ADDRESS"), getenv("EMAIL_SUBJECT"));
	$CI->email->to($data['email']);

	// Switch type of email
	switch ($type) {
		case 'verify':
			$CI->email->subject('Account verification');
			$CI->email->message('Click this link to verify your account: <a href="' . base_url('auth/verify?email=') . $data['email'] . '&token=' . urlencode($data['token']) . '">Activate</a>');
			break;
		case 'forgotpassword':
			$CI->email->subject('Reset password');
			$CI->email->message('Click this link to reset your password: <a href="' . base_url('auth/resetpassword?email=') . $data['email'] . '&token=' . urlencode($data['token']) . '">Reset Password</a>');
			break;
		case 'new_ticket_message':
			$CI->email->subject('Information update for your ticket on Helpdesktik website');
			$CI->email->message('Click this link to view your ticket updates ' . base_url('tickets/view_ticket/') . $data['ticket_no'] . '?new_update=true');
			break;
	}

	if ($CI->email->send()) {
		// Return true if success send email
		return true;
	} else {
		echo $CI->email->print_debugger();
		die;
	}
}
