<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remove User</title>
</head>
<body>
<?php
if (isset($_GET['yourid']))
{
    # Get data from form
    $enrolled = (int)trim($_GET['enrolled']); // From the hidden field
    $yourid = trim($_GET['yourid']); // Entered by the user
    $yourid = (int)$yourid;

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

    $query = " select * from usersinfo where uid = " . $yourid;
    $sth = $db->query($query);
    $fuid = $sth->rowCount();
    if ($fuid == 0)
    {
        printf("You must specify a valid ID, user not found or invalid ID");
        printf("<br><a href=index.php>Return to home page </a>");
        exit();
    }
    // Prepare an insert statement and execute it
    $stmt = $db->prepare("insert into enrolled values
    (?, ?)");
    $stmt->execute(array(
        "$enrolled",
        "$yourid"
    ));
    printf("<br>User Enrolled!");
    printf("<br><a href=index.php>Return to home page </a>");
    exit;
}

?>

<h3>Confirm User ID</h3>
<hr>
<form action="enrolluser.php" method="GET">
      Enter User ID:
      <INPUT type="number" name="yourid">
      <?php
$enrolled = trim($_GET['enrolled']);
echo '<INPUT type="hidden" name="enrolled" value=' . $enrolled . '>';
?>
      <INPUT type="submit" name="submit" value="Continue">
</form>
</body>
</html>
