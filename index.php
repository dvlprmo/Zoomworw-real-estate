<?php
session_start();

require 'functions.php';
$pageTitle = 'Zoomorrow Real Estate';
$description = 'real estate home house apartments condo for sale for rent';

if(!isset($_SESSION['listings'])) {
    $arrr = ReadFirst();
    
    $_SESSION['listings'] = $arrr;
}
if (isset($_SESSION['userResults'])){
    unset($_SESSION['userResults']);
}
    
?>
<html lang="en">
    <?php include('inc/head.php')?>    
    <body>
        <header>
            <h1>Zoomorrow Home Listings</h1>
        </header>
        <main>
            
            <h2>Start Your Home Search</h2>
            <div class='landing_choice'>   
            <form class="imgs" action="properties.php" method="POST">                
                <input type='hidden' name="apartment" value="apartment"> 
                <input type='image' src="images/apt.jpg" name="apt_button" class='apt_fig' value="apartment">
            </form>    
            <form class="imgs" action="properties.php" method="POST">                            
                <input type='hidden' name="house" value="house"> 
                <input type='image' src="images/house.jpg" name="house_button" class='house_fig' value="house">
            </form>
            <form class="imgs" action="properties.php" method="POST">                            
                <input type='hidden' name="condo" value="condo"> 
                <input type='image' src="images/condo.jpg" name="condo_button" class='condo_fig' value="condo">                
            </form>
            
            </div>
            <form action='about.php'>
                <input type='submit' name='about_button' value='About Us'>
            </form>
        </main>
        <?php
        require('inc/footer.php');
        ?>

    </body>
</html>
     