<?php
    session_start();
  //use variables for title and description within the header
    require_once 'functions.php';
    $pageTitle = 'Zomorrow Property Search Results';
    $description = 'real estate results bedrooms bathrooms county price preferences';
    ?>
<!DOCTYPE html>
<html lang="en">
    <?php include('inc/head.php')?>
    <body>
        <header>
            <h1>Zoomorrow Home Listings</h1>
        </header>
        <main>
            <?php             
                //get all the selected optionsand pass them as parametersto the showListisngfuncitons
                if(!isset($_POST['county'])){
                    $county = array('Greene', 'Montgomery', 'Clark', 'Other');                    
                }
                else {
                    $county = $_POST['county'];
                }
                if(!isset($_POST['bedrooms'])){
                    $num_beds = array('1', '2', '3', '4');
                }
                else{
                $num_beds = $_POST['bedrooms'];
                }
                if(!isset($_POST['bathrooms'])){
                    $num_baths = array('1', '1+half', '2', '2+half', '3');
                }
                else{
                $num_baths = $_POST['bathrooms'];
                }
                if(!isset($_POST['priceMin'])){
                    $priceMin = 0;
                }
                else{
                $priceMin = $_POST['priceMin'];
                }
                $priceMax = $_POST['priceMax'];
                //set a v riable for each option chosenadn pass it as a parameter to the showListing functios

                $results = getListings($_SESSION['propertyArray'], $county, $num_beds, $num_baths, $priceMin, $priceMax);
                echo "<main>"; 
                if(!isset($_SESSION['userResults'])){
                    $_SESSION['userResults'] = $results;
                }
                showListings($results)         
           ?>   
            
        </main>
        <footer>        
        <?php
            require('inc/footer.php');
        ?>
        </footer>
    </body>
</html>
   