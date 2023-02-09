<?php 
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {

 ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
 
    <!-- plugins:css -->
    <?php include "components/links.php" ?> 
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
      <?php include "components/nav.php" ?> 
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <?php include "components/sidebar.php" ?> 
      <div class="main-panel">
          <div class="content-wrapper">

          <?php
include 'config/config.php';

$selectquery = " select * from student where status='Inactive'  ";
$query= mysqli_query($conn,$selectquery);
$num= mysqli_num_rows($query);

$select = " select * from student where status='Active'  ";
$queryy= mysqli_query($conn,$select);
$numm= mysqli_num_rows($queryy);


$selectt = " select * from student  ";
$queryyy= mysqli_query($conn,$selectt);
$nummm= mysqli_num_rows($queryyy);

?>
          <div class="row">
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-danger card-img-holder text-white">
                  <div class="card-body">
                    <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Inactive Students<i class="mdi mdi-account-off mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-1"><?php echo $num  ?></h2>
                  
                  </div>
                </div>
              </div>
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-info card-img-holder text-white">
                  <div class="card-body">
                    <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Active Students<i class="mdi mdi-account mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-1"><?php echo $numm  ?></h2>
          
                  </div>
                </div>
              </div>
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-success card-img-holder text-white">
                  <div class="card-body">
                    <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Total Students <i class="mdi mdi-account-multiple-outline mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-1"><?php echo $nummm  ?></h2>
                
                  </div>
                </div>
              </div>
            </div>
          







                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col">
                        <h4 class="card-title">Hostel Students</h4>
                     </div>
                     <div class="col">
                    <form method="post" action="export/export.php">
     <input type="submit" class="btn btn-success" name="export" class="btn btn-success" value="Export" />
    </form>
                    </div>
                    <div class="col">
                        <a class="btn btn-danger" href="pdf/student-pdf.php">Generate PDF</a>
                      </div>
                  </div> 
                    </p>
                    <table id="datatableid" class="table table-hover">
                      <thead>
                        <tr>
                        <th>#</th>
                          <th>Reg. No.</th>
                          <th>Name</th> 
                          <th>Contact</th>
                          <th>Seat No.</th>
                          <th>Fees</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
include 'config/config.php';

$selectquery = " SELECT * FROM student ORDER BY recorddate DESC ";
$query= mysqli_query($conn,$selectquery);
$num= mysqli_num_rows($query);
$counter="0";
while($res= mysqli_fetch_array($query)){
  
$counter++;
?>
                        <tr>
                        <td><?php echo $counter  ?></td>
                          <td><?php echo $res['Registration']  ?></td>
                          <td><?php echo $res['Name']  ?></td>
                         
                          <td><?php echo $res['Scontact']  ?></td>
                          <td><?php echo $res['seatno']  ?></td>
                          <td><?php echo $res['Rent']  ?>  <?php echo $res['rentstatus']  ?></td>
                          <td><?php echo $res['status']  ?></td> 
                          <td><a class="btn-sm btn-info" style="font-size:11px; padding:7px;"  href="view.php?Registration=<?php echo $res['Registration'] ?>">View</a>  <a  class="btn-sm btn-danger" style="font-size:11px; padding:7px;"   href="update.php?Registration=<?php echo $res['Registration']?>">Update</a> </td>
                        </tr>
                        <?php  }?>

                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
               


        </div>
      </div>
    </div>

    
    <!-- container-scroller -->
    <?php


include 'config/config.php';

$selectquery = " select * from floor  ";
$query= mysqli_query($conn,$selectquery);
$num= mysqli_num_rows($query);
while($res= mysqli_fetch_array($query)){
$seatno= $res['seatno'];

    $select = " select * from student where seatno='$seatno' and status='Active'";
    $result = mysqli_query($conn,$select);
    if (mysqli_num_rows($result)){
     $updatequery= "UPDATE floor SET status='Filled' WHERE seatno='$seatno'";
    $res = mysqli_query($conn,$updatequery);

    }
    else {
        $updatequery= "UPDATE floor SET status='Vacant' WHERE seatno='$seatno'";
        $res = mysqli_query($conn,$updatequery);

    }
    
  
}

?>

<?php

$month= date("F");
include 'config/config.php';

$selectquery = " select * from student  ";
$query= mysqli_query($conn,$selectquery);
$num= mysqli_num_rows($query);
while($res= mysqli_fetch_array($query)){
$Registration= $res['Registration'];

    $select = " select * from payments where Registration='$Registration' AND month='$month' AND paystatus='Paid'";
    $result = mysqli_query($conn,$select);
    if (mysqli_num_rows($result)){
     
       


$updatequery= "UPDATE student SET rentstatus='Paid' WHERE Registration='$Registration'";
$res = mysqli_query($conn,$updatequery);

    }
    else{
        $updatequery= "UPDATE student SET rentstatus='Unpaid' WHERE Registration='$Registration'";
        $res = mysqli_query($conn,$updatequery);
    }
  
}

?>
<?php


include 'config/config.php';

$selectquery = " select * from payments  ";
$query= mysqli_query($conn,$selectquery);
$num= mysqli_num_rows($query);
while($res= mysqli_fetch_array($query)){
$Registration= $res['Registration'];

    $select = " select * from student where Registration='$Registration' and status='Active'";
    $result = mysqli_query($conn,$select);
    if (mysqli_num_rows($result)){
     $updatequery= "UPDATE payments SET status='Active' WHERE Registration='$Registration'";
    $res = mysqli_query($conn,$updatequery);

    }
    else {
        $updatequery= "UPDATE payments SET status='Inactive' WHERE Registration='$Registration'";
        $res = mysqli_query($conn,$updatequery);

    }
    
  
}

?>
    <?php include "components/scripts.php" ?>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
  <script>
  $(document).ready(function() {

    $('#datatableid').DataTable({
      "paggingType": "full_numbers",
      "lenghtMenu":[
        [10,25,50,-1],
      [10,25,50,'All']
    ],
    responsive:true,
    language:{
      search: "_INPUT_",
      searchPlaceholder: "Search",
    } 
     
    });
} );
</script>
  </body>
</html>
<?php 
}else{
     header("Location: index.php");
     exit();
}
 ?>
