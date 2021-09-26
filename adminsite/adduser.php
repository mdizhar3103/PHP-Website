<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New User</title>
</head>
<body>
<?php
if (isset($_POST['newusername']))
{
    // This is the postback so add the book to the database
    # Get data from form
    $newusername = trim($_POST['newusername']);
    $newuseremail = trim($_POST['newuseremail']);

    if (!$newusername || !$newuseremail)
    {
        printf("You must specify both name and an email");
        printf("<br><a href=index.php>Return to home page </a>");
        exit();
    }

    $newusername = addslashes($newusername);
    $newuseremail = addslashes($newuseremail);

    # Open the database using the "librarian" account
    try
    {
        $db = new PDO("mysql:host=localhost;dbname=tutorials", "adminuser", "passwordadmin");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e)
    {
        printf("Unable to open database: %s\n", $e->getMessage());
        printf("<br><a href=index.php>Return to home page </a>");
    }

    // Prepare an insert statement and execute it
    $stmt = $db->prepare("insert into usersinfo values(null, ?, ?)");
    $stmt->execute(array(
        "$newusername",
        "$newuseremail"
    ));
    printf("<br>User Added!");
    printf("<br><a href=index.php>Return to home page </a>");
    exit;
}

// Not a postback, so present the borrower entry form

?>

<h3>Add a new User</h3>
<hr>
You must enter both a name and an email
<form action="adduser.php" method="POST">
<table bgcolor="#bdc0ff" cellpadding="6">
  <tbody>
    <tr>
      <td>Name:</td>
      <td><INPUT type="text" name="newusername"></td>
    </tr>
    <tr>
      <td>Email:</td>
      <td><INPUT type="email" name="newuseremail"></td>
    </tr>
    <tr>
      <td></td>
      <td><INPUT type="submit" name="submit" value="Add User"></td>
    </tr>
  </tbody>
</table>
</form>
</body>
</html>
