<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remove User</title>
</head>
<body>
<?php
if (isset($_GET['cuid']))
{
    # Get data from form
    $uid = trim($_GET['uid']); // From the hidden field
    $cuid = trim($_GET['cuid']); // Entered by the user
    $uid = (int)$uid;
    $cuid = (int)$cuid;

    // Ideally should also verify that cid matches
    if ($cuid != $uid)
    {
        printf("You must specify a valid ID");
        printf("<br><a href=index.php>Return to home page </a>");
        exit();
    }

    # Open the database using the "admin" account
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

    // Prepare an delete statement and execute it
    $stmt = $db->prepare("delete from usersinfo where uid = ?");
    $stmt->execute(array(
        "$uid"
    ));
    printf("<br>User Removed!");
    printf("<br><a href=index.php>Return to home page </a>");
    exit;
}

?>

<h3>Confirm User ID</h3>
<hr>
<form action="removeuser.php" method="GET">
      Enter User ID:
      <INPUT type="number" name="cuid">
      <?php
$uid = trim($_GET['uid']);
echo '<INPUT type="hidden" name="uid" value=' . $uid . '>';
?>
      <INPUT type="submit" name="submit" value="Continue">
</form>
</body>
</html>
