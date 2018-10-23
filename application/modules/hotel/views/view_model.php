<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Car Inventory</title>
<meta name="keywords" content="">
<meta name="description" content="">
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js">
</script>
<style>

</style>
</head>
<body>
<?php $this->load->view('header');?>

<div class="col-sm-12 col-md-6 col-lg-6">

	<div class="container" ng-app="myApp" ng-controller="formCtrl">
  <h2>Add Model</h2>
  
   <div class="col-md-6 col-lg-6">
   <div class="row">
    <div class="form-group">
   
      <label for="Name">Name</label>
      <input type="text" class="form-control" id="Name" ng-model="Name"  placeholder="Enter Name" name="Name" required>
      <span ng-show="myForm.Name.$touched && myForm.Name.$invalid">Please Enter The Name</span>
    </div>
     <div class="form-group">
   
      <label for="Name">Color</label>
      <input type="text" class="form-control" id="Color" ng-model="Color"  placeholder="Enter Color" name="Color" required>
      <span ng-show="myForm.Name.$touched && myForm.Name.$invalid">Please Enter The Color</span>
    </div>
      <div class="form-group">
   
      <label for="Name">Manufacturing Year</label>
      <input type="text" class="form-control" id="Year" ng-model="Year"  placeholder="Enter Year" name="Year" required>
      <span ng-show="myForm.Name.$touched && myForm.Name.$invalid">Please Enter The Year</span>
    </div>
     <div class="form-group">
   
      <label for="Name">Resgistration Number</label>
      <input type="text" class="form-control" id="Reg" ng-model="Reg"  placeholder="Enter Resgistration" name="Reg" required>
      <span ng-show="myForm.Name.$touched && myForm.Name.$invalid">Please Enter The Resgistratiion Number</span>
    </div>
      <div class="form-group">
   
      <label for="Name">Notes</label>
     <input ng-model="myTextarea" class="form-control" id="Notes" name="Notes"></input>
      <span ng-show="myForm.Name.$touched && myForm.Name.$invalid">Please Enter The Name</span>
    </div>
     <div class="form-group">
    
      <label for="Name">Pictures</label>
        <?php echo $error;?> 
      <?php echo form_open_multipart('upload/do_upload');?> 
    
      <form action = "" method = "">
         <input type = "file" class="form-control" name = "userfile" id="userfile" size = "20" /> 
         
      <br>
         <br />  
         <center><input type = "submit"  onclick="fff();" value = "upload" /> </center>
      </form>

    </div>
   
    </div>
   
    </div>

</div>
</div>
<div class="col-md-6 col-lg-6">
  <div class="container" ng-app="myApp" ng-controller="formCtrl">
  <h2>Manufacture</h2>
  
   <div class="col-md-6 col-lg-6">
   <div class="row">
    <div class="form-group">
  
      <label for="Name">Name</label>
  <select class="form-control" name="manufact" id="manufact">
  <?php foreach($manufactures as $val):?>
  <option value="<?php echo $val['name'];?>"><?php echo $val['name'];?></option>
<?php endforeach ; ?>
</select>


</div>
</div>
</div>
</div>
</div>




<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<script>
var app = angular.module('myApp', []);
app.controller('formCtrl', function($scope) {
    $scope.Name = "";
    $scope.names = ["Emil", "Tobias", "Linus"];
 
});

function fff(){

/*ajax  for sending the data*/


    var Name = $('#Name').val();
    var Color = $('#Color').val();
    var Year = $('#Year').val();
    var Reg = $('#Reg').val();
    var Image = $('#userfile').val();
    var Image1 = $('#Image1').val();
    var Notes = $('#Notes').val();
    var manufact = $('#manufact').val();
    Image  = Image.substr(12);
    Image =  "uploads/" + Image;


    var form = $(this);
    var url = form.attr('action');
    /*alert(Image1);*/
    $.ajax({
           type: "POST",
           url: '<?php echo base_url().'model'?>',
           data:{Name:Name,Color:Color,Year:Year,Reg:Reg,Image:Image,Image1:Image1,Notes:Notes,manufact:manufact
                }, 
           success: function(data)
           {
               
                window.location.href = "<?php echo base_url();?>model"; 
           }
         });

    

}
     



</script>

</body>
</html>