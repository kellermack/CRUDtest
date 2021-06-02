<?php

// Lets Include the db connection file
require_once "config.php";

// Define variables and initialize
$name = $address = $phone = "";
$nameErr = $addressErr = $phoneErr = "";

//Process form data when it is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    //make sure we can validate name
    $inputName = trim($_POST["name"]);
    if(empty($inputName)){
        $nameErr = "Please Enter a valid name.";
    }elseif(!filter_var($inputName, FILTER_VALIDATE_REGEXP,
    array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $nameErr = "Please enter a valid name.";
    } else{
        $name = $inputName;
    }

    //validate address
    $inputAddress = trim($_POST["address"]);
    if(empty($inputAddress)){
        $addressErr = "Please enter an address.";
    } else{
        $address = $inputAddress;
    }

    //Make sure we have a phone number
    $inputPhone = trim($_POST["phone"]);
    if(empty($inputPhone)){
        $phoneErr = "Please Enter a phone number.";
    } elseif(!ctype_digit($inputPhone)){
        $phoneErr = "Please Enter a positive integer.";
    } else{
        $phone = $inputPhone;
    }

    //Check to make sure we have no input errors before insert into DB 
    if(empty($nameErr) && empty($addressErr) && empty($phoneErr)){
        //insert data
        $sql = "INSERT INTO customerlist (name, address, phone) VALUES (?, ?, ?)";

        if($stmt = $mysqli->prepare($sql)){
            //Lets Bind variables in the prepared statement
            $stmt->bind_param("sss", $paramName, $paramAddress, $paramPhone);

            //Setting the parameters 
            $paramName = $name;
            $paramAddress = $address;
            $paramPhone = $phone;

            //execute the prepared statement
            if($stmt->execute()){
                //if successful we will go back to landing page
                header("location: index.php");
                exit();
            } else{
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
    <title>Create Record</title>
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
        <div class = "row">
            <div class = "col-md-12">
                <h2 class = "mt-5">Create Record</h2>
                <p>PLease fill this form out and submit to add customer to database.</p>
                <form ation ="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method = "post">
                    <div class = "form-group">
                        <label>Name</label>
                        <input type = "text" name = "name" class="form-control
         <?php echo (!empty($nameErr)) ? 'is-invalid' : ''; ?>" value = "<?php echo $name; ?>">
         <span class = "invalid-feedback"><?php echo $nameErr;?></span>
         </div>

         <div class = "form-group">
            <label>Address</label>
            <textarea name = "address" class = "form-control <?php echo (!empty($addressErr))
            ? 'is-invalid' : ''; ?>"><?php echo $address; ?></textarea>
                <span class = "invalid-feedback"><?php echo $addressErr;?>"</span>
                </div>
        <div class ="form-group">
            <label>Phone</label> 
            <input type = "text" name = "phone" class = "form-control <?php echo (!empty($phoneErr))
            ? 'is-invalid' : ''; ?>" value = "<php echo $phone; ?>">
                <span class = "invalid-feedback"><?php echo $phoneErr;?></span>
                </div>
                <input type = "submit" class = "btn btn-primary" value = "submit">

                <a href = "index.php" class= "btn btn-secondary ml-2">Cancel</a>
                </form>
                </div>
            </div>
        </div>
     </div>

</body>
</html>