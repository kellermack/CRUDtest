<?php

if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){

    require_once "config.php";
    // prepare statement to get custoer id 
    $sql = "SELECT * FROM customerlist WHERE id = ?";

    if($stmt = $mysqli->prepare($sql)){
        $stmt->bind_param("i", $param_id);

        $param_id = trim($_GET["id"]);
    
        //execute statement
        if($stmt->execute()){
            $result = $stmt->get_result();

            if($result->num_rows == 1){

                $row = $result->fetch_array(MYSQLI_ASSOC);

                //retrieve each fields value
                $name = $row["name"];
                $address = $row["address"];
                $phone = $row["phone"];
            }  else{
                    // if no values found seen to error page
                header("location: error.php");
                exit();
            }
        }   else{
            echo "Something bad has happened";
        }
    }

    $stmt->close();

    $mysqli->close();
} else{
    //if the url has no id param
    header("location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Read Record</title>
    <link rel = "stylesheet"
href = "https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
         }
         </style>
</head>
<body>
         <div class = "wrapper">
            <div class = "container-fluid">
                <div class = "row">
                    <div class = "col-md-12">
                        <h1 class = "mt-5 mb-3">View Record</h1>
                        <div class = "form-group">
                            <label>Name</label>
                            <p><b><?php echo $row["name"]; ?></b></p>
                        </div>
                        <div class = "form-group">
                            <label>Address</label>
                            <p><b><?php echo $row["address"]; ?></b></p>
                        </div>
                        <div class = "form-group">
                            <label>Phone</label>
                            <p><b><?php echo $row["phone"]; ?></b></p>
                        </div>
                        <p><a href = "index.php" class = "btn btn-primary">Back</a></p>
                        </div>
                    </div>
                </div>
            </div>
</body>
</html>