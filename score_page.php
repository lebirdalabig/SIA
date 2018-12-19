<!doctype html>
<html class="no-js" lang="en">
<head>
	<?php 
     session_start();
    require("connect.php");

    
    if(!isset($_SESSION['user'])){
       header("Location:page-login.php");
    }
         $course = $_GET['course_id'];
        $assessment = $_GET['assess_id'];
    
         if(isset($_POST['addIndividAct'])){
             $indivName = mysqli_real_escape_string($conn, $_POST['newIndivName']);
             $indivType = mysqli_real_escape_string($conn, $_POST['type']);
             $passScore = mysqli_real_escape_string($conn, $_POST['passingScore']);
             $rubric = mysqli_real_escape_string($conn, $_POST['rubricSelected']);
             $studID = $_POST['studID'];
            $studScore = $_POST['studScore'];
             
             
             $sql = "INSERT INTO individual(individual_id, individual_name, individual_type, individual_passing, assessment_id) 
             VALUES(null, '$indivName', '$indivType', '$passScore', $assessment)";
             
             mysqli_query($conn, $sql);
             
             $fetchID = "SELECT individual_id FROM individual WHERE individual_name = '$indivName' AND assessment_id = '$assessment'";
             
             $ret = mysqli_query($conn, $fetchID);
                          
             $fetch = mysqli_fetch_assoc($ret);
             $indivID = $fetch['individual_id'];
             
             if($rubric != "None"){
                 $addRubric = "INSERT INTO rubriccon(con_id, rubric_id, individual_id) VALUES(null, '$rubric', $indivID)";
                 mysqli_query($conn, $addRubric);
             }
             
            $addScores = "INSERT INTO score(score_id, score_score, individual_id, scstudent_id) VALUES ";
             
             foreach($studScore as $i => $s){                 
                 $addScores = $addScores." (null, '$s', '$indivID', '$studID[$i]') ,";                         
             }
             
             $addScores = substr($addScores,0,-1);
             mysqli_query($conn, $addScores);
         }
    
    if(isset($_POST['addRubric'])){
        
        $rubricName = mysqli_real_escape_string($conn, $_POST['rubricName']); 
        $rubricDesc = mysqli_real_escape_string($conn, $_POST['rubricDesc']); 
        
        
        
        $title = $_POST['headerTitle']; 
        $description = $_POST['headerDesc']; 
        $grade = $_POST['headerGrade'];

        $sqlRubric = "INSERT INTO rubric(rubric_id, rubric_name, rubric_desc) VALUES (null, '$rubricName', '$rubricDesc')";
        
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
<div>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Score</title>
    <meta name="description" content="Sufee Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="favicon.ico">

    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <script src="vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="assets/js/main.js"></script>

    <script src="vendors/jquery/dist/jquery.dataTables.min.js"></script>
    <script src="vendors/jquery/dist/jquery-3.3.1.js"></script>
    
    

<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

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
    
    <link rel="stylesheet" href="vendors/bootstrap/dist/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="vendors/themify-icons/css/themify-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/selectFX/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="vendors/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="vendors/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css">

    <link rel="stylesheet" href="assets/css/style.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
    </div>
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

.w3-button{
    margin-top: 5%;
    margin-bottom: 5px;
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

.but{
  margin-left:85%;
}
    
    .modal-dialog{
        max-width: 80%;
        height: 800px;
            
    }
    
    .modal-content {
        height 60%;
    }
</style>
</head>

<body>
    <?php include 'sidebar.php'; ?>

        <!-- Header-->
        <header id="header" class="header">

            <div class="header-menu">

                <div class="col-sm-7">
                    <a id="menuToggle" class="menutoggle pull-left"><i class="fa fa fa-tasks"></i></a>
                    <div class="header-left">
                        <!-- <button class="search-trigger"><i class="fa fa-search"></i></button> -->
                        <div class="form-inline">
                            <form class="search-form">
                               <!--  <input class="form-control mr-sm-2" type="text" placeholder="Search ..." aria-label="Search">
                                <button class="search-close" type ="submit"><i class="fa fa-close></i></button> -->
                            </form>
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
    <div class="col-md-offset-4">
<button type='button' class="w3-button w3-block w3-red" id="addAct" data-toggle="modal" data-target="#viewModal">Add New Activity</button> 
<button type='button' class="w3-button w3-block w3-teal"  id="addAct" data-toggle="modal" data-target="#rubricModal">Add New Rubric</button>    
    </div>
    <table id="example"  class="w3-table-all w3-hoverable" style="width:100%">
        <thead>
            <tr id='students' class='w3-white'>
                <th rowspan = "2">ID Number</th>
                <th rowspan = "2">Student Name</th>
                <?php
                    $sql = "SELECT * FROM assessment WHERE assessment_id = $assessment";
                        
                    $ret = mysqli_query($conn, $sql);
                
                    $row = mysqli_fetch_assoc($ret);
                
                                        echo "<th id='title' headers='blank' scope='colgroup' colspan='100' style='text-align: center;'>{$row['assessment_name']} <input type='hidden' id='aID' value='{$row['assessment_id']}'/></th><th>Total</th></tr>";
                    
                    
                ?>
            </tr>            
            <tr id = 'displayAct'>
            	<?php  
                    $sql = "SELECT * FROM individual WHERE assessment_id = '$assessment' ORDER BY individual_name ASC";
                        
                    $ret = mysqli_query($conn, $sql);
                
                    while($row = mysqli_fetch_assoc($ret)){                   
                        echo "<th id='title' headers='blank'><a href='#modalforEdit' id='{$row['individual_id']}' data-toggle='modal' data-target='#modalforEdit' class='openEdit'>{$row['individual_name']}</a> (Scores) </th><input type='hidden' id='aID' value='{$row['individual_id']}'/>";
                    }

                ?>
            </tr>
        </thead>
        <tbody>
            <?php

                $sql = "SELECT s.student_id, s.student_lname, s.student_fname
                        FROM student s 
                        JOIN score sc 
                        ON s.student_id = sc.scstudent_id 
                        JOIN individual i
                        ON sc.individual_id = i.individual_id
                        JOIN course c 
                        ON s.cos_id = c.course_id 
                        WHERE c.course_id = '$course' AND
                        i.assessment_id = '$assessment'
                        GROUP BY s.student_id
                        ORDER BY s.student_id ASC, 
                        i.individual_name ASC";

                $ret = mysqli_query($conn, $sql);
                $totalsc = 0;
                while($row = mysqli_fetch_assoc($ret)){  
                    echo "<tr id='student'>
                    <td>{$row['student_id']}</td>
                    <td>{$row['student_lname']}, {$row['student_fname']}</td>";
                    
                    $sqlScore = "SELECT * 
                        FROM score sc
                        JOIN individual i
                        ON sc.individual_id = i.individual_id  
                        WHERE sc.scstudent_id = '{$row['student_id']}'";
                    
                        $retScores = mysqli_query($conn, $sqlScore);
                    
                    while($score = mysqli_fetch_assoc($retScores)){
                        echo "<td>{$score['score_score']}</td>";
                        $totalsc+=$score['score_score'];
                    }
                    echo "<td>$totalsc</td></tr>";                              
                }              
                
            ?>
        </tbody>
    </table>
    
<div class='container'>
    
                    <!--M O D A L FOR ADD INDIV-->
    <div class="modal fade" id="viewModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Add New Activity</h4>
        </div>
        <div class="modal-body" >     
        <form method='POST' name='addNewAct'>
                <label for="actType"><h5>Scoring Type: </h5></label>
                <div id='actType' style='margin-left:30px;'>
                    <input id= 'typeI' type="radio" name="type" value="rubric"> Rubric <br>
                    <input type="radio" name="type" value="score based"> Score Based <br>
                </div>
            <hr>
            <p>If rubric is selected, please select a rubric.</p>
            <label for="rubricSelect"><h5>Rubric: </h5></label>
            <div id='rubricSelect'>
                
                <select name='rubricSelected'>
                  <option value="None" selected='selected'>None</option>
                    <?php

                        $sql = "SELECT * FROM rubric";
                        $query = mysqli_query($conn, $sql);
                    
                        while($row = mysqli_fetch_assoc($query)){
                            echo "<option value='{$row['rubric_id']}' >{$row['rubric_name']}</option>";
                        }
                    ?>
                </select>
            </div>
            <br><hr>
        <label for="passScore">Scoring:</label>
            <div id='passScore'>
                <p>Total Score:</p>
                <input type='number' step='0.01' name='passingScore' min=0/>
                <br>
                <p>Passing Score:</p>
                <input type='number' step='0.01' name='passingScore' min=0/>
                <br>
            </div>
            <br>
            <hr>
            <h6>New Activity Name: </h6> <input type='text' name='newIndivName' />
            <br>
            <hr>
        <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr id="students">
                <th rowspan = "2">ID Number</th>
                <th rowspan = "2">Student Name</th>
                <th rowspan = "2">Student Scores</th>
            </tr>            
            <tr id = 'newAct'>
<!--            	<th id='title' headers='blank'> </th>-->
            </tr>
        </thead>
        <tbody>
            <?php

                $sql = "SELECT s.student_id, s.student_lname, s.student_fname, sc.score_score 
                        FROM student s 
                        JOIN score sc 
                        ON s.student_id = sc.scstudent_id 
                        JOIN usercourse uc
                        ON s.cos_id = uc.usercourse_id 
                        WHERE uc.usercourse_id = '$course' 
                        GROUP BY s.student_id";

                $ret = mysqli_query($conn, $sql);
            
                
                while($row = mysqli_fetch_assoc($ret)){
                    echo "<tr>
                    <td>{$row['student_id']}</td>
                    <td>{$row['student_lname']}, {$row['student_fname']}</td> 
                    <td><input type='number' step='0.01' name='studScore[]' min='0' /> <input name='studID[]' type='hidden' value='{$row['student_id']}'/></td>
                    </tr>";                                       
                }  
                
            ?>
        </tbody>   
            </table>
                <div id='saveButton'>
                    <div style='padding: 10px;'><button name='addIndividAct' class='btn btn-success' style='margin-left: 40%; margin-top: 15px;'> Add </button></div>
                   </div>
                </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
    
                    <!--    M O DA L  FOR EDIT-->
<!--
    <div class="modal fade" id="modalforEdit" role="dialog">
    <div class="modal-dialog">
    
       Modal content
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Viewing </h4>
        </div>
        <div class="modal-body" >     
            <input type='hidden' id='holdIndivID' val=''/>
        <form method='POST' name='updateAct'>
            
                <label for="actType">Scoring Type: </label>
                <div id='actType'>
                    <input id= 'typeI' type="radio" name="type" value="rubric"> Rubric <br>
                    <input type="radio" name="type" value="score based"> Score Based <br>
                </div>
        <label for="passScore">Passing Score:</label>
            <div id='passScore'>
                <input type='number' step='0.01' name='passingScore' min=0 placeholder=''/>
                <br>
            </div>
        <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr id="students">
                <th rowspan = "2">ID Number</th>
                <th rowspan = "2">Student Name</th>
            </tr>            
            <tr id = 'upAct'></tr>
        </thead>
        <tbody>
            php
                $sql = "SELECT s.student_id, s.student_lname, s.student_fname, sc.score_score 
                        FROM student s 
                        JOIN score sc 
                        ON s.student_id = sc.scstudent_id 
                        JOIN course c 
                        ON s.cos_id = c.course_id 
                        WHERE c.course_id = 2 
                        GROUP BY s.student_id";

                $ret = mysqli_query($conn, $sql);
                $x = 0;
                
                while($row = mysqli_fetch_assoc($ret)){
                    echo "<tr>
                    <td>{$row['student_id']}</td>
                    <td>{$row['student_lname']}, {$row['student_fname']}</td> 
                    <td><input id='upScore[{$x}]' type='number' step='0.01' name='upScore[]' min='0' /> <input id='upID[{$x}]' name='upSID[]' type='hidden' value='{$row['student_id']}'/> </td>
                    </tr>";
                    $x++;
                }  
                
            ?>
        </tbody>   
            </table>
                <div id='saveButton'>
                    <div style='padding: 10px;'><button name='addIndividAct' class='btn btn-success' style='margin-left: 40%; margin-top: 15px;'> Add </button></div>
                   </div>
                </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
-->
<!--  </div>-->
    
                <!--     ADD NEW RUBRIC MODAL -->
    <div class="modal fade" id="rubricModal" role="dialog">
    <div class="modal-dialog" style="width: 100%">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Add New Rubric</h4>
        </div>
        <div class="modal-body" >     
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
                        </div> 
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
    <script src="vendors/jquery/dist/3.3.1/jquery.min.js"></script>

<script>

$(document).ready(function() {  
    $(".openEdit").on("click", function(){
        var indivID = $(this).data('id');
        var upName = "<th id='title' headers='blank'><input type='text' name='updatedName' /></th>";
        
        $("#upAct").append(upName);
    });
    
    $("#addCol").click(function(){       
        
        var head = "<th scope='col' ><input type='text' name='headerTitle[]' style='width:100%;' placeholder='Input title'/></th>";     
        $("#tableHead").append(head);
              
        var headGrade = "<th scope='col'><input type='text' style='width:100%;' name='headerGrade[]' placeholder='Input grade'/></th>";
        $("#tableHead").append(headGrade);
       
        var row = "<td colspan='2'><textarea name='headerDesc[]' style='width:100%;' placeholder='Input description'></textarea></td>";
        $("#tableSub").append(row);
    });
} );
</script>
</html>
