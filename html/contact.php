<?php 

$db = new PDO("sqlite:thehiddencorner.db");

$stmt = $db -> prepare('SELECT * FROM contact');
$stmt -> execute();

if(!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['message'])) //Lagra info i db
{
    $name = htmlspecialchars($_POST['name']);
    $mail = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    $msg = "Thanks for your email! \n We'll reply shortly! \n Blessed be~";
    mail($mail, "no-reply", $msg);

    $stmt = $db -> prepare("INSERT INTO contact ('mail', 'name', 'message') VALUES ('{$mail}','{$name}', '{$message}')");
    $stmt -> execute();
}

include '../Incl/header.php';
?>
        <div class="cont">
            <h1>Contacts</h1>
            
            <div class="contact">
                <img id="border" src="../img/border.png" width="1782" height="2694" alt="gothic border">
                    <div id="contact">

                    <div id="form">
                        <h2>Contact me here!</h2>
                        <form action="" method="post">
                            <p><label>Name: </label>
                            <input type="text" name="name" required></p>

                            <p><label>Email: </label>
                            <input type="mail" name="email" required></p>

                            <p><label>Message: </label></p>
                            <textarea rows="10" cols="50" name="message" required></textarea>

                            <p><input type="submit" value="Send"></p>
                        </form>
                    </div>
                        <div id="icons">
                            <a href="https://www.instagram.com/tofo0811/"><img src="../img/instagram.png" alt="instagram">Instagram</a>
                            <a href="https://linktr.ee/Tofo0811"><img src="../img/linktree.png">LinkTree</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<?php
include '../Incl/footer.php';
?>