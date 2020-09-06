<?php
session_start();
require_once 'functions.php';
$pageTitle = 'Zomorrow Property Options';
$description = 'real estate options bedrooms bathrooms county price preferences';

$propertyArray = array();
 
    if(isset($_POST['apartment'])){         
        $propertyArray = getApartments($_SESSION['listings']);        
    }      
    if (isset($_POST['house'])) {
       
            $propertyArray = getHouses($_SESSION['listings']);    
    }
    if (isset($_POST['condo'])){
            
            $propertyArray = getCondos($_SESSION['listings']);    
    }
    $_SESSION['propertyArray'] = $propertyArray;

?>

<html lang="en">
    <?php include('inc/head.php') ?>
    <body>
        <header>
            <h1>Zoomorrow Home Listings</h1>
        </header>

        <main>
            <?php            
                displayOption();
                resetSearch();
            ?>
        </main>
        <?php
        require('inc/footer.php');
        ?>
    </body>
</html>

