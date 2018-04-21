<?php
// Start the session
session_start();
require 'dbinfo.php' ; 
?>
<html>
<title>Add new property</title>
<body>


<?php
$email = $_GET['name'];
echo "this is your email: '$email'. ";

if(isset($_POST['submit'])) { 

		$connection = mysqli_connect($host, $usernameDB, $passwordDB, $database) or die( "Unable to connect");
        
        $tmp = mysqli_query($connection, "SELECT * FROM User WHERE Email = '$email'");
        while($row = mysqli_fetch_array($tmp)){
        	$username = $row['Username'];
        	echo "Got username: '$username'";
        }

        $property_name = $_POST['property_name'];
        $street_adr = $_POST['street_adr'];
        $city = $_POST['city'];
        $zip = intval($_POST['zip']);
        $acres = (float)$_POST['acres'];
        $property_type = $_POST['propertyType'];
        $animal = $_POST['animal'];
        $crop = $_POST['crop'];
        $isPublic = $_POST['isPublic'];
        $isCommercial = $_POST['isCommercial'];
        $query = "SELECT * FROM Property";
        $result = mysqli_query($connection, $query);
        $id = mysqli_num_rows($result) + 1;
        
        //(ID, Name, Size, IsCommercial, IsPublic, Street, City, Zip, ProprtyType, Owner, ApprovedBy)
        $query = "INSERT INTO Property VALUES('$id', '$property_name', '$acres','$isCommercial', '$isPublic', '$street_adr', '$city', '$zip', '$property_type', '$username', 'NULL')";
        //$result
        if(mysqli_query($connection, $query)) {
        	echo "'$id', '$property_name', '$username'  \n ";
            echo "Property '$property_name' registered successfully\n";
        } else {
            echo "'$id', '$property_name', '$street_adr', '$zip', '$city', '$acres', '$property_type', '$isPublic', '$isCommercial'  \n ";
            echo "Property Registration failed\n";
        }
    
}
?>

<form  method="post">

Property Name: <input type="text" name="property_name"><br>
Street Address: <input type="text" name="street_adr"><br>
City: <input type="text" name="city"><br>
Zip: <input type="text" name="zip"><br>
Acres: <input type="text" name="acres"><br>
Property Type:  <select required name="propertyType">
                    <option value="" disabled selected>Select</option>
                    <?php
                    echo "<option value='Farm'>Farm</option>";
                    echo "<option value='Garden'>Garden</option>";
                    echo "<option value='Orchard'>Orchard</option>";
                    ?>
                </select><br>
Animal: <input type="text" name="animal"><br>
Crop:           <select required name="crop">
                    <option value="" disabled selected>Select</option>
                    <?php
                    echo "<option value='Fruit'>Fruit</option>";
                    echo "<option value='Nut'>Nut</option>";
                    echo "<option value='Flow'>Flow</option>";
                    echo "<option value='Vegetable'>Vegetable</option>";
                    ?>
                </select><br>
Public?:        <input type="radio" name="isPublic" value="1">Yes
                <input type="radio" name="isPublic" value="0" checked>No<br>
Commercial?:    <input type="radio" name="isCommercial" value="1">Yes
                <input type="radio" name="isCommercial" value="0" checked>No<br>
<input value="Register" name="submit" type="submit">
<input value="Cancel" type="button" onclick="window.close()">
</form>

</body>
</html>
