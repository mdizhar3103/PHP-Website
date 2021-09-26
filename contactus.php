<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
</head>
<body>
    <?php
        // get the data from the form
        $customeremail = $_POST["customeremail"];
        $message = $_POST["message"];
        $replywanted = false;

        if (isset($_POST["replywanted"])) {
            $replywanted = true;
        }

        // Build the text of the mail
        $t = "You have recieved a message from " . $customeremail . " :\n";
        $t = $t . $message . "\n";
        if ($replywanted){
            $t = $t . "A reply was requested";
        }
        else{
            $t = $t . "No reply was requested";
        }

        // send an email to the trainer
        mail("root@localhost", "Customer Message", $t);

        // Thanking User
        echo "Thank you. Your message has been sent";
    ?>
</body>
</html>