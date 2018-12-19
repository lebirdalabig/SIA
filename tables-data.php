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

    $sql = "SELECT *
            FROM usercourse uc
            JOIN course c
            ON uc.course_id = c.course_id
            WHERE uc.usercourse_id = '$course' ";
    
    $ret = mysqli_query($conn, $sql);    
    
    while($row = mysqli_fetch_assoc($ret)){
        $title = $row['course_title'];
        $code = $row['course_code'];
        $program = $row['course_program'];
        $preReq = $row['course_prereq'];
        $credits = $row['course_credits'];
        $description = $row['course_desc'];        
    }   

    $query = "SELECT * FROM gradeSystem WHERE course_id = '$course'";
                        
    $input = mysqli_query($conn, $query);
    
    if(isset($_POST['editGradeSys'])){
        if(isset($_POST['updatedTitle'])){
            
            $upTitle = $_POST['updatedTitle'];
            $upTitleID = $_POST['utID'];
            
            if($upTitle > 1){
                foreach($upTitle as $b => $name){
                    $compareQ = "SELECT gradeSys_name FROM gradeSys WHERE gradeSys_id = '$upTitleID[$b]'";
                    $compare = mysqli_query($conn, $compareQ);
                    
                    if($name != $compare['gradeSys_name']){
                        $updateTitle = "UPDATE gradeSystem SET gradeSys_name ='$name' WHERE gradeSys_id = '$upTitleID[$b]'";
                        mysqli_query($conn, $updateTitle);
                    }
                }
            } else {
                $compareQ = "SELECT gradeSys_name FROM gradeSys WHERE gradeSys_id = '$upTitleID[$b]'";
                    $compare = mysqli_query($conn, $compareQ);
                    
                    if($upTitle != $compare['gradeSys_name']){
                        $updateTitle = "UPDATE gradeSystem SET gradeSys_name ='$name' WHERE gradeSys_id = '$upTitleID[$b]'";
                        mysqli_query($conn, $updateTitle);
                    }
            }
            
        }
        
        if(isset($_POST['utPerc'])){
            $upTitlePerc = $_POST['utPerc'];
            $upTitleID = $_POST['utID'];
            
            if($upTitlePerc > 1){
                foreach($upTitlePerc as $p => $perc){
                    
                    $compareQ = "SELECT gradeSys_percentage FROM gradeSys WHERE gradeSys_id = '$upTitleID[$p]'";
                    $compare = mysqli_query($conn, $compareQ);
                    
                    if($perc != $compare['gradeSys_percentage']){
                        $updatePerc = "UPDATE gradeSystem SET gradeSys_percentage ='$perc' WHERE gradeSys_id = '$upTitleID[$p]'";
                        mysqli_query($conn, $updatePerc);
                    }
                }
            } else {
                $compareQ = "SELECT gradeSys_percentage FROM gradeSys WHERE gradeSys_id = '$upTitleID[$p]'";
                $compare = mysqli_query($conn, $compareQ);
                    
                    if($perc != $compare['gradeSys_percentage']){
                        $updatePerc = "UPDATE gradeSystem SET gradeSys_percentage ='$upTitlePerc' WHERE gradeSys_id = '$upTitleID'";
                        mysqli_query($conn, $updatePerc);
                }
                
                
            }
            
        }
//        querying for insertion of new data
        if(isset($_POST['title'])){
            
            $newTitle = $_POST['title'];
            $newPerc = $_POST['perc'];
            $newType = $_POST['type'];
            
            $addQuery = "INSERT INTO gradeSystem(gradeSys_id, gradeSys_name, gradeSys_percentage, gradeSys_type, course_id) 
        VALUES ";
        
            foreach($newTitle as $x => $z){
                $addQuery = $addQuery." (null, '$z', '$newPerc[$x]', '$newType[$x]', '$course') ,";
            }
            $addQuery = substr($addQuery,0,-1);
            mysqli_query($conn, $addQuery);


            $queryFetch = "SELECT gradeSys_id, gradeSys_name FROM gradeSystem WHERE course_id = '$course'";

            $newAssess = mysqli_query($conn, $queryFetch);
            if(mysqli_num_rows($newAssess) > 1){
                //multiple instances
                while($row = mysqli_fetch_assoc($newAssess)){
                    $aQuery = "INSERT INTO assessment(assessment_id, assessment_name, gradeSys_id) VALUES (null, '{$row['gradeSys_name']}','{$row['gradeSys_id']}')";

                    mysqli_query($conn, $aQuery);
                }
            } else {
                //for only one instance
                $rowOnce = mysqli_fetch_assoc($newAssess);

                $aQueryOnce = "INSERT INTO assessment(assessment_id, assessment_name, gradeSys_id) VALUES (null, '{$rowOnce['gradeSys_name']}','{$rowOnce['gradeSys_id']}')";

                mysqli_query($conn, $aQueryOnce);
            }
        }
        
        
    }
    
    //deleting row of data
    if(isset($_POST['removeRow'])){
        $delID = $_POST['removeRow'];
        
        $fetchAID = "SELECT assessment_id FROM assessment WHERE gradeSys_id = '$delID'";
        $assessQ = mysqli_query($conn, $fetchAID);
        $aID = mysqli_fetch_assoc($assessQ);

        //get individual id
        $fetchIndivID= "SELECT individual_id FROM individual WHERE assessment_id = '{$aID['assessment_id']}'";
        $indivQ = mysqli_query($conn, $fetchIndivID);
        $indivID = mysqli_fetch_assoc($indivQ);

        //delete from score
        $deleteScore = "DELETE FROM score WHERE individual_id = '{$indivID['individual_id']}'";
        mysqli_query($conn, $deleteScore);

        //delete from individual
        $deleteIndividual = "DELETE FROM individual WHERE assessment_id = '{$aID['assessment_id']}'";
        mysqli_query($conn, $deleteIndividual);
        
        //delete from assessment
        $delA = "DELETE FROM assessment WHERE gradeSys_id = '$delID'";
        mysqli_query($conn, $delA);
        
        //delete from gradesystem
        $delGS = "DELETE FROM gradeSystem WHERE gradeSys_id = '$delID'";
        mysqli_query($conn, $delGS);
    }         
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $title ?></title>
    <meta name="description" content="Sufee Admin - HTML5 Admin Template">
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>


    <style>
.gradeSystem {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

.gradeSystem td, .gradeSystem th {
    border: 1px solid #ddd;
    padding: 8px;
}

.gradeSystem tr:nth-child(even){background-color: #f2f2f2;}

.gradeSystem tr:hover {background-color: #ddd;}

.gradeSystem th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #4CAF50;
    color: white;
}

.w3-button{
    margin-left:65%;
    margin-top: 5px;
}

.but{
  margin-left:85%;
}
</style>
</head>

<body>
    <?php include'sidebar.php'; ?>
    <div id="right-panel" class="right-panel">
        <!-- Header-->
        <header id="header" class="header">

            <div class="header-menu">

                <div class="col-sm-7">
                    <a id="menuToggle" class="menutoggle pull-left"><i class="fa fa fa-tasks"></i></a> 
                    <div class="header-left">
                        <!-- <button class="search-trigger"><i class="fa fa-search"></i></button> -->
                        <div class="form-inline">
                           <!--  <form class="search-form">
                                <input class="form-control mr-sm-2" type="text" placeholder="Search ..." aria-label="Search">
                                <button class="search-close" type="submit"><i class="fa fa-close"></i></button>
                            </form> -->
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


        <!-- V I E W -->
  <div class="modal fade" id="viewModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Viewing Grading System</h4>
        </div>
        <div class="modal-body" >              
                    <table class = 'gradeSystem' id='viewGS'>
                        <?php
                            $query = "SELECT * FROM gradeSystem WHERE course_id = '$course'";
                            $input = mysqli_query($conn, $query);
                            $i = 0;
                            $j = 0;
                            while($row = mysqli_fetch_assoc($input)){
                                if($row['gradeSys_type'] == 0){
                                    echo "<tr id='titleRow'><th id='blank'>&nbsp;</th><th id='co1' headers='blank'>{$row['gradeSys_name']}</th><th id='co2' headers='blank'>{$row['gradeSys_percentage']} &percnt;</th></tr>";
                                    $i+=$row['gradeSys_percentage'];
                                } else {
                                   echo "<tr><th id='c1' headers='blank'>&nbsp;</th><td headers='co1 c1'>{$row['gradeSys_name']}</td><td headers='co2 c1'>{$row['gradeSys_percentage']} &percnt;</td></tr>";
                                   $j+=$row['gradeSys_percentage'];
                                }
                            }
                        ?>
                        <tr id='totalRow'>
                            <th id='blank'>&nbsp;</th>
                            <th id='co1' headers='blank'>TOTAL</th>
                            <th id='co2' headers='blank'><?php echo $j; ?>%</th>
                        </tr>
                    </table>           
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
    
    
    
                        <!--    E D I T O R      -->
    
    <div class="modal fade" id="editModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Grading System Editor</h4>
<!--
          <span><button type="button" id="editSystem" class="btn btn-success but">
      <span> Edit<i class="fa fa-edit"></i></span> 
    </button></span>
-->
        </div>
        <div class="modal-body" >
            <div id='buttonArea'>
                <div style='padding: 10px; margin-left: 30%;'>
                    <button id='addTitle' class='btn btn-success'>
                        <i class='fa fa-plus-circle'></i> Add Title 
                    </button> 
                    <button id='addSubs' class='btn btn-success'>
                        <i class='fa fa-plus-circle'></i> Add Sub Title 
                    </button>
                    <button id='undoRow'  class='btn btn-danger'><i class='fa fa-close'></i> Undo Row </button>
                </div>
            </div>
               <form method='POST' id='gsForm'>
                    <table class = 'gradeSystem' id='editGS'>
                        <tr id='totalRow'>
                            <th id='blank'>&nbsp;</th>
                            <th id='co1' headers='blank'>Title</th>
                            <th id='co2' headers='blank'>Percentages</th>
                            <th id='blank'>&nbsp;</th>
                        </tr>
                        <?php
                        
                            $query = "SELECT * FROM gradeSystem WHERE course_id = $course";
                            $input = mysqli_query($conn, $query);
                            
                            while($row = mysqli_fetch_assoc($input)){
                                if($row['gradeSys_type'] == 0){
                                    echo "<tr id='titleRow'><th id='blank'>&nbsp;</th><th id='co1' headers='blank'><input type='hidden' name='utID[]' value='{$row['gradeSys_id']}' /><input type='text' name='updatedTitle[]' style='color:black; width: 100%;' placeholder='{$row['gradeSys_name']}'/></th><th id='co2' headers='blank'><input type='text' name='utPerc[]' style='color:black; width: 100%;' placeholder='{$row['gradeSys_percentage']}'/></th><td><button name='removeRow' value ='{$row['gradeSys_id']}' class='btn btn-danger' onclick = 'deleteRow();' >Delete<i class='fa fa-close'></i> </button> </td> </tr>";

                                } else {
                                    echo "<tr><th id='c1' headers='blank'>&nbsp;</th><td headers='co1 c1'><input type='hidden' name='utID[]' value='{$row['gradeSys_id']}' /><input type='text' name='updatedTitle[]' style='color:black; width: 100%;' placeholder='{$row['gradeSys_name']}'/></td><td headers='co2 c1'><input type='text' name='utPerc[]' style='color:black; width: 100%;' placeholder='{$row['gradeSys_percentage']}'/></td><td><button name='removeRow' onclick = 'deleteRow();' class='btn btn-danger' value='{$row['gradeSys_id']}'>Delete<i class='fa fa-close'></i> </button> </td></tr>";
                                }
                                
                            }
                        ?>                        
                    </table>
                    <div id='saveButton'>
                    <div style='padding: 10px;'><button name='editGradeSys' class='btn btn-success' style='margin-left: 40%; margin-top: 15px;'>Save Grading System </button></div>
                   </div>
                </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
        <!-- Header-->

        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1><?php echo $code ?></h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="index.php">Dashboard</a></li>
                            <li><?php echo $code ?></li>
                            <li class="active">Class Record Summary</li>
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
                                <strong class="card-title">Class Record Summary</strong>
                                <button type="button" class="w3-button w3-block w3-red" data-toggle="modal" style="width:30%" data-target="#viewModal">View Grading System</button>
                                <button type="button" class="w3-button w3-block w3-teal" style="width:30%"data-toggle="modal" data-target="#editModal">Edit Grading System</button>
                            </div>
                            <div class="card-body">
                                <table  class="w3-table-all w3-hoverable">
                                    <thead>
                                        <tr class="w3-green">                   
                                            <th rowspan="2">ID Number</th>
                                            <th rowspan="2">Student Name</th>
                                            <th rowspan="2">Program</th>
                                            <?php 
                                                 $sql = "SELECT * FROM gradesystem WHERE course_id = '$course'";
                        
                                                $ret = mysqli_query($conn, $sql);
                
                                                while($row = mysqli_fetch_assoc($ret)){
                                                    if($row['gradeSys_type']==0){
                                                        echo "<th class='w3-green' headers='blank' scope='colgroup' colspan='2' style='text-align: center;'>{$row['gradeSys_name']} <input type='hidden' id='aID' value='{$row['gradeSys_id']}'/></th>";
                                                    }
                                                }
                
                                            echo "<th>Total</th>";
                                            ?>


                                        </tr>
                                        <tr>
                                             <?php 
                                                $totes = 0;
                                                 $sql = "SELECT * FROM gradesystem gs 
                                                        JOIN assessment ses
                                                        ON ses.gradeSys_id = gs.gradeSys_id 
                                                        
                                                        WHERE course_id = '$course'";
                        
                                                $ret = mysqli_query($conn, $sql);
                                                
                                                
                                                while($row = mysqli_fetch_assoc($ret)){
                                                    $sql2 = "SELECT assessment_id FROM assessment WHERE gradeSys_id = '{$row['gradeSys_id']}'";
                                                    $ret2 = mysqli_query($conn, $sql2);
                                                    $row2 = mysqli_fetch_assoc($ret2);
                                                    $sql3 = "SELECT * FROM individual indiv 
                                                            JOIN score sc
                                                            ON sc.individual_id = indiv.individual_id
                                                            WHERE indiv.assessment_id = {$row2['assessment_id']}";
                                                    $ret3 = mysqli_query($conn, $sql3);
                                                    $row3 = mysqli_fetch_assoc($ret3);
                                                    
                                                    if($row['gradeSys_type']==1){
                                                        echo "<th headers='blank' style='text-align: center;'><a href='score_page.php?course_id={$course}&assess_id={$row2['assessment_id']}'>{$row['gradeSys_name']}</a> </th>";
                                                        $totes += $row3['score_score'];
                                                        
//                                                        echo $row2['assessment_id'];
                                                    }
                                                }
                                            ?>                                            
                                        </tr>
                                        
                                    </thead>
                                    <tbody>
                                        <?php

                                            $sql = "SELECT * 
                                                    FROM usercourse uc 
                                                    JOIN student s
                                                    ON uc.course_id = s.cos_id
                                                    JOIN gradesystem gs
                                                    ON s.cos_id = gs.course_id
                                                    INNER JOIN score sc
                                                    ON s.student_id = sc.scstudent_id
                                                    WHERE uc.userCourse_id = '$course'
                                                    GROUP BY s.student_lname";
                                        
                                            $ret = mysqli_query($conn, $sql);    

                                            while($row = mysqli_fetch_assoc($ret)){
                                                echo "<tr>
                                                    <td>{$row['student_id']}</td>
                                                    <td>{$row['student_lname']}, {$row['student_fname']}</td>
                                                    <td>{$row['student_program']} - {$row['student_year']}</td>
                                                    <td>1.5</td>
                                                    <td>1.5</td>
                                                    <td>1.5</td>
                                                    <td>1.5</td>
                                                    <td>1.5</td>
                                                    </tr>";  
                                            }
                                        ?>
                                    </tbody>
                                </table>
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
<script src="vendors/jquery/dist/3.3.1/jquery.min.js"></script>
<script>
    
    function deleteRow()
{
//    alert(id);
    var conf= confirm("Do you really want to delete this row?");
    if (conf== true){
       document.frm.action = "Modal.php";
       document.frm.submit();
    }else{
      return;
    }
}
    
$(document).ready(function(){
       
       $("#addTitle").click(function(){
           var addTitleRow = "<tr id='lastRow'><th id='blank'>&nbsp;</th><th id='co1' headers='blank'><input type='text' name='title[]' style='color:black; width: 100%;'/></th><th id='co2' headers='blank'><input type='text' name='perc[]' style='color:black; width: 100%;'/><input type='hidden' name ='type[]' value='0'/></th></tr>";
           
           $("#editGS").append(addTitleRow);
       });
       
       $("#addSubs").click(function(){
           var addSubsRow = "<tr><th id='c1' headers='blank'>&nbsp;</th><td headers='co1 c1'><input type='text' name='title[]' style='color:black; width: 100%;'/></td><td headers='co2 c1'><input type='text' name='perc[]' style='color:black; width: 100%;'/><input type='hidden' name='type[]' value='1'/></td></tr>";
           $("#editGS").append(addSubsRow);
       });          
    
        $("#undoRow").click(function(){
            $('#editGS tr:last').remove();
        });

});
</script>
</html>
