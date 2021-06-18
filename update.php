<?php
//make sure to have the config file
require_once "config.php";

//define the variables and initialize with empty
$name = $address = $phone = "";
$nameErr = $addressErr = $phoneErr = "";

//process the data when form is submitted
if (isset($_POST["id"]) && !empty($_POST["id"])) {
    $id = $_POST["id"];

    //validate
    $inputName = trim($_POST["name"]);
    if (empty($inputName)) {
        $nameErr = "Please Enter a valid name.";
    } elseif (!filter_var(
        $inputName,
        FILTER_VALIDATE_REGEXP,
        array("options" => array("regexp" => "/^[a-zA-Z\s]+$/"))
    )) {
        $nameErr = "Please enter a valid name.";
    } else {
        $name = $inputName;
    }

    //validate address
    $inputAddress = trim($_POST["address"]);
    if (empty($inputAddress)) {
        $addressErr = "Please enter an address.";
    } else {
        $address = $inputAddress;
    }

    //Make sure we have a phone number
    $inputPhone = trim($_POST["phone"]);
    if (empty($inputPhone)) {
        $phoneErr = "Please Enter a phone number.";
    } elseif (!ctype_digit($inputPhone)) {
        $phoneErr = "Please Enter a positive integer.";
    } else {
        $phone = $inputPhone;
    }

    //Lets insert Customer notes
    $inputNotes = trim($_POST["notes"]);
    if (empty($inputNotes)) {
        $notesErr = "Please enter a customer note.";
    } else{
        $notes = $inputNotes;
    }


    //Check to make sure we have no input errors before insert into DB 
    if (empty($nameErr) && empty($addressErr) && empty($phoneErr)) {
        //update statement
        $sql = "UPDATE customerlist SET name = ?, address = ?, phone = ? WHERE id = ?";

        if ($stmt = $mysqli->prepare($sql)) {
            //Lets Bind variables in the prepared statement
            $stmt->bind_param("sssi", $paramName, $paramAddress, $paramPhone, $paramId);

            //Setting the parameters 
            $paramName = $name;
            $paramAddress = $address;
            $paramPhone = $phone;
            $paramId = $id;

            //execute prepared statement
            if ($stmt->execute()) {
                //if successful redirect to landing
                header("location: index.php");
                exit();
            } else {
                echo "Something bad has happened.";
            }
        }
        //close it all 
        $stmt->close();
    }

    $mysqli->close();
} else {
    //check to see if id param is there
    if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
        $id = trim($_GET["id"]);

        $sql = "SELECT * FROM customerlist WHERE id = ?";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("i", $paramId);

            $paramId = $id;

            if ($stmt->execute()) {
                $result = $stmt->get_result();

                if ($result->num_rows == 1) {

                    $row = $result->fetch_array(MYSQLI_ASSOC);

                    // get each field
                    $name = $row["name"];
                    $address = $row["address"];
                    $phone = $row["phone"];
                } else {
                    // if no values found seen to error page
                    header("location: error.php");
                    exit();
                }
            } else {
                echo "Something bad has happened";
            }
        }


        $stmt->close();

        
    } else {
        //if error redirect to error page
        header("location: error.php");
        exit();
    }
    if (empty($notesErr)) {
        //insert data
        $sql = "INSERT INTO customernotes (notes) VALUES (?)";

        if ($stmt = $mysqli->prepare($sql)) {
            //Lets Bind variables in the prepared statement
            $stmt->bind_param("s", $notes);

            //Setting the parameters 
            $paramNotes = $notes;
            //execute the prepared statement
            if ($stmt->execute()) {
                //if successful we will go back to landing page
                header("location: index.php");
                exit();
            } else {
                echo "Something bad happened.....try again.";
            }
        }
        //close everything
        $stmt->close();
    }
    $mysqli->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update</title>
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
                    <h2 class="mt-5">Update Records</h2>
                    <p>Please edit the values to update customer records.</p>
                    <form action=" <?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($nameErr)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $nameErr; ?></span>
                        </div>

                        <div class="form-group">
                            <label>Address</label>
                            <textarea name="address" class="form-control <?php echo (!empty($addressErr))
                                                                                ? 'is-invalid' : ''; ?>"><?php echo $address; ?></textarea>
                            <span class="invalid-feedback"><?php echo $addressErr; ?>"</span>
                        </div>

                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control <?php echo (!empty($phoneErr))
                                                                                    ? 'is-invalid' : ''; ?>" value="<?php echo $phone; ?>">
                            <span class="invalid-feedback"><?php echo $phoneErr; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Notes</label>
                            <input type="text" name="notes" class="form-control <?php echo (!empty($notesErr))
                                                                                    ? 'is-invalid' : ''; ?>" value="<?php echo $notes; ?>">
                            <span class="invalid-feedback"><?php echo $notesErr; ?></span>
                        </div>

                        <input type="hidden" name="id" value="<?php echo $id; ?>" />
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>

                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>