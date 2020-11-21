<?php
require('connectdb.php');
require('friend_db.php');

$name = "";
$major = "";
$year = "";

if (isset($_POST['Delete'])){
  deleteFriend($_POST['friend_to_delete']);
}

if (isset($_POST['Update'])){
  $name = $_POST['name_to_update'];
  $major = $_POST['major_to_update'];
  $year = $_POST['year_to_update'];
}

if (isset($_POST['confirmUpdate'])){
  updateFriend($_POST['name'], $_POST['major'], $_POST['year']);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{

  

  if (!empty($_POST['action']) && ($_POST['action']=='Add'))
      addFriend($_POST['name'], $_POST['major'], $_POST['year']);

}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="your name">
  <meta name="description" content="include some description about your page">      
  <title>DB interfacing</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="shortcut icon" href="http://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" type="image/ico" />  
</head>

<body>
<div class="container">

<h1>Friend book</h1>

<!-- <form action="formprocessing.php" method="post">  -->
<form name="mainForm" action="simpleform.php" method="post">
  <div class="form-group">
    Your name:
    <input type="text" class="form-control" value = "<?php echo $name ?>" name="name" required />        
  </div>  
  <div class="form-group">
    Major:
    <input type="text" class="form-control" value = "<?php echo $major ?>" name="major" required /> 
  </div>  
  <div class="form-group">
    Year:
    <input type="number" class="form-control" value = "<?php echo $year ?>" name="year" required max="4" min="1" />        
  </div> 
     
  <input type="submit" value="Add" name="action" class="btn btn-dark" title="Insert a friend into a friends table" />
  <input type="submit" value="Confirm update" name="confirmUpdate" class="btn btn-dark" title="Confirm update a friend" />
  
</form>  

  
<hr/>
<h2>List of Friends</h2>
<table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th width="25%">Name</th>        
    <th width="25%">Major</th>        
    <th width="25%">Year</th> 
    <th width="10%">Update ?</th>
    <th width="10%">Delete ?</th> 
  </tr>
  </thead>

  <?php 
    global $db;
    $sql = "SELECT name, major, year from friends";
    $result = $db->query($sql);

    
      while ($row = $result-> fetch()){
        echo "<tr><td>". $row["name"] ."</td><td>". $row["major"] ."</td><td>". $row["year"] ."</td>";
        echo "<td><form action=". $_SERVER['PHP_SELF'] .' method="post">';
        echo '<input type="submit" value="Update" name="Update" class="btn btn-primary" title="Update the record" />';
        echo '<input type="hidden" name="name_to_update" value="' . $row["name"] . '" />';
        echo '<input type="hidden" name="major_to_update" value="' . $row["major"] . '" />';
        echo '<input type="hidden" name="year_to_update" value="' . $row["year"] . '" />';
        echo '</form>';
        echo '</td>';

        echo "<td><form action=". $_SERVER['PHP_SELF'] .' method="post">';
        echo '<input type="submit" value="Delete" name="Delete" class="btn btn-danger" title="Permanently delete the record" />';
        echo '<input type="hidden" name="friend_to_delete" value="' . $row["name"] . '" />';
        echo '</form>';
        echo '</td>';
        echo '</tr>';

        
      }
    
  ?>
 
</table>
        
</div>    
</body>
</html>
  
