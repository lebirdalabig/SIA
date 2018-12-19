<!doctype html>
<html class="no-js" lang="en">
<?php
    session_start();
    require("connect.php");

    
    if(!isset($_SESSION['user'])){
       header("Location:index.php");
    }

    $user = $_SESSION['user'];
    
    
    
    if(isset($_POST['submitCourse'])){
//        
//        $cCode = mysqli_real_escape_string($conn, $_POST['courseCode']);
//        $cSched= mysqli_real_escape_string($conn, $_POST['courseSched']); 
//        $cTitle= mysqli_real_escape_string($conn, $_POST['courseTitle']); 
        $courseSub= mysqli_real_escape_string($conn, $_POST['courseSub']); 
        $cTerm= mysqli_real_escape_string($conn, $_POST['courseTerm']); 
        $cYear= mysqli_real_escape_string($conn, $_POST['courseYear']);
     
        $sqlIn = "INSERT INTO usercourse(usercourse_id, usercourse_year, usercourse_term, course_id, user_id) VALUES(null, '$cYear', '$cTerm', '$courseSub', '$user')";
        
        mysqli_query($conn, $sqlIn);  
                
        $sqlRet = "SELECT usercourse_id FROM usercourse WHERE course_id ='$courseSub' AND user_id ='$user' AND usercourse_term ='$cTerm' AND usercourse_year ='$cYear'";
        
        $result = mysqli_query($conn, $sqlRet);                    
        
        
        if(mysqli_num_rows($result) == 1){     
            $done = "Course Added!";

            echo "<script type='text/javascript'>alert('$done');</script>";
            
            $foundID = mysqli_fetch_assoc($result);
            
            $cID = $foundID['course_id'];
            
            header("Location:tables-data.php?course_id=$courseSub");
        } else {
            echo "<script type='text/javascript'>alert('Course not added!');</script>";
        }
    }
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Add Course</title>
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
        <!-- Header-->

        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Add Course</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="index.php">Dashboard</a></li>
                            <li>Add New Course</li>                            
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
                                <strong class="card-title">Course Information</strong>
                            </div>
                            <div class="card-body">
                                <form method='POST'>
<!--
                                    <div class="form-group">
                                            <label for="course_Code">Code</label>
                                            <input type="text" class="form-control" id="course_Code" name='courseCode' placeholder="Course code">
                                    </div>
                                    <div class="form-group">
                                            <label for="course_sched">Schedule</label>
                                            <textarea class="form-control" id="course_sched" rows="1" name='courseSched' placeholder="Input schedule of course"></textarea>
                                    </div>
                                    <div class="form-group">
                                            <label for="course_Title">Title</label>
                                            <input type="text" class="form-control" id="course_Title" name='courseTitle' placeholder="Course title">
                                    </div>
-->
                                    <div class="form-group">
                                            <label for="course_prog">Subject</label>
                                            <select class="form-control" id="course_sub" name='courseSub'>
                                                <?php
                                                    $sql = "SELECT * FROM course";
                                                
                                                    $result = mysqli_query($conn, $sql);
                                                
                                                    while($row = mysqli_fetch_assoc($result)){
                                                        echo "<option value='{$row['course_id']}'> {$row['course_code']} || {$row['course_title']} || {$row['course_sched']}</option>";
                                                    }
                                                ?>
                                            </select>
                                    </div>
                                    <div class="form-group">
                                            <label for="course_term">Term</label>
                                            <select class="form-control" id="course_term" name='courseTerm'>
                                              <option value='FIRST'>First</option>
                                              <option value='SECOND'>Second</option>
                                              <option value='SUMMER'>Summer</option>      
                                            </select>
                                    </div>  
                                    <div class="form-group">
                                            <label for="course_year">Year</label>
                                            <input class="form-control"  type='number' min='0' id="course_year" name='courseYear'>
                                    </div>
                                    <button type="submit" class="btn btn-success btn-flat m-b-30 m-t-30" name="submitCourse" >Add Course</button>    
                                </form>
                            </div><!-- card body-->
                         <!-- card-->
            </div><!-- .animated -->
        </div><!-- .content -->


    </div><!-- /#right-panel -->
 
    <!-- Right Panel -->


    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <script src="vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="assets/js/main.js"></script>


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
