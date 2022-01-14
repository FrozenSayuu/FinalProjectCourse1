<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$db = new PDO("sqlite:thehiddencorner.db");
$sql = "pragma foreign_keys = on;";        //Tabellen där bloggen ska visas från
$stmtDraft = $db -> prepare($sql);
$stmtDraft -> execute();

$stmtBlog = $db -> prepare('SELECT * FROM blog_posts');        //Tabellen där bloggen är lagrade
$stmtBlog -> execute();

$stmt = $db -> prepare('SELECT * FROM login');    //Tabellen för login uppgifterna
$stmt -> execute();

if(!empty($_POST['blog']) && !empty($_POST['title'])) //Lägga till en ny blogg i db
{
    $blog = htmlspecialchars($_POST['blog']);
    $title = htmlspecialchars($_POST['title']);

    $stmtBlog = $db -> prepare("INSERT INTO blog_posts ('title', 'blog') VALUES ('{$title}','{$blog}')");
    $stmtBlog -> execute();
}

if(!empty($_POST['blog']) && !empty($_POST['title']) && !empty($_POST['date'])) //Lägga till en ny blogg i db
{
    $blog = htmlspecialchars($_POST['blog']);
    $title = htmlspecialchars($_POST['title']);
    $date = htmlspecialchars($_POST['date']);

    $stmtBlog = $db -> prepare("INSERT INTO blog_posts ('title', 'blog', 'dates') VALUES ('{$title}','{$blog}', '{$date}')");
    $stmtBlog -> execute();
}

if(!empty($_POST['blog']) && !empty($_POST['link']) && !empty($_POST['title']) && !empty($_POST['date'])) //Lägga till en ny blogg och länk i db
{
    $blog = htmlspecialchars($_POST['blog']);
    $title = htmlspecialchars($_POST['title']);
    $link = htmlspecialchars($_POST['link']);
    $date = htmlspecialchars($_POST['date']);

    $stmtBlog = $db -> prepare("INSERT INTO blog_posts ('title','blog', 'link', 'dates') VALUES ('{$title}','{$blog}', '{$link}' , '{$date}')");
    $stmtBlog -> execute();
}

if(!empty($_POST['delete'])) //Ta bort bloggen från db
{
    $delete = htmlspecialchars($_POST['delete']);

    $stmtDelete = $db -> prepare("DELETE FROM blog_posts WHERE id=('{$delete}')");
    $stmtDelete -> execute();
}

if(!empty($_POST['title']) && !empty($_POST['post']) && !empty($_POST['id']) && !empty($_POST['date'])) //Spara ändringen
{
    $title = htmlspecialchars($_POST['title']);
    $post = htmlspecialchars($_POST['post']);
    $id = htmlspecialchars($_POST['id']);
    $date = htmlspecialchars($_POST['date']);

    $stmtEdit = $db -> prepare("UPDATE blog_posts SET title=('{$title}'), blog=('{$post}'), dates=('{$date}') WHERE id=('{$id}')");
    $stmtEdit -> execute();
}
else if(!empty($_POST['title']) && !empty($_POST['post']) && !empty($_POST['id'])) //Spara ändringen utan datum
{
    $title = htmlspecialchars($_POST['title']);
    $post = htmlspecialchars($_POST['post']);
    $id = htmlspecialchars($_POST['id']);

    $stmtEdit = $db -> prepare("UPDATE blog_posts SET title=('{$title}'), blog=('{$post}') WHERE id=('{$id}')");
    $stmtEdit -> execute();
}

if(!empty($_POST['visible'])) //Visa bloggen för inloggade
{
    $visible = htmlspecialchars($_POST['visible']);

    $sql = "INSERT INTO visible ('id') VALUES ('{$visible}')";
    $stmtDraft = $db -> prepare($sql);
    $stmtDraft -> execute();
}

if(!empty($_POST['delete'])) //Ta bort bloggen från db
{
    $delete = htmlspecialchars($_POST['delete']);

    $stmtDelete = $db -> prepare("DELETE FROM visible WHERE id=('{$delete}')");
    $stmtDelete -> execute();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/blog.css">
        <link rel="icon" href="../img/symbol.png" type="image" sizes="20x20">
        <title>Admin</title>
    </head>

    <body>
        <h1 id="h1-admin">Admin page</h1>

        <form action="../html/blog.php" method="post" id="knapp">
            <input type="submit" name="logout" value="Log out">
        </form>

        <div id="admin-cont">
            <h2 id="h2-admin">Blog posts</h2>

            <table>
                <tr>
                    <th>Title</th>
                    <th>Post</th>
                    <th>Date</th>
                </tr>

                <?php

                while($blog = $stmtBlog -> fetch())
                {
                    echo <<<TABLEROW
                        <tr>
                            <td id="b">{$blog['title']}</td>
                            <td id="b">{$blog['blog']}</td>
                            <td id="b">{$blog['dates']}</td>

                            <form action="admin.php" method="post">
                                <td><input type="submit" value="X" id="delete"></td>
                                <input type="hidden" name="delete" value="{$blog['id']}">
                            </form>

                            <form action="admin.php" method="post">
                                <td><input type="submit" value="✎" id="edit"></td>
                                <input type="hidden" name="id" value="{$blog['id']}">
                                <input type="hidden" name="edittitle" value="{$blog['title']}">
                                <input type="hidden" name="editpost" value="{$blog['blog']}">
                                <input type="hidden" name="editdate" value="{$blog['dates']}">
                            </form>

                            <form action="admin.php" method="post">
                                <td><input type="submit" value="✓" id="check"></td>
                                <input type="hidden" name="visible" value="{$blog['id']}">
                            </form>

                        </tr>
                    
    TABLEROW;

                }

                ?>
            </table>

    <?php
    if(!empty($_POST['edittitle']) && !empty($_POST['editpost']) && !empty($_POST['id'])) //Updatera blogg inlägget
    {
        $edittitle = htmlspecialchars($_POST['edittitle']);
        $editpost = htmlspecialchars($_POST['editpost']);
        $editdate;
        $id = htmlspecialchars($_POST['id']);
                
        if(!empty($_POST['edittitle']) && !empty($_POST['editpost']) && !empty($_POST['id']) && !empty($_POST['editdate']))
            {
            $editdate = htmlspecialchars($_POST['editdate']);
            $edittitle = htmlspecialchars($_POST['edittitle']);
            $editpost = htmlspecialchars($_POST['editpost']);
            $id = htmlspecialchars($_POST['id']);
                    
            echo <<<TABLEROW
                <div>
                    <h3>Edit the blog post</h3>
                    <form action="admin.php" method="post" id="ny">
                        <label>Title:</label><textarea name="title">{$edittitle}</textarea></p>
                        <label>Post:</label><textarea rows="5" cols="50" name="post">{$editpost}</textarea></p>
                        <label>Date:</label><textarea name="date">{$editdate}</textarea></p>
                        <input type="hidden" name="id" value="{$id}">
                    
                        <p><input type="submit" value="Save"></p>
                    </form>
                </div              
        TABLEROW;
        }else{
            echo <<<TABLEROW
            <div>
                <h3>Edit the blog post</h3>
                <form action="admin.php" method="post" id="ny">
                    <label>Title:</label><textarea name="title">{$edittitle}</textarea></p>
                    <label>Post:</label><textarea rows="5" cols="50" name="post">{$editpost}</textarea></p>
                    <label>Date:</label><textarea name="date">{$editdate}</textarea></p>
                    <input type="hidden" name="id" value="{$id}">
                
                    <p><input type="submit" value="Save"></p>
                </form>
            </div
                    
    TABLEROW;
        }
    }
    ?>
                <div id="add-post">
                    <h3>Add a blog post</h3>
                    <form action="../html/admin.php" method="post" id="ny">
                        <p><label for="inputTitle">Title:</label>
                        <input type="text" name="title" required></p>

                        <p><label for="inputBlog">Blog:</label>
                        <input type="text" name="blog" required></p>

                        <p><label for="inputLink">Link:</label>
                        <input type="text" name="link"></p>

                        <p><label for="inputDate">Date:</label>
                        <input type="text" name="date"></p>

                        <p><input type="submit" value="Add"></p>
                    </form>
                </div>

                    <h2 id="h2-admin">Draft posts for the logged in users</h2>

                <table>
                <tr>
                    <th>Title</th>
                    <th>Post</th>
                    <th>Date</th>
                </tr>

                <?php 

                $stmtVisible = $db -> prepare('SELECT * FROM visible NATURAL JOIN blog_posts');
                $stmtVisible -> execute();

                while($draft = $stmtVisible -> fetch())
                {
                    echo <<<TABLEROW
                        <tr>
                            <td id="b">{$draft['title']}</td>
                            <td id="b">{$draft['blog']}</td>
                            <td id="b">{$draft['dates']}</td>

                            <form action="admin.php" method="post">
                                <td><input type="submit" value="X" id="delete"></td>
                                <input type="hidden" name="delete" value="{$draft['id']}">
                            </form>
                        </tr>
    TABLEROW;

                }

                ?>

                </table>
            </div>
    </body>
</html>