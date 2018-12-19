<!doctype html>
<html class="no-js" lang="en">
<?php
    session_start();
    require("connect.php");

    
    if(!isset($_SESSION['user'])){
       header("Location:index.php");
    }

    $user = $_SESSION['user'];
    $course = $_GET['course_id'];
    
    if(isset($_POST['addRubric'])){
        
        $rubricName = mysqli_real_escape_string($conn, $_POST['rubricName']); 
        $rubricDesc = mysqli_real_escape_string($conn, $_POST['rubricDesc']); 
        
        
        
        $title = $_POST['headerTitle']; 
        $description = $_POST['headerDesc']; 
        $grade = $_POST['headerGrade'];

        $sqlRubric = "INSERT INTO rubric(rubric_id, rubric_name, rubric_desc, individual_id) VALUES (null, '$rubricName', '$rubricDesc', '2')";
        
        mysqli_query($conn, $sqlRubric);  
 
        $sqlRet = "SELECT rubric_id FROM rubric WHERE rubric_name ='$rubricName'";
        
        $result = mysqli_query($conn, $sqlRet);              
        
        if(mysqli_num_rows($result) == 1){     
            $fetch = mysqli_fetch_assoc($result);
            $rubricID = $fetch['rubric_id'];            
            
            $rubricQuery = "INSERT INTO rubricdesc(rubricDesc_id, rubricDesc_name, rubricDesc_grade, rubricDesc_desc, rubric_id) VALUES ";
            
            foreach($title as $i => $t) 
            {               
                
              $rubricQuery = $rubricQuery." (null, '$t', '$grade[$i]', '$description[$i]', '$rubricID') ,";
            
            }
            
            $rubricQuery = substr($rubricQuery,0,-1);
            mysqli_query($conn, $rubricQuery);
            
            echo "<script type='text/javascript'>alert('Rubric added!');</script>";
            header("Location:tables-data.php?course_id=$course");
        } else {
            echo "<script type='text/javascript'>alert('Rubric not added!');</script>";
        }
    }
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Rubric Maker</title>
    <meta name="description" content="Parker Records">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="favicon.ico">


    <link rel="stylesheet" href="vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="vendors/themify-icons/css/themify-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/selectFX/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="vendors/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="vendors/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css">

    <link rel="stylesheet" href="assets/css/style.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
</head>

<body>
    <?php include'sidebar.php'; ?>
    <div id="right-panel" class="right-panel">
        <!-- Header-->
        <header id="header" class="header">

            <div class="header-menu">

                <div class="col-sm-7">
                    <div class="header-left">
                        <div class="form-inline">
                        </div>
                    </div>
                </div>

                <div class="col-sm-5">
                    <div class="user-area dropdown float-right">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="user-avatar rounded-circle" src="images/admin.jpg" alt="User Avatar">
                        </a>

                        <div class="user-menu dropdown-menu">                            
                            <a class="nav-link" href="logout.php"><i class="fa fa-power-off"></i> Logout</a>
                        </div>
                    </div>

                </div>  
            </div>

        </header><!-- /header -->
          <?php include 'header.php'; ?>
        <!-- Header-->

        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Add Rubric</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="index.php">Dashboard</a></li>
                            <li>Add New Rubric</li>                            
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">Rubric Maker</strong>
                            </div>
                            <div class="card-body">
                                <div style='padding: 10px;'>
                                    <button id="addCol"><i class="fa fa-plus-circle"></i> Add Column </button>
                                </div>
                            
                                    <!--  FORM -->
                                
                            <form method="POST" name="addRubric">
                                    <div class="form-group">
                                            <label for="rubric_name">Name</label>
                                            <input type="text" class="form-control" id="rubric_name" name='rubricName' placeholder="Rubric Name">
                                    </div>  
                                    <div class="form-group">
                                            <label for="rubric_desc">Description</label>
                                            <textarea class="form-control" id="rubric_desc" rows="1" name='rubricDesc' placeholder="Input schedule of course"></textarea>
                                    </div>

                            <table id="myTable" class="table table-striped table-bordered">  
                                    <thead>
                                        <tr id='headerHidden'></tr>
                                        
                                        <tr id='tableHead'> </tr>
                                    </thead>
                                    <tbody>
                                        <tr id='tableSub'></tr>
                                    </tbody>
                                </table>

                                    <button type="submit" class="btn btn-success btn-flat m-b-30 m-t-30" name='addRubric' >Add Rubric</button>  
                                
                                </form>
                                
                                <!-- END OF FORM -->
                            </div><!-- card body-->
                        </div>   <!-- card-->
            </div><!-- .animated -->
        </div><!-- .content -->


    </div><!-- /#right-panel -->
 
</div>   <!-- Right Panel -->


    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <script src="vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="vendors/jquery/dist/3.3.1/jquery.min.js"></script>

    <script src="vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="vendors/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <script src="vendors/jszip/dist/jszip.min.js"></script>
    <script src="vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="vendors/pdfmake/build/vfs_fonts.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.colVis.min.js"></script>
    <script src="assets/js/init-scripts/data-table/datatables-init.js"></script>


</body>

</html>
<script>
$(document).ready(function(){
    
   $("#addCol").click(function(){       
//        var hide = "<th class='hidden' colspan='2'></th>";
//        $("#headerHidden").append(hide);
        
        var head = "<th scope='col' ><input type='text' name='headerTitle[]' style='width:100%;' placeholder='Input title'/></th>";
       
        $("#tableHead").append(head);
              
        var headGrade = "<th scope='col'><input type='number' style='width:100%;' name='headerGrade[]' placeholder='Input grade'/></th>";
        $("#tableHead").append(headGrade);
       
        var row = "<td colspan='2'><textarea name='headerDesc[]' style='width:100%;' placeholder='Input description'></textarea></td>";
        $("#tableSub").append(row);
    });

});
</script>