<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Grading System </title>
    <meta name="description" content="Parker Records">
    <meta name="viewport" content="width=device-width, initial  -scale=1">

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
                        <h1>Grading System</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="index.php">Dashboard</a></li>
                            <li>Add New Grading System</li>                            
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
                                <strong class="card-title">Grading System</strong>
                            </div>
                            <div class="card-body">
                                <div style='padding: 10px;'>
                                    <button id="addCol"><i class="fa fa-plus-circle"></i> Add Column </button>
                                </div>
                            
                                    <!--  FORM -->
                                
                            <form method="POST" name="addRubric">
                                    <div class="form-group">
                                            <label for="gradingSystem">Grading System </label>
                                            <input type="text" class="form-control" id="grad_name" name='gradName' placeholder="Grading System Name">
                                    </div>  
                                    <div class="form-group">
                                            <label for="percentage">Percentage</label>
                                            <textarea class="form-control" id="grad_percent" rows="1" name='gradPercent' placeholder="Input grading percentage"></textarea>
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