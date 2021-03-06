<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* @author   zhangji
* @desc     登陆
*/

class Login extends CI_Controller
{
    private $data;

    private $objUserModel;

    function __construct()
    {
        parent::__construct();

        $this->data = array();

        $this->load->model('user_model');
        $this->objUserModel = new user_model;
    }

    public function index()
    {
        if (!empty($_POST)) {
            $this->form();
        }
        else {
            $this->load->view('login', $this->data);
        }
    }

    private function form()
    {
        $said  = isset($_POST['said'])     ? $_POST['said']     : '';
        $email = isset($_POST['email'])    ? $_POST['email']    : '';
        $pwd   = isset($_POST['password']) ? $_POST['password'] : '';

        switch ($said) {
            //管理员登陆
            case 'admin': {
                $adminData = $this->objUserModel->get_admin();
                if (md5($pwd) === $adminData['pwd']) {
                    //登陆成功，设置会话信息，跳转项目列表界面
                    $_SESSION['login'] = array();
                    $_SESSION['login']['said'] = 'admin';
                    $_SESSION['login']['name'] = $adminData['name'];
                    header("location:project");
                }
                else {
                    //登陆失败，显示提示信息
                    $this->data['error'] = 1;
                    $this->data['said'] = 'admin';
                    $this->load->view('login', $this->data);
                }
                break;
            }
            //用户登陆
            case 'user': {
                $userData = $this->objUserModel->get_user($email, $pwd);
                if ($userData != false) {
                    //登陆成功，设置session，跳转项目列表界面
                    $_SESSION['login'] = array();
                    $_SESSION['login']['said'] = 'user';
                    $_SESSION['login']['uid'] = $userData['id'];
                    $_SESSION['login']['name'] = $userData['name'];
                    $_SESSION['login']['email'] = $email;
                    $_SESSION['login']['auth'] = json_decode($userData['auth']);
                    header("location:project");
                }
                else {
                    //登陆失败，显示提示信息
                    $this->data['error'] = 1;
                    $this->data['said'] = 'user';
                    $this->load->view('login', $this->data);
                }
                break;
            }
            //error login
            default: {
                $this->load->view('login');
                break;
            }
        }
    }
}
