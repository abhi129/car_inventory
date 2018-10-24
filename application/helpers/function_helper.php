<?php 
if ( ! function_exists('pr'))
{
	function pr($data){
		echo '<pre>';
		print_r($data);
		echo '</pre>';
	}
}

if(!function_exists('is_logged_in'))
{
    function is_logged_in()
    {
		$CI =& get_instance();
		$is_logged_in = $CI->session->userdata('shuttle_admin');
		//print_r($is_logged_in);
		
		if(!isset($is_logged_in) || $is_logged_in != true)
		{
			redirect('admin/login');
			die();
		}
	}
}

if(!function_exists('getCurUserID'))    
{
    function getCurUserID()
    {
	   $CI =& get_instance();
	   $is_logged_in = $CI->session->userdata('shuttle_admin');
		//print_r($is_logged_in);
       if(isset($is_logged_in) || $is_logged_in == true)
       {
			return $is_logged_in['id'];
       } else 
			return '';
    }
}

if(!function_exists('is_memberlogged_in'))
{
    function is_memberlogged_in()
    {
		$CI =& get_instance();
		$is_logged_in = $CI->session->userdata('isckool_member');
		//print_r($is_logged_in);
		
		if(!isset($is_logged_in) || $is_logged_in != true)
		{
			$curURL = current_url();
			redirect('login/?referrer='.$curURL);
			die();
		}
	}
}
if(!function_exists('getMemberUserID'))
{
    function getMemberUserID()
    {
	   $CI =& get_instance();
	   $is_logged_in = $CI->session->userdata('isckool_member');
	 
       if(isset($is_logged_in) || $is_logged_in == true)
       {
			return $is_logged_in['id'];
       }else
			return '';
    }
}

if(!function_exists('getCurUserType'))    
{
    function getCurUserType()
    {
	
	   $CI =& get_instance();
	   $is_logged_in = $CI->session->userdata('shuttle_admin');
	   	   
	  // pr($is_logged_in);
	   if(isset($is_logged_in) || $is_logged_in == true)
	   {
			return $is_logged_in['admin_type'];
	   }else
			return '';
    }
}

if(!function_exists('getCurMemberType'))
{
    function getCurMemberType()
    {
	   $CI =& get_instance();
	   $is_logged_in = $CI->session->userdata('isckool_member');
	   //pr($is_logged_in);
	   if(isset($is_logged_in) || $is_logged_in == true)
	   {
			return $is_logged_in['id'];
	   }else
			return '';
    }
}

if(!function_exists('isUserPermission'))    
{
     function isUserPermission() //$user_id considered as permission name
    {
	$CI =& get_instance();
		
	$CI->load->model('m_data');
	$res = $CI->m_data->isUserPermission();	
	
	if($res ==1){
		redirect('admin/nopermission');  
        die(); 
	}else{
	 	return true;
	}
	 
    }
}

if(!function_exists('accessurl'))
{
	function accessurl($get_module='')
	{
		//echo 'shows';exit;
		$user_id = getCurUserID();
		$permission =array();
		$role = getUserRole($user_id);
		//echo $role;
		$CI =& get_instance();
		$query =  $CI->db->select('permission')->from('tbl_role')->where('tbl_role.role_id', $role)->get();
		//echo $CI->db->last_query(); die;
		$query = $query->result_array();
		$permission = $query[0];
		if($permission)
		{
			$permission = explode(',' ,$permission['permission']);
			//	print_r($permission);
			$module=explode(',', $get_module);	
			$countmodule=count($module);
			//$mod=array('test','test1');
			$i=0;
			//count moldule in db
			foreach($module as $modules)
			{
				if((in_array($modules ,$permission)))
				{
					$i++;
				}
			}
			 //$class=(($i)!=(-$countmodule))?'hides':'shows';
			//$class=(($countmodule-$i)==0)?'hides'.$countmodule.'--'.$i:'shows'.$countmodule.'--'.$i;
			$class=(($countmodule-$i)==0)?'hides':'shows';
			echo $class;
		}
		
		
	}
}

//check urser role
if(!function_exists('checkuserrole'))
{
	function checkuserrole($get_module='',$permission='')
	{
		if($permission)
		{
			$permission = explode(',' ,$permission);
			if((in_array($get_module ,$permission)))
			{
				echo 'checked="checked"';
			}
			else
			{
				echo '';
			}
		}
	}
}

if(!function_exists('getUserRole'))
{
    function getUserRole($user_id = 0)
    {
		$user_id = getCurUserID();
		//echo $user_id;die;	
		 $CI =& get_instance();
		 $CI->load->model('m_data');
		 $res = $CI->m_data->getUserRole($user_id);
		 return $res[0]['role_id'];
    }
}

if(!function_exists('getMemberRole'))
{
    function getMemberRole($user_id = 1)
    {
		$member_id = getMemberID();
		//echo 'memeberid:'.$member_id;die;
		$CI =& get_instance();
		$CI->load->model('m_data');
		$res = $CI->m_data->getMemberRole($member_id);
		//pr($res);die;
		return $res[0]['role_id'];
    }
}

// Memeber Login Functions
if(!function_exists('getMemberID'))
{
    function getMemberID()
    {
	   $CI =& get_instance();
	   $is_logged_in = $CI->session->userdata('isckool_member');
       if(isset($is_logged_in) || $is_logged_in == true)
       {
			return $is_logged_in['id'];
       } else
			return '';
    }
}


if(!function_exists('getMemberStatus'))
{
    function getMemberStatus()
    {
	   $CI =& get_instance();
	   $is_logged_in = $CI->session->userdata('isckool_member');
	   //pr($is_logged_in);exit;
	   if(isset($is_logged_in) || $is_logged_in == true)
	   {
		return $is_logged_in['status'];
	   }else
		return '';
    }
}

if(!function_exists('getMemberDetailsById')){
	function getMemberDetailsById($memberid){
		$CI = &get_instance();
		$query = $CI->db->select('*')->from('tbl_members')
					->where('id',$memberid)
					->where('status','1')
					->get();
		//echo $CI->db->last_query(); die;
		$items = array();
		foreach($query->result() as $row){
			$items['id'] =  $row->id;
			$items['username'] =  $row->username;
			$items['firstname'] =  ucfirst($row->firstname);
			$items['lastname'] =  ucfirst($row->lastname);
			$items['mobile'] =  $row->mobile;
			$items['gender'] =  $row->gender;
			$items['email'] =  $row->email;
			$items['password'] =  $row->password;
			$items['date_of_birth'] =  $row->date_of_birth;
			$items['city'] =  $row->city;
			$items['hometown'] =  $row->hometown;
			$items['aboutme'] =  $row->aboutme;
			$items['profile_image'] =  $row->profile_image;
			$items['comanyname'] =  $row->comanyname;
			$items['userTypeId'] =  $row->userTypeId;
			$items['verification_code'] =  $row->verification_code;
			$items['status'] =  $row->status;
			$items['createdon'] =  $row->createdon;
		}
		return $items;
	}
}

if(!function_exists('getAdminUserDetailsById')){
	function getAdminUserDetailsById($adminid){
		$CI =  & get_instance();
		$query =  $CI->db->select('*')->from('tbl_users')
					->where('id',$adminid)
					->where('status','1')
					->get();
		//echo $CI->db->last_query(); die;
		$items = array();
		foreach($query->result() as $row){
			$items['id'] =  $row->id;
			$items['username'] =  $row->username;
			$items['email'] =  $row->email;
			$items['password'] =  $row->password;
			$items['full_name'] =  ucfirst($row->first_name).' '.ucfirst($row->last_name);
			//$items['status'] =  $row->status;
		}
		return $items;
	}
}


/**********************for date format **************************************************/
if ( ! function_exists('dateFormat'))
{
	function dateFormat($date){
	      if(!empty($date)){
		return date('M d, Y',strtotime($date));
	      } else {
		  return '';
	      }
		}
}
if ( ! function_exists('secToDate'))
{
	function secToDate($sec){
	      if(!empty($sec)){
				return date('M d, Y',$sec);
	      } else {
		  return '';
	      }
		}
}
if ( ! function_exists('formdate'))
{ // it is for show date in forms dd/mm/yy
	function formdate($date){
	      if(!empty($date)){
				return date('d-m-Y',strtotime($date));
	      } else {
		  return '';
	      }
		}
}
if ( ! function_exists('secToformdate'))
{ // it is for show date in forms dd/mm/yy
	function secToformdate($sec){
	      if(!empty($sec)){
		return date('d-m-Y',$sec);
	      } else {
		  return '';
	      }
		}
}
/*************End Date ***********************/

/************* Encryption Data ***********************/
function encryptString($str=''){
	if ($str) {
		$converter = new Encryption;
		$encoded = $converter->encode($str );
		return $encoded;
	}
	return '';
}

function decryptString($encoded=''){
	if ($encoded) {
		$converter = new Encryption;
		$decoded = $converter->decode($encoded);
		return $decoded;
	}
	return '';
}
/*************Encryption ***********************/

if (! function_exists('showmsg'))
{
	function showmsg($msg){
	      if(!empty($msg)){
			  $html='';
			  $html .='<div class="alert alert-success custom_green_alert">'.$msg.'</div>';
			  return $html;
	      } else {
		  return '';
	      }
		}
}

if ( ! function_exists('showerrormsg'))
{
	function showerrormsg($msg){
	      if(!empty($msg)){
			  $html='';
			  $html .='<div class="alert alert-danger custom_red_alert">'.$msg.'</div>';
			  return $html;
	      } else {
			return '';
	      }
		}
}
if (! function_exists('sholockmsg'))
{
	function sholockmsg($msg){
	      if(!empty($msg)){
		  return $msg;
	      } else {
		  return '';
	      }
		}
}
function getFieldValue($tblname,$field,$where){
	$CI =  & get_instance();
	$row = $CI->db->select($field)
		   ->get_where($tblname,$where)->row_array();
	//pr($row);die;
	return $row;
}

if(!function_exists('get_settings')){
	function get_settings(){
		
	}
}

if(!function_exists('customers_list')){
	function customers_list(){
		$CI =  & get_instance();
		$output =  $CI->db->select('name,id')
								  ->from('tbl_customer t1')
								  ->get();
		$customer[''] = "Select Customer*";
		foreach($output->result() as $row){
			$customer[$row->id] =  ucfirst($row->name);
		}
		return $customer;
	}
}

if(!function_exists('cutString')){
	function cutString($str='',$char=100){
		if(!isEmpty($str)){
			if(strlen($str)>$char)
			{
			   return substr($str,1,$char).'...';
			}else
			{
			   return $str;
			}
		}else 
		return false;
	}
}

if(!function_exists('clientNameFromId')){
	function clientNameFromId($id=''){
		if(!isEmpty($id)){
			$CI = & get_instance();
			$CI->load->model('customer/m_customer');
			return $CI->m_customer->clientNameFromId($id);
		}else 
			return false;
	}
}

if ( ! function_exists('isEmpty'))
{
	function isEmpty($var){
		if(empty($var) || trim($var) == "" || $var == NULL) return true;
		else return false;
	}
}

if ( ! function_exists('isVarEmpty'))
{
	function isVarEmpty($var){
		if(empty($var) || trim($var) == "" || $var == NULL) return $var;
		else return '';
	}
}

if(!function_exists('userNameFromId')){
	function userNameFromId($id=''){
		if(!isEmpty($id)){
			$CI = & get_instance();
			$CI->load->model('user/m_user');
			return $CI->m_user->userNameFromId($id);
		}else 
			return false;
	}
}

if(!function_exists('memberNameFromId')){
	function memberNameFromId($id=''){
		if(!isEmpty($id)){
			$CI = & get_instance();
			$output =  $CI->db->select('full_name')
				  ->from('tbl_members m')
				  ->where('m.id',$id)
				  ->get();
			foreach($output->result() as $row){
				$member = ucfirst($row->full_name);
			}
			return $member;
		}else 
			return false;
	}
}

function GetNumberOfMonths($date1, $date2)
{
	$ts1 = strtotime($date1);
	$ts2 = strtotime($date2);

	$year1 = date('Y', $ts1);
	$year2 = date('Y', $ts2);

	$month1 = date('m', $ts1);
	$month2 = date('m', $ts2);

	$diff = (($year2 - $year1) * 12) + ($month2 - $month1);
	return $diff;
}

if(!function_exists('role')){
	function role(){
		$CI = & get_instance();
		$query = $CI->db->get('tbl_role');
		$role[''] = "Select Role*"; 
		foreach($query->result() as $row){
			$role[$row->role_id] =  ucfirst($row->role_name);
		}
		return $role;
	}
}

if(!function_exists('getDateFormat')){
	function getDateFormat($date,$format = "M j Y")
	{
		//echo date($format,strtotime($date));
		return date($format,strtotime($date));
	}
}

if(!function_exists('getSettingbyField')){
	function getSettingbyField($id=1,$field='admin_email'){ 
		if(!isEmpty($id)){
			$CI = & get_instance();
			$CI->load->model('admin/m_setting');
			return $CI->m_setting->getSettingbyField($id,$field);
		}else
			return false;
	}
}

if(!function_exists('selectEmailTemplate')){
	function selectEmailTemplate($template=''){
		if(!isEmpty($template)){
			$CI = & get_instance();
			$query = $CI->db->get_where('tbl_email_templates',array('alias'=>$template))->row();
			return $query;
		}else 
			return false;
	}
}

function Title($title='')
{
	$getTitle=(!empty($title))?'Holiday Floridas - '.ucwords($title):'Holiday Floridas';
	echo $getTitle;
}

function MetaDescription($desc='')
{
	
	$getTitle=(!empty($desc))?$desc:'';
	echo $getTitle;
}

function MetaKeywords($keywords='')
{
	
	$getTitle=(!empty($keywords))?$keywords:'';
	echo $getTitle;
}

function mailerTemplate($message)
{
	$mailertmp='<table width="100%" border="0" cellspacing="0" cellpadding="0" style="background:#FFFFFF; border:3px solid #86352c; width:600px; margin:0 auto; font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#141414;">
	<thead><tr><th style="background:#74241b;"><p><img src="'.base_url().'assets/frontend/images/logo.png" width="180" alt="" border="0" /></p></th></tr></thead><tbody><tr><td style="padding:0 20px;">';
	$mailertmp .=$message;
	$mailertmp .='</td></tr></tbody><tfoot><tr><td style="padding:0 20px; font-size:14px;"><p><strong>Regards</strong><br /><img src="'.base_url().'assets/frontend/images/small_logo.png" width="143" height="30" alt="" border="0" /></p></td></tr></tfoot></table>';
	return $mailertmp;
}

if(!function_exists('setdateformat'))
{
	function setdateformat()
	{
		echo date('m/d/Y', time());
	}
}


if(!function_exists('setdateformatbyfield'))
{
	function setdateformatbyfield($date)
	{
		echo date('m/d/Y', $date);
	}
}

function getSettingbyField($id=1,$field='admin_email'){
	$CI =& get_instance();
	$query = $CI->db->query("SELECT $field FROM `tbl_setting` WHERE id =$id");
	if ($query->num_rows() > 0)
	{
		$row = $query->row()->$field;
		//pr($row);
		return $row;
	}
}

function isSchoolExistForUser($memberId=0,$schoolId=0){
	$CI =& get_instance();
	$query = $CI->db->query("SELECT * FROM tbl_member_schools WHERE memberId='$memberId' and schoolId='$schoolId'");
	if ($query->num_rows() > 0)
	{
		return true;
	}
	return false;
}

function sendMail($title,$subject,$message,$attachment='',$ext='docx',$email='abhijeet@holidaywagon.com'){
	$CI =& get_instance();
	$from = $email;
        $list = array('abhijeet@holidaywagon.com', 'melis.erek@holidaywagon.com', 'trevor@holidaywagon.com');
	//$to = 'ashish@radiantwebtech.com';
	//$from = 'melis.erek@holidaywagon.com';
	//$to = 'abhijeet@holidaywagon.com';
	$CI->load->library('email');
	$config['charset'] = 'iso-8859-1';
	$config['wordwrap'] = TRUE;
	$config['mailtype'] = 'html';
	$CI->email->initialize($config);
	$CI->email->from('queries@holidaywagon.com', $title);
	$CI->email->to($list);
	$CI->email->subject($subject);
	$CI->email->message($message);
	if($attachment){
		$CI->email->attach($attachment, 'attachment', 'cv-'.time().'.'.$ext);
	}
	if($CI->email->send())
        {
              echo "email send";
           }
        else
         {
          echo "failed";
         }
        echo $CI->email->print_debugger();
	$CI->email->clear(TRUE);
}

/*
function sendMail($to,$email_template='default',$replace_word){
	$CI =& get_instance();
	$email_template = selectEmailTemplate($email_template);
	$default_content = array(
	  '##SITE_NAME##' => 'iSckool',
	  '##SITE_URL##' => base_url(),
	);
	$emailFindReplace = array_merge($default_content, $replace_word);
	//pr($emailFindReplace);die;
	$message = strtr($email_template->body, $emailFindReplace);
	//echo $message;die;
	$title = 'iSckool';
	$subject = "$title Confirmation Email";
	// Mail
	$from = getSettingbyField();
	$CI->load->library('email');
	$config['charset'] = 'iso-8859-1';
	$config['wordwrap'] = TRUE;
	$config['mailtype'] = 'html';
	$CI->email->initialize($config);
	$CI->email->from($from, $title);
	$CI->email->to($to);
	$CI->email->subject($subject);
	$CI->email->message($message);
	$CI->email->send();
	$CI->email->clear(TRUE);
}
*/

function generateVerificationCode()
{
	return md5(rand(0,1000));
}

function getPageInfo($slug=''){
	$CI =& get_instance();
	$CI->db->select('*');
	$CI->db->from('tbl_pages');
	if(!empty($slug)){
		$CI->db->where('page_slug',$slug);
	}
	$query = $CI->db->get();
	return $query->result();
}

function getSchoolAddress($addressid){
	$CI =& get_instance();
	$CI->db->select('*');
	$CI->db->from('tbl_school_address');
	$CI->db->where('id',$addressid);
	$arrAddress = $CI->db->get()->row_array();
	return $arrAddress;
}

function generateRandomId(){
	$digits = 11;
	$randomnumber = rand(pow(10, $digits-1), pow(10, $digits)-1);
	return 'INS'.$randomnumber;
}

function getMember($id=0)
{
	$arrResults = array();
	$rowcount = 0;
	if($id){
		$CI =& get_instance();
		$query =  $CI->db->query("
			SELECT m.* FROM tbl_members m 
			where m.id = '".$id."'");
		//echo $CI->db->last_query();
		$rowcount = $query->num_rows();
		foreach($query->result() as $row){
			$arrResults['id'] =  $row->id;
			$arrResults['firstname'] =  $row->firstname;
			$arrResults['lastname'] =  $row->lastname;
			$arrResults['mobile'] =  $row->mobile;
			$arrResults['gender'] =  $row->gender;
			$arrResults['email'] =  $row->email;
			$arrResults['password'] =  $row->password;
			$arrResults['date_of_birth'] =  $row->date_of_birth;
			$arrResults['city'] =  $row->city;
			$arrResults['hometown'] =  $row->hometown;
			$arrResults['aboutme'] =  $row->aboutme;
			$arrResults['profile_image'] =  $row->profile_image;
			$arrResults['comanyname'] =  $row->comanyname;
			$arrResults['userTypeId'] =  $row->userTypeId;
			$arrResults['verification_code'] =  $row->verification_code;
			$arrResults['status'] =  $row->status;
			$arrResults['createdon'] =  $row->createdon;
		}
	}
	$arrResults['rowcount'] = $rowcount;
	//pr($arrResults);die;
	return $arrResults;
}

function getAllMembers()
{
	$arrRows = array();
	$CI =& get_instance();
	$query =  $CI->db->query("SELECT * FROM tbl_members");
	foreach($query->result() as $row){
		$arrResults['id'] =  $row->id;
		$arrResults['firstname'] =  $row->firstname;
		$arrResults['lastname'] =  $row->lastname;
		$arrResults['mobile'] =  $row->mobile;
		$arrResults['gender'] =  $row->gender;
		$arrResults['email'] =  $row->email;
		$arrResults['password'] =  $row->password;
		$arrResults['date_of_birth'] =  $row->date_of_birth;
		$arrResults['city'] =  $row->city;
		$arrResults['hometown'] =  $row->hometown;
		$arrResults['aboutme'] =  $row->aboutme;
		$arrResults['profile_image'] =  $row->profile_image;
		$arrResults['comanyname'] =  $row->comanyname;
		$arrResults['userTypeId'] =  $row->userTypeId;
		$arrResults['verification_code'] =  $row->verification_code;
		$arrResults['status'] =  $row->status;
		$arrResults['createdon'] =  $row->createdon;
		$arrRows[] = $arrResults;
	}
	//pr($arrRows);die;
	return $arrRows;
}

function getFieldFromId($id,$field='*',$table=''){
	$CI =& get_instance();
	$row = $CI->db->select($field)
		->get_where($table,array('id' => $id))->row();
	//echo $CI->db->last_query();die;
	return is_object($row)?$row->page_title:false;
}

function getFieldByName($id,$field='*',$table='',$returnfield=''){
	$CI =& get_instance();
	$row = $CI->db->select($field)
		->get_where($table,array('id' => $id))->row();
	//echo $CI->db->last_query();die;
	return is_object($row)?$row->{$returnfield}:false;
}

function getGalleries($id=0){
	$CI =& get_instance();
	$CI->db->select('*');
	$CI->db->from('tbl_covers');
	if($id){
		$CI->db->where('id',$id);
	}
	$rows = $CI->db->get()->result_array();
	return $rows;
}

function gethomeNcorpCategories($gallerytype=''){
	$CI =& get_instance();
	$CI->db->select('*');
	$CI->db->from('tbl_resi_corp_categories');
	if($gallerytype){
		$CI->db->where('gallery_type',$gallerytype);
	}
	$rows = $CI->db->get()->result_array();
	return $rows;
}

function getCategories($type=''){
	$CI =& get_instance();
	$CI->db->select('*');
	$CI->db->from('tbl_categories');
	if($type){
		$CI->db->where('gallery_type',$type);
	}
	$CI->db->order_by('priority','Asc');
	$rows = $CI->db->get()->result_array();
	return $rows;
}

function getCategoryData($slug='',$type=''){
	$CI =& get_instance();
	$CI->db->select('*');
	$CI->db->from('tbl_categories');
	$CI->db->where('gallery_type',$type);
	$CI->db->where('slug',$slug);
	$CI->db->where('is_active', '1');
	$rows = $CI->db->get()->result_array();
	return $rows;
}

function getGalleryImages($galleryid='',$gallery_type=''){
	$rows='';
	if($galleryid){
		$CI =& get_instance();
		$query = $CI->db->query("SELECT g.* FROM tbl_resi_corp_categories c
								join tbl_gallery g on c.id=g.categoryid
								where g.is_active = 1 and g.gallery_type='".$gallery_type."' and c.id = '".$galleryid."'
								order by g.priority ASC");
		$rows = $query->result_array();
	}
	return $rows;
}

function getFeaturesGallery($id=''){
	$rows='';
	if($id){
		$CI =& get_instance();
		$query = $CI->db->query("SELECT g.id,g.category_image FROM tbl_features f
								join tbl_gallery g on f.id=g.categoryid
								where g.is_active = 1 and g.gallery_type='feature' and f.id = '".$id."'
								order by g.id DESC");
		$rows = $query->result_array();
	}
	return $rows;
}

function gethandoverCategories($id=0){
	$CI =& get_instance();
	$CI->db->select('*');
	$CI->db->from('tbl_handover_categories');
	if($id){
		$CI->db->where('id',$id);
	}
	$CI->db->order_by('priority','Asc');
	$rows = $CI->db->get()->result_array();
	return $rows;
}

function handoversGallery($catid=0)
{
	$CI =& get_instance();
	$query = "SELECT g.id,g.banner_image,c.page_title FROM tbl_handover_categories c 
				join tbl_gallery g on c.id=g.categoryid 
				where g.is_active = 1 and g.gallery_type='home_gallery4' and c.id = '".$catid."'";
	$query .= " ORDER BY g.priority ASC";
	$result = $CI->db->query($query)->result_array();
	//echo 'query:'.$query;
	return $result;
}

function getPackages($id=0){
	$CI =& get_instance();
	$CI->db->select('*');
	$CI->db->from('tbl_categories');
	if($id){
		$CI->db->where('id',$id);
	}
	$CI->db->order_by('priority','Asc');
	$query = $CI->db->get();
	$arrRows[] = array('id'=>'0','category_title' => 'Select Category');
	$count=0;
	foreach($query->result() as $row){
		$count++;
		$arrResults['id'] =  $row->id;
		$arrResults['category_title'] =  $row->category_title;
		$arrRows[$count] = $arrResults;
	}
	//pr($arrRows);die;
	return $arrRows;
}

function getIdBySlugName($slug,$table){
	$CI =& get_instance();
	$query = "SELECT id FROM $table where slug='".$slug."'";
	$result = $CI->db->query($query);
	$row = $result->row();
	return is_object($row)?$row->id:false;
}
function getSlugById($id,$table){
	$CI =& get_instance();
	$query = "SELECT slug FROM $table where id='".$id."'";
	$result = $CI->db->query($query);
	$row = $result->row();
	return is_object($row)?$row->slug:false;
}

/*
function getCities(){
	$CI =& get_instance();
	$CI->db->select('*');
	$CI->db->from('tbl_cities');
	$query = $CI->db->get();
	//echo $CI->db->last_query();die;
	//$cats['0'] = "Select City";
        $cats = array();
	foreach($query->result() as $row){
	  $cats[$row->id] =  ucfirst($row->name);
	}
	return $cats;
}

function getPreferredAirlines(){
	$CI =& get_instance();
	$CI->db->select('*');
	$CI->db->from('tbl_airlines');
	$query = $CI->db->get();
	//echo $CI->db->last_query();die;
	//$cats['0'] = "Select Airline";
        $cats = array();
	foreach($query->result() as $row){
	  $cats[$row->id] =  ucfirst($row->name);
	}
	return $cats;
}*/
