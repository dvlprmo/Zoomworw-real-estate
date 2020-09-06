<?php
require 'functions.php';
$pageTitle = 'Zoomorrow Real Estate';
$description = 'real estate home house apartments condo for sale for rent';

?>

<html lang="en">
    <link rel='stylesheet' href='css/main.css'>
    <?php include('inc/head.php')?> 
    <body>
        <header>
            <h1>Zoomorrow Real Estate</h1>
        </header>
        <main>
            
           
            <?php displayAboutUs(); ?>
            
            <form action='.'>
                <input type='submit' name='home_button' value='Home'>
            </form>
        </main>
        <?php require('inc/footer.php'); ?>
    </body>
</html>