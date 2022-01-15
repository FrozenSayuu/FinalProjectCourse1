<?php
session_start();

$db = new PDO("sqlite:thehiddencorner.db");
$stmt = $db -> prepare("SELECT * FROM login");        //Tabellen för login uppgifterna
$stmt -> execute();

$stmtBlog = $db -> prepare('SELECT * FROM blog_posts');        //Tabellen där bloggen är lagrade
$stmtBlog -> execute();

if(!empty($_POST['username']) && !empty($_POST['password'])) //Login-funktion
{
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
}
while($verify = $stmt -> fetch())
{
    if($username == $verify['username'] && $password == $verify['password'])
    {

        $_SESSION['validLogin'] = true;
        $_SESSION['loggedIn'] = $verify['username'];
        $_SESSION['loggedinId'] = $verify['user_id'];
        break;
    }
    else 
    {
        $_SESSION['validLogin'] = false;
        $_SESSION['loggedIn'] = null;
        $_SESSION['loggedinId'] = null;
    }
}

if(!empty($_POST['logout'])) //Stoppa session(Logga ut)
    {
        session_unset();
        session_destroy();
    }

if(!empty($_SESSION['loggedIn'])) //Login session-variabel
    {
        $validLogin = htmlspecialchars($_SESSION['validLogin']);
    }
    else
    {
        $validLogin = false;
    }

?>

<!DOCTYPE html>

<html lang="eng">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/blog.css">
        <link rel="icon" href="../img/symbol.png" type="image" sizes="20x20">
        <title>The Hidden Corner</title>
    </head>

    <body>
        <div id="header">
            <a class="a-s" href="../index.php"><img class="symbol" src="../img/symbol.png" width="2000" height="2000" alt="pentagram" ></a>
            <h1>Welcome to our Blog!</h1>
            <nav class="nav">
                <li><a href="blog.php">Blog</a></li>
                <li><a href="gallery.php">Gallery</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
            </nav>
        </div>

        
       <div id="form-flex">
            <form action="../html/login.html" method="post" id="knapp">
               <input type="submit" name="login" value="Log in">
            </form>
        </div>
        
        <div class="main">
            <div class="blog">
                <h1>Upcoming holiday!</h1>
                <div id="blog-sep"></div>
                <article>
                    <a href="https://www.thepeculiarbrunette.com/halloween-samhain-all-hallows-eve-ultimate-inspiration-ideas/">
                    <h2>Samhain around the corner! Are you prepared?</h2>
                    <p>Recipies for Samhain celebration! Activities what to do.</p>
                    <p>How to decorate your altar and home. What is Samhain?</p>
                    </a>
                </article>

                <h2>Recent blog posts</h2>
                <div id="blog-sep"></div>

                <?php

                    while($blog = $stmtBlog -> fetch())
                    {
                        echo <<<TABLEROW
                            <article>
                                <a href="{$blog['link']}">
                                <h2>{$blog['title']}</h2>
                                <p id="date">Published {$blog['dates']}</p>
                                <p>{$blog['blog']}</p>
                                </a>
                            </article>
                    TABLEROW;

                    }

                ?>
            </div>

            <div class="side">
                <ul class="main-side">
                    <li><h2>Categories</h2></li>
                    <div class="side-sep"></div>
                    <li class="side-item">
                        <a>Chakra</a>
                        <ul class="sub-side">
                            <li><a href="#">Crown Chakra</a></li>
                            <li><a href="#">Third Eye Chakra</a></li>
                            <li><a href="#">Throat Chakra</a></li>
                            <li><a href="#">Heart Chakra</a></li>
                            <li><a href="#">Solar Plexus Chakra</a></li>
                            <li><a href="#">Sacral Chakra</a></li>
                            <li><a href="#">Root Chakra</a></li>
                        </ul>
                    </li>
                    <div class="side-sep"></div>
                    <li class="side-item">
                        <a>Crystals</a>
                        <ul class="sub-side">
                            <li><a href="#">Jewerly</a></li>
                            <li><a href="#">Polished</a></li>
                            <li><a href="#">Natural</a></li>
                            <li><a href="#">7 Chakra</a></li>
                        </ul>
                    </li>
                    <div class="side-sep"></div>
                    <li class="side-item">
                        <a>Tarot, Oracle and Pendulum</a>
                        <ul class="sub-side">
                            <li><a href="#">Tarot card deck</a></li>
                            <li><a href="#">Oracle card deck</a></li>
                            <li><a href="#">Pendulum</a></li>
                        </ul>
                    </li>
                    <div class="side-sep"></div>
                    <li class="side-item">
                        <a>Herbs</a>
                        <ul class="sub-side">
                            <li><a href="#">Herbal Teas</a></li>
                            <li><a href="#">Cooking herbs</a></li>
                            <li><a href="#">Baking herbs</a></li>
                            <li><a href="#">Grow your own herbs</a></li>
                        </ul>
                    </li>
                    <div class="side-sep"></div>
                    <li class="side-item">
                        <a>Tools and Trinkets</a>
                        <ul class="sub-side">
                            <li><a href="#">Candle magic</a></li>
                            <li><a href="#">Potions</a></li>
                            <li><a href="#">Magic pouches</a></li>
                            <li><a href="#">Storage tips</a></li>
                        </ul>
                    </li>
                    <div class="side-sep"></div>
                    <li class="side-item">
                        <a>Incense and Oils</a>
                        <ul class="sub-side">
                            <li><a href="#">Incense sticks</a></li>
                            <li><a href="#">Incense cones</a></li>
                            <li><a href="#">Essential oils</a></li>
                            <li><a href="#">Oil burner, incense holder</a></li>
                        </ul>
                    </li>
                    <div class="side-sep"></div>
                    <li class="side-item">
                        <a>Altar</a>
                        <ul class="sub-side">
                            <li><a href="#">Closed witch tips</a></li>
                            <li><a href="#">The five elements</a></li>
                            <li><a href="#">Athame</a></li>
                            <li><a href="#">Altar cloth</a></li>
                            <li><a href="#">Decoration</a></li>
                        </ul>
                    </li>
                    <div class="side-sep"></div>
                    <li class="side-item">
                        <a>Health Tips</a>
                        <ul class="sub-side">
                            <li><a href="#">Morning routine</a></li>
                            <li><a href="#">Evening routine</a></li>
                            <li><a href="#">Bedtime routine</a></li>
                            <li><a href="#">Yoga</a></li>
                            <li><a href="#">Structure and organisation</a></li>
                            <li><a href="#">The Moon</a></li>
                        </ul>
                    </li>
                    <div class="side-sep"></div>
                    <li class="side-item">
                        <a>Mental Health Tips</a>
                        <ul class="sub-side">
                            <li><a href="#">A calm space</a></li>
                            <li><a href="#">Shadow work</a></li>
                            <li><a href="#">The Moon's cycles</a></li>
                            <li><a href="#">Routines</a></li>
                            <li><a href="#">Crystals</a></li>
                        </ul>
                    </li>
                    <div class="side-sep"></div>
                    <li class="side-item">
                        <a>The Pagan Calender</a>
                        <ul class="sub-side">
                            <li><a href="#">Yule</a></li>
                            <li><a href="#">Imbolc</a></li>
                            <li><a href="#">Ostara</a></li>
                            <li><a href="#">Beltane</a></li>
                            <li><a href="#">Litha</a></li>
                            <li><a href="#">Lughnasadh</a></li>
                            <li><a href="#">Mabon</a></li>
                            <li><a href="#">Samhain</a></li>
                        </ul>
                    </li>
                    <div class="side-sep"></div>
                    <li class="side-item">
                        <a>Deities</a>
                        <ul class="sub-side">
                            <li><a href="#">Norse Mythology</a></li>
                            <li><a href="#">Greek Mythology</a></li>
                            <li><a href="#">Asian Mythology</a></li>
                            <li><a href="#">Roman Mythology</a></li>
                            <li><a href="#">Old Native Deities</a></li>
                            <li><a href="#">Finding your suited Deity</a></li>
                            <li><a href="#">How to work with your deity/deities</a></li>
                            <li><a href="#">Offerings</a></li>
                        </ul>
                    </li>
                    <div class="side-sep"></div>
                    <li class="side-item">
                        <a>Shadow work</a>
                        <ul class="sub-side">
                            <li><a href="#">How to do it safely</a></li>
                            <li><a href="#">Keeping you motivated on the journey</a></li>
                            <li><a href="#">How to know if you are ready for it</a></li>
                        </ul>
                    </li>
                    <div class="side-sep"></div>
                    <li class="side-item">
                        <a>Grimoire and Book of Shadows</a>
                        <ul class="sub-side">
                            <li><a href="#">Grimoire</a></li>
                            <li><a href="#">Book of Shadows</a></li>
                        </ul>
                    </li>
                    <div class="side-sep"></div>
                    <li class="side-item">
                        <a>Books and Literature</a>
                        <ul class="sub-side">
                            <li><a href="#">Good starting books to read</a></li>
                            <li><a href="#">European history books</a></li>
                            <li><a href="#">American history books</a></li>
                            <li><a href="#">Empowering books</a></li>
                            <li><a href="#">Books to find your inner witch</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>

    </body>
</html>