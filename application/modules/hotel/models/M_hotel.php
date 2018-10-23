<?php 
class m_hotel extends CI_Model{
	private $tbl_name = 'manufactures';
	private $tbl_name1 = 'model';

	
/*function for uploading the manufacture*/

	function post_manufacture($name){

	$db_conx = mysqli_connect("localhost", "root", "abhijit@123", "carinventory");
	$sql = "INSERT into manufactures (name) Values ('$name')";
	$exquery = mysqli_query($db_conx,$sql);
}


function getmanufactures(){
		$query = "SELECT * FROM ".$this->tbl_name."";
	    $result = $this->db->query($query)->result_array();
		return $result;
}

/*function for uploading the detail of car*/

function post_model($model,$color,$year,$reg,$image,$image1,$notes,$manufact){
 /*  $time = time();
   $banner_image = 'assets/cars/'.$time."_".$_FILES['image'];
   $banner_image2 = 'assets/cars/'.$time."_".$_FILES['image1'];*/
 
	$db_conx = mysqli_connect("localhost", "root", "abhijit@123", "carinventory");
	$sql = "INSERT into model (name,color,notes,res_no,image1,image2,year,manufacture) Values ('$model','$color','$notes','$reg','$image','$image1','$year','$manufact')";
	$exquery = mysqli_query($db_conx,$sql);
	/*$this->db->insert($this->tbl_name, $data);*/
}



/*function for displaying the lists of cars*/

function getcars(){
		$query = "SELECT id,name,color,notes,res_no,image1,image2,manufacture, COUNT(name) as total FROM ".$this->tbl_name1."";
		$query .= " GROUP BY name";
	    $result = $this->db->query($query)->result_array();
		return $result;
}


/*function for displaying the details of car*/

function getdetails($id){
		$query = "SELECT id,name,color,notes,res_no,image1,image2,manufacture, COUNT(name) as total FROM ".$this->tbl_name1." where id=$id ";
		
	
	    $result = $this->db->query($query)->result_array();
		return $result;
}



/*sold our car*/

function getremoved($id){
	
		$query = "DELETE  FROM ".$this->tbl_name1." where name='$id'";
		
	
	    $result = $this->db->query($query);
		return $result;
}


	

}
?>