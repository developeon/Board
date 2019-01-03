 <?php
class custom404 extends CI_Controller
{
	public function __construct()
	{
	        parent::__construct();
	}
 
	public function index()
	{
		echo "404 error";
		exit;
	}
}
?>