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
<?php $this->load->view('header');?>

<style>
.container{
	 position:fixed;
    top: 50%;
    left: 50%;
    width:30em;
    height:18em;
    margin-top: -9em; /*set to a negative number 1/2 of your height*/
    margin-left: -15em; /*set to a negative number 1/2 of your width*/
    border: 1px solid #ccc;
    background-color: #f3f3f3;
}
 .container input{
 	width: 200px;
 }
</style>
</head>
<body>

	<div class="container" ng-app="myApp" ng-controller="formCtrl">
  <h2>Add Manufactures</h2>
  <form  name="myForm" id="myForm" >
    <div class="form-group">
      <label for="email">Name</label>
      <input type="text" class="form-control" id="Name" ng-model="Name"  placeholder="Enter Name" name="Name" required>
      <span ng-show="myForm.Name.$touched && myForm.Name.$invalid">Please Enter The Name</span>
    </div>
    <button type="submit" class="btn btn-default">Submit</button>
  </form>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<script>

var app = angular.module('myApp', []);
app.controller('formCtrl', function($scope) {
    $scope.Name = "Maruti";
  
});

$("#myForm").submit(function(e) {

    var Name = $('#Name').val();
    var form = $(this);
    var url = form.attr('action');

    $.ajax({
           type: "POST",
           url: '<?php echo base_url().'manufacture'?>',
           data:{Name:Name
                }, 
           success: function(data)
           {
                window.location.href = "<?php echo base_url();?>model"; 
           }
         });

    e.preventDefault(); 
});

</script>
</body>
</html>