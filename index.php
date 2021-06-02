<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <link rel = "stylesheet"
href = "https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel = "stylesheet" href = "https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script</script> 

    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 120px;
        }
        </style>
        <script>
        $(document).ready(function(){
            $('[data-toggle = "tooltip"]').tooltip();        
        });
        </script>
</head>
<body>
<div class = "wrapper">
            <div class = "container-fluid">
                <div class = "row">
                    <div class = "col-md-12">
                        <div class = "mt-5 mb-3 clearfix">
                            <h2 class = "pull-left">Customer Details</h2>
                            <a href = "create.php" class = "btn btn-success pull-right">
                            <i class = "fa fa-plus"></i> Add New Customer</a>
                            </div>
            <?php

            require_once "config.php";

            //Attempt to select query
            $sql = "SELECT * FROM customerlist";
            if($result = $mysqli->query($sql)){
                if($result->num_rows > 0) {
                    echo '<table class = "table table-bordered table-striped">';
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th>#</th>";
                    echo "<th>Name</th>";
                    echo "<th>Address</th>";
                    echo "<th>Phone</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                    while($row = $result->fetch_array()){
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "<td>";
                        echo "<td>" . $row['name'] . "<td>";
                        echo "<td>" . $row['address'] . "<td>";
                        echo "<td>" . $row['phone'] . "</td>";
                    }
                }
            }
</body>
</html>