<?php

if (isset($_POST["id"]) && !empty($_POST["id"])) {

    require_once "config.php";

    //prepare the delete statement
    $sql = "DELETE FROM customerlist WHERE customer_id = ?";

    if ($stmt = $mysqli->prepare($sql)) {
        //bind variables
        $stmt->bind_param("i", $paramId);

        $paramId = trim($_POST["id"]);

        //Execute stmt
        if ($stmt->execute()) {
            //If successful
            header("location: index.php");
            exit();
        } else {
            echo "Looks like something didn't work right.";
        }
    }

    $stmt->close();

    $mysqli->close();
} else {
    //check for parameter
    if (empty(trim($_GET["id"]))) {
        //if no then go to error page
        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Records</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <style>
        .wrapper {
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5 mb-3">Delete Records</h2>
                    <form action=" <?php echo htmlspecialchars(basename($_SERVER['PHP_SELF'])); ?>" method="post">
                        <div class="alert alert-danger">
                            <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>" />
                            <p>Are you sure you want to delete this customer record?</p>

                            <p> <input type="submit" value="Yes" class="btn btn-danger">

                                <a href="index.php" class="btn btn-secondary ml-2">No</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>