<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* @author   zhangji
* @desc     user表
*/

class User_model extends Base_model
{
    function __construct()
    {
        parent::__construct();

        $this->table = 'user';
    }

    public function get_user_name($id = 0)
    {
        $res = $this->get_item(array('id' => $id, 'isadmin' => 0));
        if (is_array($res) && !empty($res)) {
            return $res[0]['name'];
        }
        return false;
    }

    public function get_user($email = '', $pwd = '')
    {
        $res = $this->get_item(array('email' => $email, 'pwd' => md5($pwd), 'isadmin' => 0));
        if (is_array($res) && !empty($res)) {
            return $res[0];
        }
        return false;
    }

    public function add_user($name = '', $email = '', $pwd = '', $pid = '')
    {
        if ($name == '' || $email == '' || $pwd == '') {
            return false;
        }
        else {
            if ($this->exist_email($email)) {
                return false;
            }
            else {
                $user = array(  '`name`'  => $name,
                                '`email`' => $email,
                                '`pwd`'   => md5($pwd),
                                '`auth`'  => json_encode(array($pid)));
                return $this->add_item($user);
            }
        }
    }

    public function add_user_pid($uid = 0, $pid = 0)
    {
        if ($uid == 0 || $pid == 0) {
            return false;
        }
        else {
            $userData = $this->get_item(array('`id`' => $uid));
            if ($userData == false) {
                return false;
            }
            $arrTmp = json_decode($userData[0]['auth']);
            array_push($arrTmp, $pid);
            return $this->update_item(array('`id`' => $uid), array('auth' => json_encode($arrTmp)));
        }
    }

    public function get_admin()
    {
        $res = $this->get_item(array('`isadmin`' => 1));
        return $res[0];
    }

    public function get_all_user()
    {
        return $this->get_item(array('isadmin' => 0), 0, 0, true);
    }

    private function exist_email($email)
    {
        $res = $this->get_item(array('email' => $email));
        if (empty($res)) {
            return false;
        }
        else {
            return true;
        }
    }
}
