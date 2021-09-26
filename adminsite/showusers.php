<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrative Users Search</title>
</head>
<body>
<h3>Users Search Results</h3>
<hr>
<?php
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
$query = " select * from usersinfo";

try
{
    $sth = $db->query($query);
    $searchcount = $sth->rowCount(); # Only works for MySQL
    if ($searchcount == 0)
    {
        printf("Sorry, we did not find any registered users");
        printf("<br> <a href=index.php>Back to home page</a>");
        exit;
    }

    printf('<table bgcolor="%s" cellpadding="6">', "#dddddd");
    while ($row = $sth->fetch(PDO::FETCH_ASSOC))
    {
        $removeuser = '<a href="removeuser.php?uid=' . urlencode($row["uid"]) . '">Remove User</a>';

        printf("<tr><td> %u </td> <td> %s </td> <td> %s </td> <td> %s </td>", htmlentities($row["uid"]) , htmlentities($row["name"]) , htmlentities($row["email"]) , $removeuser);
    }
}
catch(PDOException $e)
{
    printf("We had a problem: %s\n", $e->getMessage());
}
printf("</table>");
printf("<br> We found %s registered users", $searchcount);
printf("<br> <a href=index.php>Back to home page</a>");
?>
</body>
</html>
