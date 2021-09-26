<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update the Course</title>
</head>
<body>
<?php
$tid = trim($_GET['tid']);

$tid = addslashes($tid);

# Open the database   
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

// Prepare an update statement and execute it
$stmt = $db->prepare("update tutorials set retired=0 where tid = ?");
$stmt->execute(array(
    "$tid"
));
printf("<br>Course Updated!");
printf("<br><a href=index.php>Return to home page </a>");
exit;
?>
</body>
</html>
