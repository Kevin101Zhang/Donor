<?php
    session_start();
    $login = $_SESSION['login'];
    if(isset($login)){
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <title>Search For Donors</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
        <link rel="stylesheet" href="../Assets/CSS/index.css" type="text/css">
        <link rel="stylesheet" href="../Assets/CSS/preview.css" type="text/css">

        <script src="../assets/JS/html2canvas.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </head>

    <body>  
        <?php
            //on click of add_donor button
            if(isset($_POST['submit_add_donor'])){
                require_once('../assets/php/connection.php'); //establishes connection to the database
                
        ?>     
                <img id="cover" src="../assets/images/login-bg.jpg" >
                
                <div id="wrapper">

                    <div class="row" id="background_pic">      
                        <div class="col-2"></div>

                        <div class="col-8">
                            <div id="start"></div>

                            <div id="center"><strong><h2 id="name_here"></h2></strong></div>

                            <div id="end"></div>
                        </div>

                        <div class="col-2"></div>
                    </div>

                    <div class="jumbotron">

                        <canvas id="preview_canvas" width="950px" height="550px"></canvas> <!-- actual preview -->
                        <?php
                            // sets the form inputs as variables
                            $prefix = $_POST["prefix"];
                            $first_name = $_POST["first_name"];
                            $last_name = $_POST["last_name"];
                            $suffix = $_POST["suffix"];
                            $pc_name = $_POST["pc_name"];

                            $_SESSION['prefix'] = $prefix;
                            $_SESSION['first_name'] = $first_name;
                            $_SESSION['last_name'] = $last_name;
                            $_SESSION['suffix'] = $suffix;
                            $_SESSION['pc_name'] = $pc_name;

                            $existing_donor = "SELECT prefix, first_name, last_name, suffix FROM donor WHERE prefix = '$prefix' AND first_name = '$first_name' AND last_name = '$last_name' AND suffix = '$suffix'";
                            //there is a matching result
                            if (mysqli_num_rows(mysqli_query($mysql, $existing_donor)) > 0){ 
                        ?> 

                                <div class="alert alert-danger">
                                    <strong> <?php echo $prefix." ".$first_name." ".$last_name." ".$suffix; ?> </strong>
                                    is already an existing donor. Do you want to add a PC to the existing donor?
                                </div>
                                <form method="post" action="add_donor_result.php">
                                    <input id="input_img" name="img" type="hidden" value="">
                                    <input type="submit" value="Confirm" class="btn btn-primary">
                                </form>
                        <?php
                            }else{ //there are NO matching results
                        ?>
                                <br>
                                <form method="post" action="add_donor_result.php">
                                    <input id="input_img" name="img" type="hidden" value="">
                                    <input id="" type="submit" value="Confirm" class="btn btn-primary">
                                </form>  

                            <?php } //closing for else ?>
                        <button type="submit" class="btn btn-primary" onclick="window.history.back();">Return</button>
                    </div>  <!-- closing for jumbotron -->

                </div> <!-- closing for wrapper -->

        <?php }//closing for ifset ?>
        
        <script>
            $("#name_here").html("<?php echo $prefix." ".$first_name." ".$last_name." ".$suffix;; ?>");
            html2canvas(document.querySelector("#background_pic")).then(canvas => {
                document.body.appendChild(canvas);
                document.getElementById('input_img').value = canvas.toDataURL();
                canvas.style.display="none";

                //draw smaller canvas
                var preview_canvas = document.getElementById("preview_canvas");
                var ctx = preview_canvas.getContext("2d");
                ctx.scale(.5, .5);
                ctx.drawImage(canvas, 0, 0);
            });

        // if ( window.history.replaceState ) {
        //     window.history.replaceState( {} , 'foo', '../index_php_files/user.php' );
        // }  
        </script>
    </body>

    </html>
<?php
    }else{
        header("Location:../index_php_files/index.html");
    }
?>