<?php    
    require("connect.php");

    
    if(!isset($_SESSION['user'])){
       header("Location:page-login.php");
    }

    $user = $_SESSION['user'];

    //$userID = $_GET['user_id'];

    $sql = "SELECT *
            FROM user 
            WHERE user_id = '$user'";

    $ret = mysqli_query($conn, $sql);
?>

<aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">

            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="./"><img src="images/logo.png" alt="Logo"></a>
                <a class="navbar-brand hidden" href="./"><img src="images/logo2.png" alt="Logo"></a>
            </div>

            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active">
                        <a href="index.php"> <i class="menu-icon fa fa-dashboard"></i>Home  </a>
                    </li>
                    <h3 class="menu-title">Grading System</h3><!-- /.menu-title -->
            
                    <li class="menu-item-has-children dropdown">    
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-table"></i>Courses</a>
                        <ul class="sub-menu children dropdown-menu">
                            <?php
                                $query = "SELECT * FROM course JOIN user ON course.user_id = user.user_id WHERE user.user_id = '$user'";
                            
                                $result = mysqli_query($conn, $query);
                            
                                while($rows = mysqli_fetch_assoc($result)){
                                    echo "<li><i class='fa fa-table''></i><a href='tables-data.php?course_id={$rows['course_id']}'>{$rows['course_title']}</a></li>";
                                }
                            ?>                            
                        </ul>
                    </li>
    
                    
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside><!-- /#left-panel -->