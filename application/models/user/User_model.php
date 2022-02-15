<?PHP

require_once __DIR__ . "/constants.php";

class User_model extends BaseMySQL_model
{
	public static $CHANGE_PASSWORD_MSG = array(
		1 => 'Successfully changed password.',
		0 => 'There was some error creating your account! Please try again later.',
		-1 => 'Incorrect old password',

	);

	public function __construct()
	{
		parent::__construct(TABLE_USER);
	}

	/**
	 * Get a user's details by different fields
	 * @param $fields
	 * @return mixed
	 */
	public function getUserBy($fields)
	{
		return self::getOneItem(self::getBy(null, $fields, null, true));
	}

	public function getUserCreatedDate($uid)
	{
		$return = $this->db->select('created')
			->where('id', $uid)
			->get(TABLE_USER)->result_array();
		return $return[0]['created'];
		// print_r($return);
	}

	public function update($uId, $update)
	{
		$result = parent::setByID($uId, $update);
		return $result;
	}

	public function findUserDetailsByPrimary($fields, $text)
	{
		return $this->db->select($fields)->or_where(array('username' => $text, 'mobile' => $text, 'email' => $text))->limit(1)->get(TABLE_USER)->result_array();
	}

	public function getUsersBy($field = null, $value = null)
	{
		return $this->db->get_where($field, $value)->row_array();
	}


	public function getUserDetails($uid, $fields = null)
	{
		return parent::getByID($uid, $fields);
	}

	public function uploadProfilePicture($uId, $file, $orig_name)
	{
		if ($orig_name) {
			$config['upload_path'] = SETTING_PROFILE_PATH;
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size'] = 2048;
			$config['encrypt_name'] = false;
			$config['overwrite'] = true;

			// new name with uid and extensions
			$config['file_name'] = $uId . '.png';

			if (!is_dir($config['upload_path'])) {
				mkdir($config['upload_path'], 0777, TRUE);
			}

			$this->load->library('upload', $config);

			if (!$this->upload->do_upload($file)) {
				$error = array('error' => $this->upload->display_errors());
				return $error;
			} else {
				$data = $this->upload->data();
				return $config['upload_path'] . $data['file_name'];
			}
		}
	}

	public function updateProfile($info, $files, $allow_specific_edits, $uid = null)
	{
		$fields = array('gender', 'city', 'state', 'dob', 'address', 'meta');
		$specific_edits = array('name', 'father', 'mobile', 'email');
		if ($allow_specific_edits)
			$fields = array_merge($fields, $specific_edits);

		$member = getValuesOfKeys($info, $fields);
		$member['meta'] = 'AltMob:' . $info['mobile2'];
		if ($files)
			$this->uploadProfilePicture($uid, 'profile', $files['profile']['name']);
		if (!$uid)
			$uid = $this->Session->getLoggedUsername();
		$result = parent::setByID($uid, $member);
		return $result;
	}

	public function getUserByUsernameAndUid($username, $uid)
	{
		return  $this->db->get_where('users', ['username' => $username, 'id' => $uid])->row();
	}

	public function getWhereFieldIn($select, $field, $where_in)
	{
		if ($select == null) $select = "*";
		$query = $this->db->select($select);
		if (!empty($where_in)) {
			$query = $query->or_where_in($field, $where_in);
		}
		return $query->get(TABLE_USER)->result_array();
	}

	public function getBy($select = null, $where = null, $limit = null, $array = false)
	{
		return parent::getBy($select, $where, $limit, $array);
	}
}
