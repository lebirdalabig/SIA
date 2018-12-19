<!doctype html>
<html class="no-js" lang="en">
<?php
    session_start();
    require("connect.php");

    
    if(!isset($_SESSION['user'])){
       header("Location:page-login.php");
    }

    $user = $_SESSION['user'];

    $sql = "SELECT *
            FROM user
            WHERE user_id = '$user'";
    
    $ret = mysqli_query($conn, $sql);    
    
    
    
?>
<head>
    <meta charset="utf-8">  
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Parker Records</title>
    <meta name="description" content="Parker Records">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="favicon.ico">

    <link rel="stylesheet" href="vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="vendors/themify-icons/css/themify-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/selectFX/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="vendors/jqvmap/dist/jqvmap.min.css">


    <link rel="stylesheet" href="assets/css/style.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

</head>

<body>

    <?php include 'sidebar.php'; ?>

    <!-- Left Panel -->

    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">

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

        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Class</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li class="active"><a href='index.php'>Home</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
   <div name='courses'>
       
        <div class="content mt-4">
            <?php
                $query = "SELECT *
                        FROM usercourse uc
                        JOIN course c
                        ON uc.course_id = c.course_id
                        WHERE user_id = '$user'";
            
                $result = mysqli_query($conn, $query);
            
            while($rows = mysqli_fetch_assoc($result)){                
                echo"<div class='col-sm-6 col-lg-5' >
                <div class='card text-white bg-flat-color-1' >              
                <a href='tables-data.php?course_id={$rows['userCourse_id']}'>
                    <div class='card-body pb-0'>
                        <p class='text-light'>{$rows['course_title']}</p>
                        <p class='text-light'>{$rows['course_sched']}</p>
                        <p class='text-light'>{$rows['userCourse_term']} Semester of School Year {$rows['userCourse_year']}</p>
                        <div class='chart-wrapper px-0' style='height:70px;' height='70>
                            <canvas id='widgetChart2'></canvas>
                        </div>
                        </a>
                     </div>
                 </div>
            </div>";
            }            
            ?>
            <div class='col-sm-6 col-lg-5' >
                <div class='card text-white bg-flat-color-1' >              
                <a href='addCourse.php'>
                    <div class='card-body pb-0' text-align='center'>
                        <h3 class='mb-0' >
                            <i class="fa fa-plus-circle"></i>
                            <span> Add Course </span>
                        </h3>
                        <div class='chart-wrapper px-0' style='height:70px;' height='70'>
                            <canvas id='widgetChart2'></canvas>
                        </div>
                    </div>
                </a>                     
                </div>
            </div>
        </div> <!-- .content -->
    </div><!-- /#right-panel -->
</div>
    <!-- Right Panel -->

    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <script src="vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="assets/js/main.js"></script>


    <script src="vendors/chart.js/dist/Chart.bundle.min.js"></script>
    <script src="assets/js/dashboard.js"></script>
    <script src="assets/js/widgets.js"></script>
    <script src="vendors/jqvmap/dist/jquery.vmap.min.js"></script>
    <script src="vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <script src="vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script>
        (function($) {
            "use strict";

            jQuery('#vmap').vectorMap({
                map: 'world_en',
                backgroundColor: null,
                color: '#ffffff',
                hoverOpacity: 0.7,
                selectedColor: '#1de9b6',
                enableZoom: true,
                showTooltip: true,
                values: sample_data,
                scaleColors: ['#1de9b6', '#03a9f5'],
                normalizeFunction: 'polynomial'
            });
        })(jQuery);
    </script>

</body>

</html>
