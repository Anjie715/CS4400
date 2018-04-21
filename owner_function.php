<?php
// Start the session
session_start();
require 'dbinfo.php' ; 
?>
<html>
<title>Owner functionality</title>
<body>


<?php
$email = '123@123.com';
echo "this is your email: '$email'. ";


$connection = mysqli_connect($host, $usernameDB, $passwordDB, $database) or die( "Unable to connect");
        
$tmp = mysqli_query($connection, "SELECT * FROM User WHERE Email = '$email'");
while($row = mysqli_fetch_array($tmp)){
    $username = $row['Username'];
    echo "Got username: '$username'";
}

//(ID, Name, Size, IsCommercial, IsPublic, Street, City, Zip, ProprtyType, Owner, ApprovedBy)
$query = "SELECT * FROM Property WHERE Owner = '$username'";

if ($_GET['sort'] == 'ID')
{
    $query .= " ORDER BY ID";
}
else if ($_GET['sort'] == 'Name')
{
    $query  .= " ORDER BY Name";
}
else if ($_GET['sort'] == 'Size')
{
    $query  .= " ORDER BY Size";
}
else if($_GET['sort'] == 'City')
{
    $query  .= " ORDER BY City";
}
else if($_GET['sort'] == 'Zip')
{
    $query  .= " ORDER BY Zip";
}
else if($_GET['sort'] == 'PropertyType')
{
    $query  .= " ORDER BY PropertyType";
}
$result = mysqli_query($connection,  $query);

$keyword = $_POST['keyword'];
$search_type = $_POST['search_type'];


if(isset($_POST['manage'])){
    header("Location: manage_property.php");
    exit;
} else if(isset($_POST['add'])){
    header("Location: Add_new_property.php/?name=$username");
    exit;
}if(isset($_POST['view'])){
    header("Location: view_others.php");
    exit;
}if(isset($_POST['search'])){
    header("Location: search_property.php/?type=$search_type/?key=$keyword");
    exit;
}

?>

<table border="1">
  <tr>
    <th><a href="owner_function.php?sort=ID">ID:</a></th>
    <th><a href="owner_function.php?sort=Name">Name:</a></th>
    <th><a href="owner_function.php?sort=Size">Size:</a></th>
    <th>IsCommercial?:</th>
    <th>IsPublic?:</th>
    <th>Street:</th>
    <th><a href="owner_function.php?sort=City">City:</a></th>
    <th><a href="owner_function.php?sort=Zip">Zip:</a></th>
    <th><a href="owner_function.php?sort=PropertyType">Property Type:</a></th>
    <th>Owner:</th>
    <th>Approved by:</th>
  </tr>

<?php 
while($row = mysqli_fetch_array($result)){
    ?>
    <tr>
        <td><?php echo $row['ID'] ?></td>
        <td><?php echo $row['Name'] ?></td>
        <td><?php echo $row['Size'] ?></td>
        <td><?php echo $row['IsCommercial'] ?></td>
        <td><?php echo $row['IsPublic'] ?></td>
        <td><?php echo $row['Street'] ?></td>
        <td><?php echo $row['City'] ?></td>
        <td><?php echo $row['Zip'] ?></td>
        <td><?php echo $row['PropertyType'] ?></td>
        <td><?php echo $row['Owner'] ?></td>
        <td><?php echo $row['ApprovedBy'] ?></td>
    </tr>
    <br /> 


  <?php 
}
mysqli_close($connection);
?>
</table>

<form action="owner_function.php" method="post">

<input type='submit' name='manage' value='manage property' />
<input type='submit' name='add' value='add property' />
<input type='submit' name='view' value='view other properties' />
Search by:           <select name="search_type">
                    <option value="" disabled selected>Select</option>
                    <?php
                    echo "<option value='Name'>Fruit</option>";
                    echo "<option value='Street'>Nut</option>";
                    echo "<option value='Zip'>Flow</option>";
                    echo "<option value='Owner'>Vegetable</option>";
                    ?>
                </select><br>
Keyword: <input type="text" name="keyword"><br>
<input type='submit' name='search' value='search properties' />
<input value="log out" type="button" onclick="window.close()">
</form>

</body>
</html>
