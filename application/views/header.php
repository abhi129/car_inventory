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

* {
    box-sizing: border-box;
}

body {
  margin: 0;
}

/* Style the header */
.header {
    background-color: #f1f1f1;
    padding: 20px;
    text-align: center;
}

/* Style the top navigation bar */
.topnav {
    overflow: hidden;
    background-color: #333;
}

/* Style the topnav links */
.topnav a {
    float: left;
    display: block;
    color: #f2f2f2;
    text-align: center;
    padding: 14px 160px;
    text-decoration: none;
}

/* Change color on hover */
.topnav a:hover {
    background-color: #ddd;
    color: black;
}


</style>
</head>
<body>
<div class="header">
  <h1>Car Inventory System</h1>
</div>

<div class="topnav">
  <a href="<?php echo base_url(); ?>manufacture">Add Manufacture</a>
  <a href="<?php echo base_url(); ?>model">Add Model</a>
  <a href="<?php echo base_url(); ?>cars">See All Cars</a>
</div>
</body>
</html>