<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrative Tutorials Search</title>
</head>
<body>
<h3>Tutorials Search Results</h3>
<hr>
<?php
# Get data from form
$searchtitle = trim($_POST['searchtitle']);
$searchauthor = trim($_POST['searchauthor']);

if (!$searchtitle && !$searchauthor)
{
    printf("You must specify either a title or an author");
    exit();
}

$searchtitle = addslashes($searchtitle);
$searchauthor = addslashes($searchauthor);

# Open the database
try
{
    $db = new PDO("mysql:host=localhost;dbname=tutorials", "adminuser", "passwordadmin");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
    printf("Unable to open database: %s\n", $e->getMessage());
}

# Build the query. You are allowed to search on title, author, or both
$query = " select * from tutorials";
if ($searchtitle && !$searchauthor)
{ // Title search only
    $query = $query . " where title like '%" . $searchtitle . "%'";
}
if (!$searchtitle && $searchauthor)
{ // Author search only
    $query = $query . " where author like '%" . $searchauthor . "%'";
}
if ($searchtitle && $searchauthor)
{ // Title and Author search
    $query = $query . " where title like '%" . $searchtitle . "%' and author like '%" . $searchauthor . "%'";
}

try
{
    $sth = $db->query($query);
    $searchcount = $sth->rowCount(); # Only works for MySQL
    if ($searchcount == 0)
    {
        printf("Sorry, we did not find any matching books");
        printf("<br> <a href=index.php>Back to home page</a>");
        exit;
    }

    printf('<table bgcolor="%s" cellpadding="6">', "#dddddd");
    while ($row = $sth->fetch(PDO::FETCH_ASSOC))
    {
        $removecourse = '<a href="removecourse.php?tid=' . urlencode($row["tid"]) . '">Remove Course</a>';
        if ($row["retired"])
        {
            $retirecourse = '<a href="updatecourse.php?tid=' . urlencode($row["tid"]) . '">Course has been retired, click to Update Course</a>';
        }
        else
        {
            $retirecourse = '<a href="retirecourse.php?tid=' . urlencode($row["tid"]) . '">Retire Course</a>';
        }
        printf("<tr><td> %u </td> <td> %s </td> <td> %s </td> <td> %s </td> <td> %s </td> </tr>", htmlentities($row["tid"]) , htmlentities($row["title"]) , htmlentities($row["author"]) , $removecourse, $retirecourse);
    }
}
catch(PDOException $e)
{
    printf("We had a problem: %s\n", $e->getMessage());
}
printf("</table>");
printf("<br> We found %s matching books", $searchcount);
printf("<br> <a href=index.php>Back to home page</a>");
?>
</body>
</html>
