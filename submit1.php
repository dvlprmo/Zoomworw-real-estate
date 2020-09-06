<?php
session_start();
require 'functions.php';
$pageTitle = 'Zoomorrow Real Estate Confirmation';
$description = 'real estate contact information confirmation'
?>

<html lang="en">
    <?php include('inc/head.php')?>
    <body>
        <header>
            <h1>Zoomorrow Home Listings</h1>
        </header>
        <main>
            <h2>Your Property List</h2>
            <?php       

               $firstName = $_POST['fname'];
               $lastName = $_POST['lname'];
               $email = $_POST['email'];
               $phone = $_POST['phone'];
               $dob = $_POST['bdate'];
               $moveInDate = $_POST['moving'];

               $info = array($firstName, $lastName, $email, $phone, $dob, $moveInDate);
               $userReport = $_SESSION['userResults'];               
               
               showReport($userReport);
               showUserInfo($info);
               
               //add button to search new type and button to change user options
               resetSearch();
           ?>
        </main>
        <?php
        require('inc/footer.php');
        ?>

    </body>
</html>
