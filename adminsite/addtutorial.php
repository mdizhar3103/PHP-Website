<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Course</title>
</head>
<body>
<?php
if (isset($_POST['newcoursetitle'])) {
    // This is the postback so add the book to the database
    # Get data from form
    $newcoursetitle = trim($_POST['newcoursetitle']);
    $newcourseauthor = trim($_POST['newcourseauthor']);
    $coursedate = trim($_POST['coursedate']);
    if (!$newcoursetitle || !$newcourseauthor) {
        printf("You must specify both a course title and an author");
        printf("<br><a href=index.php>Return to home page </a>");
        exit();
    }
    $newcoursetitle = addslashes($newcoursetitle);
    $newcourseauthor = addslashes($newcourseauthor);
    $coursedate = addslashes($coursedate);
    # Open the database using the "adminuser" account
    try {
        $db = new PDO("mysql:host=localhost;dbname=tutorials", "adminuser", "passwordadmin");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e) {
        printf("Unable to open database: %s\n", $e->getMessage());
        printf("<br><a href=index.php>Return to home page </a>");
    }
    // Prepare an insert statement and execute it
    $stmt = $db->prepare("insert into tutorials values
    (null, ?, ?, ? , 0, false)");
    $stmt->execute(array("$newcoursetitle", "$newcourseauthor", "$coursedate"));
    printf("<br>Course Added!");
    printf("<br><a href=index.php>Return to home page </a>");
    exit;
}
// Not a postback, so present the book entry form

?>

<h3>Add a new Course</h3>
<hr>
You must enter both a course title and an author
<form action="addtutorial.php" method="POST">
<table bgcolor="#bdc0ff" cellpadding="6">
  <tbody>
    <tr>
      <td>Course Title:</td>
      <td><INPUT type="text" name="newcoursetitle"></td>
    </tr>
    <tr>
      <td>Author:</td>
      <td><INPUT type="text" name="newcourseauthor"></td>
    </tr>
    <tr>
      <td>Publish Date:</td>
      <td><INPUT type="text" name="coursedate" placeholder="YYYY-MM-DD"></td>
    </tr>
    <tr>
      <td></td>
      <td><INPUT type="submit" name="submit" value="Add Course"></td>
    </tr>
  </tbody>
</table>
</form>
</body>

</html>
