<?php
// Start the session
session_start();
require 'dbinfo.php' ; 
?>
<html>
<title>Owner Registration</title>
<body>

<?php
if(isset($_POST['name'])) { 
    if(strcmp($_POST['password'], $_POST['confirm']) != 0) {
        echo "password not match!";
    } else {
        $connection = mysqli_connect($host, $usernameDB, $passwordDB, $database) or die( "Unable to connect");
        $username = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $hashPswd = md5($password);
        $query = "INSERT INTO User(Username, Email, Password, UserType)
                        VALUES('$username', '$email', '$hashPswd','OWNER')";
        if(mysqli_query($connection, $query)) {
            echo "User '$username' registered successfully; ";
        } else {
            echo "Owner '$username' Registration failed; ";
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
            echo "Property '$property_name' registered successfully\n";
        } else {
            echo "'$id', '$property_name', '$street_adr', '$zip', '$city', '$acres', '$property_type', '$isPublic', '$isCommercial'  \n ";
            echo "Property Registration failed\n";
        }
    }
}
?>

<form action="register_w.php" method="post">
Username: <input type="text" name="name"><br>
E-mail: <input type="text" name="email"><br>
Password: <input type="password" name="password"><br>
Confirm password: <input type="password" name="confirm"><br>

Property Name: <input type="text" name="property_name"><br>
Street Address: <input type="text" name="street_adr"><br>
City: <input type="text" name="city"><br>
Zip: <input type="text" name="zip"><br>
Acres: <input type="text" name="acres"><br>
Property Type:  <select required name="propertyType">
                    <option value="" disabled selected>Select</option>
                    <?php
                    echo "<option value='Farm'>Farm</option>";
                    ?>
                </select><br>
Animal:         <select required name="animal">
                    <option value="" disabled selected>Select</option>
                    <?php
                    echo "<option value='chicken'>Chicken</option>";
                    ?>
                </select><br>
Crop:           <select required name="crop">
                    <option value="" disabled selected>Select</option>
                    <?php
                    echo "<option value='corn'>Corn</option>";
                    ?>
                </select><br>
Public?:        <input type="radio" name="isPublic" value="1">Yes
                <input type="radio" name="isPublic" value="0" checked>No<br>
Commercial?:    <input type="radio" name="isCommercial" value="1">Yes
                <input type="radio" name="isCommercial" value="0" checked>No<br>
<input value="Register" type="submit">
</form>

</body>
</html>
