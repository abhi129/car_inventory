<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<?php $this->load->view('header');?>
<div class="container">
  <h2>Cars Details</h2>
                                                                                       
  <div class="table-responsive">          
  <table class="table">
    <thead>
      <tr>
        <th>#</th>
        <th>Serial Number</th>
        <th>Manufacture Name</th>
        <th>Model Name</th>
        <th>Units</th>
       
      </tr>
    </thead>
    <tbody>
    <?php $i = 0;?>
      <?php foreach($cars as $val):?>
      <tr>
        <td><a href="<?php echo base_url().'details/'.$val['id']; ?>"><?php echo $i;?></a></td>
        <td><a href="<?php echo base_url().'details/'.$val['id']; ?>"><?php echo $val['res_no'];?></a></td>
        <td><a href="<?php echo base_url().'details/'.$val['id']; ?>"><?php echo $val['manufacture'];?></a></td>
        <td><a href="<?php echo base_url().'details/'.$val['id']; ?>"><?php echo $val['name'];?></a></td>
        <td><a href="<?php echo base_url().'details/'.$val['id']; ?>"><?php echo $val['total'];?></a></td>
      <?php $i++; ?>
      </tr>
    <?php endforeach ;?> 
    </tbody>
  </table>
  </div>
</div>

</body>
</html>
