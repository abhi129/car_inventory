<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class hotel extends CI_Controller {
	
	function __construct(){
        parent::__construct();
        $this->load->model('m_hotel');
         $this->load->helper(array('form', 'url'));
	}

	


	function manufacture(){
		
		$data = array();
		
		$this->load->helper('form');
		 $manufacture = $this->input->post('Name');
         if($manufacture != ""){
         	$this->m_hotel->post_manufacture($manufacture);
         }
		 
		$this->load->view('view_car',$data);

	
}


	


function cars(){
		
		$data = array();
		
		$this->load->helper('form');
		$cars = $this->m_hotel->getcars();
		/*die(print_r($cars));*/
		$data['cars']= $cars;
		$this->load->view('view_cartable',$data);

	
}


function details($id){
		
		$data = array();
		
		$this->load->helper('form');
		$details = $this->m_hotel->getdetails($id);
	/*	die(print_r($details));*/
		$data['details']=$details ;
		$this->load->view('view_details',$data);

	
}


function remove($id){
		
		$data = array();
		
		$this->load->helper('form');
		$details = $this->m_hotel->getremoved($id);
	
		$this->load->view('view_remove',$data);

	
}


      public function do_upload()
        {

        	
                $config['upload_path']          = './uploads/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 100000;
                $config['max_width']            = 1024999;
                $config['max_height']           = 768777;

                $this->load->library('upload', $config);
               /*  die(print_r($this->upload->do_upload('userfile')));*/
                   
                   /* die(print_r($filename));*/
                if ($this->upload->do_upload('userfile'))
                {
                     $filename = $this->upload->data()['file_name'];
                     $filename ="/uploads/".$filename;
                   $data = array('upload_data' => $this->upload->data());
                     
                }
                else
                {
                       
                         $error = array('error' => $this->upload->display_errors());

                       
                }

              

                $data = array();

         $this->load->helper('form');
         if($this->input->post('Name') != ""){
		 $model = $this->input->post('Name');
		 $color = $this->input->post('Color');
		 $year = $this->input->post('Year');
		 $reg = $this->input->post('Reg');
		 $image1 = $this->input->post('Image1');
		 $image = $this->input->post('Image');
		 $notes = $this->input->post('Notes');
		 $manufact = $this->input->post('manufact');
		$manufactures = $this->m_hotel->getmanufactures();
		$data['manufactures'] = $manufactures;
	}
		$image1 = $filename;


		
		 // validate the variables ======================================================
		
		 $this->m_hotel->post_model($model,$color,$year,$reg,$image,$image1,$notes,$manufact);
         $this->load->view('view_model',$data);
        }


}