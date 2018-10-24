<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<style>
html {
  box-sizing: border-box;
}

*, *:before, *:after {
  box-sizing: inherit;
}

.column {
  float: left;
  width: 33.3%;
  margin-bottom: 16px;
  padding: 0 8px;
}

@media screen and (max-width: 650px) {
  .column {
    width: 100%;
    display: block;
  }
}

.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
}

.container {
  padding: 0 16px;
}

.container::after, .row::after {
  content: "";
  clear: both;
  display: table;
}

.title {
  color: grey;
}

.button {
  border: none;
  outline: 0;
  display: inline-block;
  padding: 8px;
  color: white;
  background-color: #000;
  text-align: center;
  cursor: pointer;
  width: 100%;
}

.button:hover {
  background-color: #555;
}
</style>
</head>
<body>
<?php $this->load->view('header');?>
<h2>Car Details</h2>
<p></p>
<br>
<div class="col-lg-12 col-md-12">
<div class="row">
 <?php foreach($details as $val):?>
  <div class="column">
    <div class="card">
      <img src="<?php echo base_url().$val['image1']; ?>" alt="Jane" style="width:100%">
      <div class="container">
        <h4>Model:<?php echo $val['name'];?></h4>
        <p class="title">Manufacture:<?php echo $val['manufacture'];?></p>
        <p>Serial No:<?php echo $val['res_no'];?></p>
        <p>Color:<?php echo $val['color'];?></p>
        <p>Unit:<?php echo $val['total'];?></p>
        <p><a href="<?php echo base_url().'remove/'.$val['name']; ?>" class="button">Sold</a></p>
      </div>
    </div>
  </div>


 <?php endforeach ; ?>

</div>
</div>

</body>
</html>


