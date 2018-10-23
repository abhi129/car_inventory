<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ajax extends CI_Controller {
	
	function __construct(){
        parent::__construct();
		$this->load->model('m_ajax');
	}

	public function sendmailMessage($action1){
		//$action1 = $_REQUEST['action'];
		// For Enquiry
		if($action1=='enq_submit')
		{
			$enq_name1  	= $_REQUEST['enq_name'];
			$enq_mob1   	= $_REQUEST['enq_mob'];
			$enq_email1 	= $_REQUEST['enq_email'];
			$enq_msg1   	= $_REQUEST['enq_msg'];
			//$enq_captcha    = $_REQUEST['enq_captcha'];


			//echo $enq_captcha.'---'.$_SESSION['captcha'];
			//if($enq_captcha==$_SESSION['captcha'])
			//{
				if($enq_name1!='' && $enq_mob1!='' && $enq_email1!='' && $enq_msg1!='')
				{
					//$to = getSettingbyField();
					$to = "ashish@radiantwebtech.com";
					$subject="Enquiry from website - Essentia";
					$TblHadder=
					"<table width='672' border='0' align='center' cellpadding='0' cellspacing='0' bgcolor='#FFFFFF' style='border:#e0e0e0 2px solid; padding:0 0 0 0;  '>
							<tr>
								<td align='left' valign='top' style='padding:10px 0 0 0'>
									<table width='650' border='0' align='center' cellpadding='0' cellspacing='0'>
						
					 <tr> <td align='left' valign='top'>
										<table width='100%' align='center' cellpadding='4' cellspacing='4'>
			 		 <tr> <td align='left' valign='top' width='20% style='font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#000000; line-height:18px; text-align:justify; margin:0; padding:0;'> Name : </td><td '>".$enq_name1."			</td>
											</tr>
											
					 <tr> <td align='left' valign='top' style='font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#000000; line-height:18px; text-align:justify; margin:0; padding:0;'> Mobile : </td><td>".$enq_mob1."</td>
											</tr>
									
					 <tr> <td align='left' valign='top' style='font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#000000; line-height:18px; text-align:justify; margin:0; padding:0;'> Email : </td><td>".$enq_email1."</td>
											</tr>
											
					 <tr> <td align='left' valign='top' style='font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#000000; line-height:18px; text-align:justify; margin:0; padding:0;'> Enquiry : </td><td>".$enq_msg1."</td>
											</tr> </table> </td> </tr> </table> ";
				 
					$sMessage  =  $TblHadder;
					$from_header  = 'MIME-Version: 1.0' . "\r\n";
					$from_header .= 'Content-type: text/html; charset=Shift_JIS' . "\r\n";
					$from_header .= 'Content-type: text/html; charset=utf-8' . "\r\n";
					$from_header .= "From: $to";
					mail($to, $subject, $sMessage, $from_header, "-f $to");
			 		echo 'Success';
			 	}
				else{
					echo 'All fields are required.';
				}
			//}
			//else{
				//echo 'Incorrect security code. Please try again';
			//}
		}
	}
}