<?php
//function to read in a real estate listing file
function readFirst() {
    // Open and read the file into an associative array 
    $listFile = fopen("apts.txt", "r");

    flock($listFile, LOCK_EX);

    if (!$listFile) {
        echo "File does not exist on this server.";
    }
    $allProperties = array();
    
     $propertyID = trim(fgets($listFile, 999));
    
    while (!feof($listFile)) {

               $county = trim(fgets($listFile, 999)); 
               $bedroom = trim(fgets($listFile, 999));
               $bathroom = trim(fgets($listFile, 999));
               $price = trim(fgets($listFile, 999));
               $address = trim(fgets($listFile, 999));
               $jpg = trim(fgets($listFile, 999));

        $temp = array("propertyID" => $propertyID, "county" => $county, "bedrooms" => $bedroom, "bathrooms" => $bathroom, "price" => $price, "address" => $address, "jpg" => $jpg);

        $allProperties[] = $temp;
        $propertyID = trim(fgets($listFile, 999));
        

        //foreach($toDoList as $temp) {
        //$_POST = $temp;
        //}
    }//end while loop
    //
    flock($listFile, LOCK_UN);

    fclose($listFile);
  
    return $allProperties;
}

//function to display available real estate listings
function showListings($realEstateListings) {
    if(count($realEstateListings) == 0){
        noResultsMessage();
        resetSearch();
    }
    else{
        echo "<section class='property_display'>";
        for($i = 0; $i<count($realEstateListings); $i++){
            echo    "<figure>
                            <img src='{$realEstateListings[$i]['jpg']}' alt='property'>
                            <figcaption>{$realEstateListings[$i]['address']}</figcaption>
                            <figcaption>{$realEstateListings[$i]['county']}</figcaption>
                            <figcaption>{$realEstateListings[$i]['price']}</figcaption>                            
                    </figure>";                     
        }
        echo "</section>";
               
        saveUserInfo();
               
        resetSearch();
        
    }   
}

//function to display real estate search options
function displayOption() {
    echo "<form action='results.php' method='post'>
            <fieldset>
                <legend>County</legend>
                <label for='greene'>Greene County</label>
                <input type='checkbox' name='county[]' id='greene' value='Greene'>
                <label for='clark'>Clark County</label>
                <input type='checkbox' name='county[]' id='clark' value='Clark'>
                <label for='montgomery'>Montgomery County</label>
                <input type='checkbox' name='county[]' id='montgomery' value='Montgomery'>
                <label for='other'>Other Counties</label>
                <input type='checkbox' name='county[]' id='other' value='Other'>
            </fieldset>
            <fieldset>
                <legend>Bedrooms</legend>
                <label for='1br'>One</label>
                <input type='checkbox' name='bedrooms[]' id='1br' value='1'>
                <label for='2br'>Two</label>
                <input type='checkbox' name='bedrooms[]' id='2br' value='2'>
                <label for='3br'>Three</label>
                <input type='checkbox' name='bedrooms[]' id='3br' value='3'>
                <label for='4br'>Four+</label>
                <input type='checkbox' name='bedrooms[]' id='4br' value='4'>
            </fieldset>
            <fieldset>
                <legend>Bathrooms</legend>
                <label for='1bath'>One</label>
                <input type='checkbox' name='bathrooms[]' id='1bath' value='1'>
                <label for='1half'>1+half</label>
                <input type='checkbox' name='bathrooms[]' id='1half' value='1+half'>
                <label for='2bath'>Two</label>
                <input type='checkbox' name='bathrooms[]' id='2bath' value='2'>
                <label for='2half'>2+half</label>
                <input type='checkbox' name='bathrooms[]' id='2half' value='2+half'>
                <label for='3bath'>3+</label>
                <input type='checkbox' name='bathrooms[]' id='3bath' value='3'>
            </fieldset>
            <fieldset>
                <legend>Price</legend>
                <label for='minPrice'>Minimum Price</label>
                <input type='text' name='priceMin' id='minPrice'>
                <label for='maxPrice'>Maximum Price</label>
                <input type='text' name='priceMax' id='maxPrice' required>
            </fieldset>
            <fieldset>
                <legend>Search These Terms</legend>
               
                <input type='submit' name='search' value='Search'>
           </form>";
}
//function determines if checkbox array has items set
function getListings($all_listings, $counties, $num_beds, $num_baths, $price_min, $price_max){
        
    
    $selectedListingsArr = array(); //new array matching user's options
    $selectedCountiesArray = array();
    $selectedBedsArray = array();
    $selectedBathsArray = array();
    
        foreach($all_listings as $listing){      
            
            //foreach($countiesChosen as $countyChoice){
            
            foreach($counties as $county) {
                if($listing['county'] == $county) {
                   $selectedCountiesArray[] = $listing;  
                }
            }
        }
        
        foreach($selectedCountiesArray as $listing) {
           foreach($num_beds as $beds) {
                       if($beds == $listing['bedrooms']) {
                         $selectedBedsArray[] = $listing;  
                       }                         
           }
        }
        
        foreach($selectedBedsArray as $listing) {
           foreach($num_baths as $baths) {
                       if($baths == $listing['bathrooms']) {
                         $selectedBathsArray[] = $listing;  
                       }                         
           }
        }
        
        foreach($selectedBathsArray as $listing) {
        
            if($listing['price'] >= $price_min and $listing['price'] <= $price_max){
                $selectedListingsArr[] = $listing;
            }
        }
    return $selectedListingsArr;
}

function getApartments($listings){
    $aptArray = array();
    
    foreach($listings as $listing){            
        if(preg_match("/^1/", $listing['propertyID'])) {
            $aptArray[] = $listing;
        }
    }                    
    return $aptArray;    
}
function getCondos($listings){
    $condoArray = array();
    
    foreach($listings as $listing){            
        if(preg_match("/^2/", $listing['propertyID'])) {
            $condoArray[] = $listing;
        }
    }                    
    return $condoArray;    
}
function getHouses($listings){
    $houseArray = array();
    
    foreach($listings as $listing){            
        if(preg_match("/^3/", $listing['propertyID'])) {
            $houseArray[] = $listing;
        }
    }                    
    return $houseArray;    
}
function saveUserInfo()
{
    echo "Please enter your contact information so we can schedule a showing for your properties: ";
    echo "<div class='contact_form'>";
    echo "<form action='submit1.php' method='post'>
        
            <label>First Name: </label>
            <input type='text' name='fname' required><br>

            <label>Last Name: </label>
            <input type='text' name='lname' required><br>
        
            <label> Email: </label>
            <input name='email' type='email' placeholder='yourname@mail.com' required><br>
            
            <label for='phone'>Phone: </label>
            <input type='text' name='phone' placeholder='555-555-5555' required><br>
            
            <label>Birth Date: </label>
            <input type='text' name='bdate' placeholder='00/00/0000'><br>
        
            <label>Move Date: </label>
            <input type=''text' name='moving' placeholder='00/00/0000'><br><br>
        </div>
        
        <div >
        <button type='submit' value='Submit'>Submit</button>        
        </div>
        </form>";  
}

function noResultsMessage(){
    $sorryString = <<<TEXT
        <p>We don't seem to have any properties matching your preferences. If you would like to expand your search,
        please click the New Search button below.</p>
            
TEXT;
    echo $sorryString;
}
function showUserInfo($array){
              //$array = array("array variable 1", "array variable 2", "array variable 3");
          
          //show heredoc
         $string = <<<TEXT
              Thank you, $array[0], and we are glad to have served your new home search.              
              We will be calling you at $array[3] and emailing you at $array[2], to schedule your
              appointment!
TEXT;
   echo $string; 
}

function resetSearch() {
    echo "<form action='index.php' method='post'>
            <input type='Submit' name='reset_search' value='New Search'>
         </form>";
}

function showReport($userListings) {

    echo "  <table>
                <thead>
                    <tr>
                        <th class='left'>County</th>
                        <th>Address</th>
                        <th>Bedrooms</th>
                        <th>Bathrooms</th>
                        <th>Price</th>                                               
                    </tr>
                </thead>";

    for ($i = 0; $i < count($userListings); $i++) {
        echo "<tr>";        
        echo "<td>{$userListings[$i]['county']}</td>";
        echo "<td>{$userListings[$i]['address']}</td>";
        echo "<td>{$userListings[$i]['bedrooms']}</td>";
        echo "<td>{$userListings[$i]['bathrooms']}</td>";
        echo "<td>{$userListings[$i]['price']}</td>";        
        echo "</tr>";
    }//end foreach(toDoList as temp)
    echo "  </table>";
}
function displayAboutUs(){
    
           
           echo "<h2>Zoomorrow Real Estate was created by Mohammad Aljagthmi and Ben Zook.</h2>
            <p>Description: This project will implement a real estate website that allows a 
            user to search for a type of real estate, input desired real estate options view 
            results for real estate that match the user’s options, input contact information 
            for real estate agents, and view confirmation of the user’s real estate search</p>";
           
            
            
            echo "<ul>
                <li>index.php</li>                    
                    <p>The index page will have functions to display head and 
                    footer and a form to display three image links to the following 
                    real estate types: apartments, condominiums and single homes. 
                    Each link will send the users to the “properties.php” page, where 
                    the user can select options for a real estate search within the real 
                    estate type. ReadFile() and displayAboutUs() was written by Mohammad.</p>
                    
                <li>properties.php</li>                    
                    <p>The property page will have a function that takes in a real estate 
                    type parameter, and displays all options for the user’s real estate search. 
                    The user will input options into a form and these options will be stored in 
                    a post array. When the user clicks a “Submit” button, the form action will 
                    load “results.php”. getApartments(), getCondos() and getHouses() and displayOptions
                    were written by Ben.</p>                    
                <li>results.php</li>                    
                    <p>The results page will have a function that displays the matching real 
                    estate using flexbox items. Each result will include an address, county and 
                    price. An additional function will display an input form where the user can 
                    provide contact information including name, phone number, date of birth, move-in 
                    date and email. When the user clicks a “Submit” button, the “submit1.php” page 
                    will load. The getListings() and showListings() functions were written by 
                    Mohammad and Ben.</p>                    
                <li>submit1.php</li>                
                    <p>The submit page will have a function that displays a confirmation message 
                    using the user’s contact information in a HEREDOC. The showReport() was written by
                    Moahammad and Ben, and the showUserInfo() was written by Ben.</p>                    
            </ul>";
           

}