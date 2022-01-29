<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Enrolled Courses</title>
</head>
<body>
<h2>My Enrolled Courses</h2>
<?php
session_start();
# Open the database
if (isset($_GET['userid']))
{
    $userid = (int)trim($_GET['userid']);
    try
    {
        $db = new PDO("mysql:host=localhost;dbname=tutorials", "adminuser", "passwordadmin");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e)
    {
        printf("Unable to open database: %s\n", $e->getMessage());
    }

    # Build the query.
    $query = " select tid from enrolled where uid = " . $userid;
    $nested_query = " select title, author, ratings from tutorials where tid = any (" . $query . ")";
    try
    {
        $sth = $db->query($nested_query);
        $searchcount = $sth->rowCount(); # Only works for MySQL
        if ($searchcount == 0)
        {
            printf("Sorry, we did not find any enrolled courses for you.");
            printf("<br> <a href=index.php>Back to home page</a>");
            exit;
        }

        if (isset($_COOKIE['colourpreference']))
        {
            $colourpreference = $_COOKIE['colourpreference'];
        }
        else
        {
            $colourpreference = "#dddddd";
        }

        printf('<table bgcolor="%s" cellpadding="6"', $colourpreference);
        printf("<tr><td><b> Title</b> </td> <td><b> Author</b> </td> <td><b> Ratings</b> </td>");
        while ($row = $sth->fetch(PDO::FETCH_ASSOC))
        {

            printf("<tr><td> %s </td> <td> %s </td> <td> %u </td>", htmlentities($row["title"]) , htmlentities($row["author"]) , htmlentities($row["ratings"]));
        }
    }
    catch(PDOException $e)
    {
        printf("We had a problem: %s\n", $e->getMessage());
    }
    printf("</table>");
    printf("<br> We found %s enrolled tutorials", $searchcount);
    printf("<br> <a href=index.php>Back to home page</a>");
    exit;
}

?>

<h3>Enter User ID</h3>
<hr>
<form action="showmytutorials.php" method="GET">
      Enter your ID:
      <INPUT type="number" name="userid">
      <INPUT type="submit" name="submit" value="Continue">
</form>

</body>
</html>
