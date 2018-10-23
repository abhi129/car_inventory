<?php 
class notfound extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct();
    } 

    public function index() 
    { 
        $this->output->set_status_header('404');
        $data['content'] = 'error_404'; // View name
        $data['settings'] = get_settings();
        $this->load->view('custom_404',$data);
    } 
} 
?>