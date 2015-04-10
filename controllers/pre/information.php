<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* @author   zhangji
* @desc     项目信息
*/

class Information extends CI_Controller
{
    private $data;

    private $objProjectModel;

    private $objPjtypeModel;

    private $objPjrangeModel;

    function __construct()
    {
        parent::__construct();

        $this->load->model('project_model');
        $this->objProjectModel = new Project_model;

        $this->load->model('pjtype_model');
        $this->objPjtypeModel = new PjType_model;

        $this->load->model('pjrange_model');
        $this->objPjrangeModel = new PjRange_model;

        $this->data = array();
        $this->data['tag'] = array();
        $this->data['tag']['title'] = '评估类型';
        $this->data['tag']['content'] = '项目启动时必须定义项目的类型，评估工作将依据项目类型进行，不同类型的项目工作内容也不相同';

    }

    public function index()
    {
        if (!empty($_POST)) {
            $this->form();
        }

        //设置session
        if (!isset($_SESSION['project'])) {
            $this->init_project();
        }

        $pid = $_SESSION['project']['pid'];
        $this->data['project'] = $this->objProjectModel->get_project($pid);
        $this->data['project']['range'] = json_decode($this->data['project']['theRange']);
        $this->data['pjType'] = $this->objPjtypeModel->get_type();
        $this->data['pjRange'] = $this->objPjrangeModel->get_range();

        $this->load->view('pre/information', $this->data);

    }

    private function form()
    {
        $pid  = $_SESSION['project']['pid'];
        $name = isset($_POST['pjName']) ? $_POST['pjName'] : '';
        $type = isset($_POST['pjType']) ? $_POST['pjType'] : '';
        $range= isset($_POST['pjRange'])? $_POST['pjRange']: '';
        $goal = isset($_POST['pjGoal']) ? $_POST['pjGoal'] : '';
        $desc = isset($_POST['pjDesc']) ? $_POST['pjDesc'] : '';

        //
        if (!is_array($range) || !in_array('1', $range) || !in_array('4', $range) || !in_array('6', $range)) {
            $this->data['error'] = 2;
            return;
        }

        //
        $newData = array(   'name' => $name,
                            'theType' => $type,
                            'theRange' => json_encode($range),
                            'goal' => $goal,
                            'theDesc' => $desc);
        $res = $this->objProjectModel->update_project($pid, $newData);

        if ($res == false) {
            $this->data['error'] = 2;
        }
        else {
            $this->data['error'] = 1;
            if ($name != $_SESSION['project']['name']) {
                $_SESSION['project']['name'] = $name;
            }
        }
    }

    private function init_project()
    {
        $pid = isset($_GET['pid']) ? $_GET['pid'] : 0;
        $project = $this->objProjectModel->get_project($pid);
            
        $_SESSION['project'] = array();
        $_SESSION['project']['pid'] = $project['id'];
        $_SESSION['project']['name'] = $project['name'];
        $_SESSION['project']['status'] = $project['status'];
        /*
        $_SESSION['project']['type'] = $project['theType'];
        $_SESSION['project']['range'] = json_decode($project['theRange']);
        $_SESSION['project']['partA'] = $project['partA'];
        $_SESSION['project']['partB'] = $project['partB'];
        $_SESSION['project']['updatetime'] = $project['updatetime'];
        $_SESSION['project']['goal'] = $project['goal'];
        $_SESSION['project']['desc'] = $project['theDesc'];
        */
    }
}