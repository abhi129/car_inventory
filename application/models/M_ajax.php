<?php 
class m_ajax extends CI_Model{
  
	function __construct()
	{
		parent::__construct();
	}

	// Messaging functions
	function addMessageRequest($user1,$user2,$subject,$message,$status)
	{
		$msg=0;
		$replyid=0;
		//$query = $this->db->get_where('tbl_messages', array( 'from_id' => $user1, 'to_id' => $user2 ));
		$query = $this->db->query("select * from tbl_messages where (from_id = $user1 and to_id = $user2) 
			or (from_id = $user2 and to_id = $user1) AND replyid = '0' AND status = '0'");
		$count = $query->num_rows();
		if ($count > 0) {
			$row = $query->row_array();
			//pr($query->row_array());die;
			$replyid = $row['id'];
		}
		if($subject and $message) {
			$messageData = array(
				'from_id' => $user1,
				'to_id' => $user2,
				'subject' => $subject,
				'message' => $message,
				'status' => $status,
				'createdon' => date("Y-m-d H:i:s",time()),
				'modifiedon' => date("Y-m-d H:i:s",time()),
				'ip' => $_SERVER["REMOTE_ADDR"],
				'replyid' => $replyid,
			);
			//pr($messageData);die;
			$this->db->insert('tbl_messages', $messageData);
			$id = $this->db->insert_id();
			$msg = ($this->db->affected_rows() > 0) ? 1 : 0;//for insert
			return $msg;
		}
		//}else $msg=3;
		return $msg;
	}

	function addReplyRequest($user1,$user2,$messageid,$message,$status)
	{
		$msg=0;
		$loggedinId = getMemberUserID();
		// If logged in user put message then it is not reply.
		/*
		if($loggedinId == $user1){
			$messageid = 0;
		}
		*/
		/*
		$query = $this->db->get_where('tbl_messages', array( 'from_id' => $user1, 'to_id' => $user2 ));
		$count = $query->num_rows();
		if ($count === 0) {} */
		/////
		if($message) {
			$messageData = array(
				'from_id' => $user1,
				'to_id' => $user2,
				'replyid' => $messageid,
				'message' => $message,
				'status' => $status,
				'createdon' => date("Y-m-d H:i:s",time()),
				'modifiedon' => date("Y-m-d H:i:s",time()),
				'ip' => $_SERVER["REMOTE_ADDR"],
			);
			//pr($messageData);die;
			$this->db->insert('tbl_messages', $messageData);
			$id = $this->db->insert_id();
			$msg = ($this->db->affected_rows() > 0) ? 1 : 0;//for insert
			return $msg;
		}
		//}else $msg=3;
		return $msg;
	}

	function getMessageRequest($id){
		$loggedinId = getMemberUserID();
		$row = $this->db->select('*')
			->get_where('tbl_messages',array('id' => $id))->row_array();
		$modifiedon = $row['modifiedon'];
		$row['date'] = date("d M",strtotime($modifiedon));
		$from_id = $row['from_id'];
		$row['loggedinusermsg'] = false;
		// If sender is logged in user.
		if($from_id == $loggedinId){
			$row['receiver'] = $row['to_id'];
			$row['loggedinusermsg'] = true;
		}else $row['receiver'] = $row['from_id'];

		$row['displaytime'] = date('Y M d h:i:s A',strtotime($modifiedon));
		$oMember = getMemberDetailsById($from_id);
        //$uname = isset($oMember['username'])?$oMember['username']:'';
        $p_image = isset($oMember['profile_image'])?$oMember['profile_image']:'';
        $row['profile_image'] = $p_image;
        //pr($row);die;
		return json_encode($row);
	}

	function getreplyMessageRequest($id)
	{
		$loggedinId = getMemberUserID();
		$arrRequests = '';
		$result = $this->db->select('*')
			->get_where('tbl_messages',array('replyid' => $id))->result_array();
		foreach($result as $k=>$v){
			$arrMessage['id'] = $v['id'];
			$arrMessage['from_id'] = $v['from_id'];
			$arrMessage['to_id'] = $v['to_id'];
			$arrMessage['subject'] = $v['subject'];
			$arrMessage['message'] = $v['message'];
			$arrMessage['status'] = $v['status'];
			$arrMessage['modifiedon'] = $v['modifiedon'];
			$arrMessage['createdon'] = $v['createdon'];
			$arrMessage['ip'] = $v['ip'];
			$from_id = $v['from_id'];
			$arrMessage['displaytime'] = date('Y M d h:i:s A',strtotime($v['modifiedon']));
			$oMember = getMemberDetailsById($from_id);
			$p_image = isset($oMember['profile_image'])?$oMember['profile_image']:'';
        	$arrMessage['profile_image'] = $p_image;
        	$arrMessage['loggedinusermsg'] = false;
        	// If sender is logged in user.
        	if($from_id == $loggedinId){
        		$arrMessage['loggedinusermsg'] = true;
        	}
			$arrRequests[] = $arrMessage;
		}
		return json_encode($arrRequests);
	}

	// Friend functions
	function addFriendRequest($user1,$user2,$status,$action_user_id)
	{
		$msg=0;
		$query = $this->db->get_where('tbl_friends', array( 'user_one_id' => $user1, 'user_two_id' => $user2 ));
		$count = $query->num_rows();
		if ($count === 0) {
			$friendsData = array(
				'user_one_id' => $user1,
				'user_two_id' => $user2,
				'status' => $status,
				'action_user_id' => $action_user_id,
				'createdon' => date("Y-m-d H:i:s",time()),
				'modifiedon' => date("Y-m-d H:i:s",time()),
				'ip' => $_SERVER["REMOTE_ADDR"],
			);
			$this->db->insert('tbl_friends', $friendsData);
			$id = $this->db->insert_id();
			$msg = ($this->db->affected_rows() > 0) ? 1 : 0;//for insert
			return $msg;
		}else $msg=3;
		return $msg;
	}

	function updateFriendRequest($user1,$user2,$status,$action_user_id)
	{
		$msg=0;
		$query = $this->db->get_where('tbl_friends', array( 'user_one_id' => $user1, 'user_two_id' => $user2 ));
		//echo $this->db->last_query(); die;
		$count = $query->num_rows();
		if ($count > 0) {
			// Update friend request status
			$this->db->where('user_one_id',$user1);
			$this->db->where('user_two_id',$user2);
	        $this->db->set("status", $status);
	        $this->db->set("action_user_id", $action_user_id);
	        $this->db->set("modifiedon", date("Y-m-d H:i:s",time()));
	        $this->db->set("ip", $_SERVER["REMOTE_ADDR"]);
	        $this->db->update("tbl_friends");
			//echo $this->db->last_query(); die;
			$msg=($this->db->affected_rows() > 0) ? 1 : 0;
		}
		return $msg;
	}

	// Help functions
	function getTagFriends($name){
		$loggedinId = getMemberUserID();
		// Get current member schools
		$arrMemberSchools = getMemberSchools($loggedinId);
		$schoolids = implode(',',$arrMemberSchools);
		
		// Get related members
		$arrResults = array();
		if($loggedinId and $schoolids){
			$CI =& get_instance();
			
			$query =  $CI->db->query("
				SELECT * from tbl_members where id in (
				SELECT ms.memberId FROM tbl_schools s
				inner join tbl_member_schools ms
				on s.id = ms.schoolId
				where s.id in(".$schoolids.") and ms.memberId != '".$loggedinId."') 
				and firstname like '%".$name."%' 
				order by id DESC");
			foreach($query->result() as $objRes){
				$arrRow['id'] = $objRes->id;
				$arrRow['name'] = $objRes->firstname.' '.$objRes->lastname;
				$arrResults[] = $arrRow;
			}
		}
		//echo $CI->db->last_query();die;
		//print_r($query->result());die;
		return $arrResults;
	}
	/////////////////
	function getHelpTypes($optionTitle=''){
		$courseNames = array(1=>'Coaching',2=>'Finnancial',3=>'Tutions');
		$arrData[''] = $optionTitle;
		for ($x = 1; $x <= count($courseNames); $x++) {
		  $arrData[$courseNames[$x]] = $courseNames[$x];
		}
	    return $arrData;
	}

	function getHelpCategories1($optionTitle=''){
		$classNames = array(1=>'First',2=>'Second',3=>'Third',4=>'Fourth',5=>'Fifth',6=>'Sixth',
		7=>'Seventh',8=>'Eighth',9=>'Ninth',10=>'Tenth',11=>'Eleventh',12=>'Twelth');
		$arrClasses[''] = $optionTitle;
		for ($x = 1; $x <= 12; $x++) {
		  $arrClasses[$x] = $classNames[$x];
		}
		return $arrClasses;
	}

	function getHelpCategories2($optionTitle=''){
		$courseNames = array(1=>'Science',2=>'Maths',3=>'English');
		$arrData[''] = $optionTitle;
		for ($x = 1; $x <= count($courseNames); $x++) {
		  $arrData[$courseNames[$x]] = $courseNames[$x];
		}
	    return $arrData;
	}

	// Help comment Functions
	function addHelpCommentRequest($userid,$messageid,$comment){
		$commentsData = array(
			'comment' => $comment,
			'replyid' => 0,
			'createdon' => date("Y-m-d H:i:s",time()),
		);
		$this->db->insert('tbl_comments', $commentsData);
		$commentid = $this->db->insert_id();
		$msg = ($this->db->affected_rows() > 0) ? 1 : 0;//for insert
		if($commentid){
			$table2Data = array(
				'userid' => $userid,
				'messageid' => $messageid,
				'commentid' => $commentid
			);
			$this->db->insert('tbl_helpmessage_comments', $table2Data);
			$id = $this->db->insert_id();
			$msg = ($this->db->affected_rows() > 0) ? 1 : 0;//for insert
		}
		return $msg;
	}
	function getHelpCommentsRequest($userid,$msgid){
		// Get Help Comments
		$arrResults = array();
		if($userid and $msgid){
			$CI =& get_instance();
			/*
			$query =  $CI->db->query("
				SELECT * from tbl_comments where id in (
				select commentid from tbl_helpmessage_comments 
				where userid = '".$userid."' and messageid = '".$msgid."' ) 
				order by createdon desc");
			*/
			$query =  $CI->db->query("
				SELECT tbl_comments.id,tbl_comments.comment,tbl_comments.replyid,tbl_comments.createdon, 
				(select userid from tbl_helpmessage_comments where commentid = tbl_comments.id) as userid 
				from tbl_comments where id in 
				( select commentid from tbl_helpmessage_comments where messageid = '".$msgid."' ) 
				order by createdon desc");
			$count = $query->num_rows();
			foreach($query->result() as $objRes){
				$oMember = getMemberDetailsById($objRes->userid);
				$fullname = $oMember['firstname'].' '.$oMember['lastname'];
				//$p_image = isset($oMember['profile_image'])?$oMember['profile_image']:'';
				$arrRow['comment'] = $objRes->comment;
				$arrRow['replyid'] = $objRes->replyid;
				$arrRow['createdon'] = date('D ,d F g:i A',strtotime($objRes->createdon));
				$arrRow['fullname'] = $fullname;
				$arrRow['count'] = $count;
				$arrResults[] = $arrRow;
			}
		}
		//echo $CI->db->last_query();die;
		//pr($query->result());
		//pr($arrResults);die;
		return $arrResults;
	}

	// User comment Functions
	function addUserCommentRequest($userid,$messageid,$comment){
		$commentsData = array(
			'comment' => $comment,
			'replyid' => 0,
			'createdon' => date("Y-m-d H:i:s",time()),
		);
		$this->db->insert('tbl_comments', $commentsData);
		$commentid = $this->db->insert_id();
		$msg = ($this->db->affected_rows() > 0) ? 1 : 0;//for insert
		if($commentid){
			$table2Data = array(
				'userid' => $userid,
				'messageid' => $messageid,
				'commentid' => $commentid
			);
			$this->db->insert('tbl_usermessage_comments', $table2Data);
			$id = $this->db->insert_id();
			$msg = ($this->db->affected_rows() > 0) ? 1 : 0;//for insert
		}
		return $msg;
	}
	function getUserCommentsRequest($userid,$msgid){
		// Get Help Comments
		$arrResults = array();
		if($userid and $msgid){
			$CI =& get_instance();
			/*
			$query =  $CI->db->query("
				SELECT * from tbl_comments where id in (
				select commentid from tbl_usermessage_comments 
				where userid = '".$userid."' and messageid = '".$msgid."' ) 
				order by createdon desc");
			*/
			$query =  $CI->db->query("
				SELECT tbl_comments.id,tbl_comments.comment,tbl_comments.replyid,tbl_comments.createdon, 
				(select userid from tbl_usermessage_comments where commentid = tbl_comments.id) as userid 
				from tbl_comments where id in 
				( select commentid from tbl_usermessage_comments where messageid = '".$msgid."' ) 
				order by createdon desc");
			$count = $query->num_rows();
			foreach($query->result() as $objRes){
				$oMember = getMemberDetailsById($objRes->userid);
				$fullname = $oMember['firstname'].' '.$oMember['lastname'];
				//$p_image = isset($oMember['profile_image'])?$oMember['profile_image']:'';
				$arrRow['comment'] = $objRes->comment;
				$arrRow['replyid'] = $objRes->replyid;
				$arrRow['createdon'] = date('D ,d F g:i A',strtotime($objRes->createdon));
				$arrRow['fullname'] = $fullname;
				$arrRow['count'] = $count;
				$arrResults[] = $arrRow;
			}
		}
		//echo $CI->db->last_query();die;
		//pr($query->result());
		//pr($arrResults);die;
		return $arrResults;
	}

	// User Like/Dislike
	function addUserLike($userid,$messageid){
		$status=0;
		$arrResults = array();
		$query = $this->db->get_where('tbl_message_likes', array( 'userid' => $userid, 'messageid' => $messageid ));
		$count = $query->num_rows();
		if (intval($count) == 0) {
			$userData = array(
				'userid' => $userid,
				'messageid' => $messageid,
				'status' => 1,
				'createdon' => date("Y-m-d H:i:s",time()),
			);
			$this->db->insert('tbl_message_likes', $userData);
			$id = $this->db->insert_id();
			$msg = ($this->db->affected_rows() > 0) ? 1 : 0;//for insert
			$status=1;
		}
		else{
			$statusqry = $this->db->get_where('tbl_message_likes', array( 'userid' => $userid, 'messageid' => $messageid ));
			$row = $statusqry->row_array();
			$status = isset($row['status'])?$row['status']:0;
			if($status == 0) $status=1;else $status=0;
			// Update Status
			$this->db->where('userid',$userid);
			$this->db->where('messageid',$messageid);
	        $this->db->set("status", $status);
	        $this->db->set("createdon", date("Y-m-d H:i:s",time()));
	        $this->db->update("tbl_message_likes");
			//echo $this->db->last_query(); die;
			$msg=($this->db->affected_rows() > 0) ? 2 : 0;
		}
		/* Count likes for a message */
		$totalLikes = getUserLikesCount($userid,$messageid);
		$arrRow['status'] = $status;
		$arrRow['totalLikes'] = $totalLikes;
		$arrResults[] = $arrRow;
		return $arrResults;
	}
	/////////////////////////////////////////////
	// My Slate
	// Add slate messages,likes & comments
	function addSlateCommentRequest($slateid, $userid,$messageid,$comment,$replyid=0){
		$commentsData = array(
			'comment' => $comment,
			'replyid' => $replyid,
			'createdon' => date("Y-m-d H:i:s",time()),
		);
		$this->db->insert('tbl_comments', $commentsData);
		$commentid = $this->db->insert_id();
		$msg = ($this->db->affected_rows() > 0) ? 1 : 0;//for insert
		if($commentid){
			$table2Data = array(
				'userid' => $userid,
				'messageid' => $messageid,
				'slateid'=> $slateid,
				'commentid' => $commentid
			);
			$this->db->insert('tbl_slate_comments', $table2Data);
			$id = $this->db->insert_id();
			$msg = ($this->db->affected_rows() > 0) ? 1 : 0;//for insert
		}
		return $msg;
	}

	function getSlateMessagesRequest($slateid, $userid,$msgid){
		// Get Slate Comments
		$arrResults = array();
		if($userid and $msgid){
			$CI =& get_instance();
			/*
			$query =  $CI->db->query("
				SELECT * from tbl_comments where id in (
				select commentid from tbl_slate_comments 
				where userid = '".$userid."' and messageid = '".$msgid."' ) 
				order by createdon desc");
			*/
			$query =  $CI->db->query("
				SELECT tbl_comments.id,tbl_comments.comment,tbl_comments.replyid,tbl_comments.createdon, 
				(select userid from tbl_slate_comments where commentid = tbl_comments.id) as userid 
				from tbl_comments where id in 
				( select commentid from tbl_slate_comments where messageid = '".$msgid."' ) 
				order by createdon desc");
			$count = $query->num_rows();
			foreach($query->result() as $objRes){
				$oMember = getMemberDetailsById($objRes->userid);
				$fullname = $oMember['firstname'].' '.$oMember['lastname'];
				//$p_image = isset($oMember['profile_image'])?$oMember['profile_image']:'';
				$arrRow['comment'] = $objRes->comment;
				$arrRow['replyid'] = $objRes->replyid;
				$arrRow['createdon'] = date('D ,d F g:i A',strtotime($objRes->createdon));
				$arrRow['fullname'] = $fullname;
				$arrRow['count'] = $count;
				$arrResults[] = $arrRow;
			}
		}
		//echo $CI->db->last_query();die;
		//pr($query->result());
		//pr($arrResults);die;
		return $arrResults;
	}

	// Salte Like/Dislike
	function addSlateLike($slateid,$userid,$messageid){
		$status=0;
		$arrResults = array();
		$query = $this->db->get_where('tbl_slatemessage_likes', array( 'slateid' => $slateid,
			'userid' => $userid, 'messageid' => $messageid ));
		$count = $query->num_rows();
		if (intval($count) == 0) {
			$userData = array(
				'slateid' => $slateid,
				'userid' => $userid,
				'messageid' => $messageid,
				'status' => '1',
				'createdon' => date("Y-m-d H:i:s",time()),
			);
			$this->db->insert('tbl_slatemessage_likes', $userData);
			$id = $this->db->insert_id();
			$msg = ($this->db->affected_rows() > 0) ? 1 : 0;//for insert
			$status=1;
		}
		else{
			$statusqry = $this->db->get_where('tbl_slatemessage_likes', array( 'slateid' => $slateid,'userid' => $userid, 'messageid' => $messageid ));
			$row = $statusqry->row_array();
			$status = isset($row['status'])?$row['status']:0;
			if($status == 0) $status=1;else $status=0;
			// Update Status
			$this->db->where('userid',$userid);
			$this->db->where('messageid',$messageid);
			$this->db->where('slateid',$slateid);
	        $this->db->set("status", $status);
	        $this->db->set("createdon", date("Y-m-d H:i:s",time()));
	        $this->db->update("tbl_slatemessage_likes");
			//echo $this->db->last_query(); die;
			$msg=($this->db->affected_rows() > 0) ? 2 : 0;
		}
		//echo $this->db->last_query();die;
		/* Count likes for a message */
		$totalLikes = getSlateLikesCount($messageid);
		$arrRow['status'] = $status;
		$arrRow['totalLikes'] = $totalLikes;
		$arrResults[] = $arrRow;
		return $arrResults;
	}
	/////////////////////////////////////////////
}