<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* @author   zhangji
* @desc     ###########
*/

class Introduction extends CI_Controller {

    public function index() {
        $this->load->view('pre/introduction');
    }

}