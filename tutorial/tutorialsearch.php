<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutorials Search Results</title>
</head>
<body>
    <h3>Tutorials Search Results</h3>
    <hr>
    <?php
$searchCourse = trim($_POST['searchCourse']);
$searchAuthor = trim($_POST['searchAuthor']);

$searchCourse = addslashes($searchCourse);
$searchAuthor = addslashes($searchAuthor);

if (!$searchAuthor && !$searchCourse)
{
    printf("You must specify either a title or an author");
    exit();
}

# open the database connection
try
{
    $db = new PDO("mysql:host=localhost;dbname=tutorials", "adminuser", "passwordadmin");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
    printf("Unable to open database: %s\n", $e->getMessage());
}

# build the query
$query = " select * from tutorials";
if ($searchAuthor && !$searchCourse)
{
    $query = $query . " where author like '%" . $searchAuthor . "%'";
}

if (!$searchAuthor && $searchCourse)
{
    $query = $query . " where title like '%" . $searchCourse . "%'";
}

if ($searchAuthor && $searchCourse)
{
    $query = $query . " where title like '%" . $searchCourse . "%' and author like '%" . $searchAuthor . "%'";
}

try
{
    $sth = $db->query($query);
    $tutorialCount = $sth->rowCount();
    if ($tutorialCount == 0)
    {
        printf("Sorry, we didn't find any tutorials");
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
    printf('<tr><b><td>Title</td> <td>Author</td> <td>Enroll</td> </b> </tr>');
    while ($row = $sth->fetch(PDO::FETCH_ASSOC))
    {
        $enrolluser = '<a href="enrolluser.php?enrolled=' . urlencode($row["tid"]) . '"> Enroll </a>';
        printf("<tr><b><td>%s</td> <td>%s</td></b> <td>%s</td></tr>", htmlentities($row["title"]) , htmlentities($row["author"]) , $enrolluser);
    }
}
catch(PDOException $e)
{
    printf("We had a problem: %s\n", $e->getMessage());
}
printf("</table>");
printf("<br> We found %s matching tutorials", $tutorialCount);
printf("<br> <a href=index.php>Back to home page</a>");

?>
</body>
</html>
