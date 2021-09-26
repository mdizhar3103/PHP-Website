<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remove Course</title>
</head>
<body>
<?php
if (isset($_GET['cid']))
{
    # Get data from form
    $tid = trim($_GET['tid']); // From the hidden field
    $cid = trim($_GET['cid']); // Entered by the user
    $tid = (int)$tid;
    $cid = (int)$cid;

    // Ideally should also verify that cid matches
    if ($cid != $tid)
    {
        printf("You must specify a valid ID");
        printf("<br><a href=index.php>Return to home page </a>");
        exit();
    }

    // $tid = addslashes($tid);
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
    $stmt = $db->prepare("delete from tutorials where tid = ?");
    $stmt->execute(array(
        "$tid"
    ));
    printf("<br>Course Removed!");
    printf("<br><a href=index.php>Return to home page </a>");
    exit;
}

?>

<h3>Confirm Tutorial ID</h3>
<hr>
<form action="removecourse.php" method="GET">
      Enter Tutorial ID:
      <INPUT type="number" name="cid">
      <?php
$tid = trim($_GET['tid']);
echo '<INPUT type="hidden" name="tid" value=' . $tid . '>';
?>
      <INPUT type="submit" name="submit" value="Continue">
</form>
</body>
</html>
