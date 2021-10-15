<?PHP

class Register extends MY_Controller
{
    public function __construct()
	{
		parent::__construct();
        $this->setHeaderFooter('auth/header.php', 'auth/footer.php');
        $this->load->model('core/Session_model', 'Session');
		$this->load->model('ticket/Threads_model', 'Tickets');
        $this->load->model('user/User_model', 'Users');
    }
    
    public function regis_user()
	{
		$this->render('Register User', 'user/regis_user');
	}
    
}