<?php
include '../Incl/header.php';
?>
    <div class="cont">
        <h1>Picture Gallery</h1>

        <div class="dialog" role="dialog" aria-labelledby="dialog_title">
            <div class="dialog__window">
                <button class="exbtn">X</button>
                <div class="dialog__title"></div>
                <div class="dialog__img"></div>
            <div>
                <div class="dialog__text"></div>
            </div>
            </div>
            <div class="dialog__mask"></div>
        </div>
        
        <div class="pic-content"></div>
    </div>
    <footer>
        <nav class="footer-nav">
            <li><a href="blog.php">Blog</a></li>
            <li><a href="gallery.php">Gallery</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="contact.php">Contact</a></li>
        </nav>
    </footer>
    <script src="../script.js" defer></script>
</body>
</html>