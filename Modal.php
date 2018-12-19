
<!DOCTYPE html>
<html>
<?php
     session_start();
    require("connect.php");

    
    if(!isset($_SESSION['user'])){
       header("Location:index.php");
    }

    $user = $_SESSION['user'];
   // $course = $_GET['course_id'];
    
    $query = "SELECT * FROM gradeSystem WHERE course_id = 2";
                        
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
                $addQuery = $addQuery." (null, '$z', '$newPerc[$x]', '$newType[$x]', '2') ,";
            }
            $addQuery = substr($addQuery,0,-1);
            mysqli_query($conn, $addQuery);


            $queryFetch = "SELECT gradeSys_id, gradeSys_name FROM gradeSystem WHERE course_id = '2'";

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
	<title></title>
	  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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

.but{
  margin-left:85%;
}
</style>
</head>
<body>

<div class="container">
  <h2>Add</h2>
  <!-- Trigger the modal with a button -->
  <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#viewModal">View Grading System</button>
    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#editModal">Edit Grading System</button>

    
    
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
                            $query = "SELECT * FROM gradeSystem WHERE course_id = 2";
                            $input = mysqli_query($conn, $query);
                        
                            while($row = mysqli_fetch_assoc($input)){
                                if($row['gradeSys_type'] == 0){
                                    echo "<tr id='titleRow'><th id='blank'>&nbsp;</th><th id='co1' headers='blank'>{$row['gradeSys_name']}</th><th id='co2' headers='blank'>{$row['gradeSys_percentage']} &percnt;</th></tr>";
                                } else {
                                   echo "<tr><th id='c1' headers='blank'>&nbsp;</th><td headers='co1 c1'>{$row['gradeSys_name']}</td><td headers='co2 c1'>{$row['gradeSys_percentage']} &percnt;</td></tr>";
                                }
                            }
                        ?>
                        <tr id='totalRow'>
                            <th id='blank'>&nbsp;</th>
                            <th id='co1' headers='blank'>TOTAL</th>
                            <th id='co2' headers='blank'>100%</th>
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
                        
                            $query = "SELECT * FROM gradeSystem WHERE course_id = 2";
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
  
</div>
</body>
</html>
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