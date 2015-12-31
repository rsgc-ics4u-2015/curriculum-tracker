<?php

// This page is a self-submitting form.
// Process the submitted form.
if(isset($_POST['submit']))  {

    $provided_username = htmlspecialchars(trim($_POST['username']));
    $provided_firstname = htmlspecialchars(trim($_POST['firstname']));
    $provided_lastname = htmlspecialchars(trim($_POST['lastname']));
    $provided_password = htmlspecialchars(trim($_POST['password']));
    
    // Verify that username, lastname, and password were provided. First name is optional.
    if (strlen($provided_username) == 0) {
        $message['username'] = "Username is required.";
    }
    if (strlen($provided_lastname) == 0) {
        $message['lastname'] = "Last name is required.";
    }
    if (strlen($provided_password) == 0) {
        $message['password'] = "A password is required.";
    }
    
    // If there were no errors on basic validation of input, proceed
    if (!isset($message)) {
        
        // Connect to database
        $host = "127.0.0.1";
        $user = "rgordonatrsgc";
        $pass = "";
        $db = "ct";
        $port = 3306;
        
        // Establish the connection
        // (note username and password here is the *database* username and password, not for a user of this website)
        $connection = mysqli_connect($host, $user, $pass, $db, $port) or die(mysql_error());
        
        // Verify that username not already created
        $query = "SELECT * FROM author_or_editor WHERE username = '" . $provided_username . "';";
        $result = mysqli_query($connection, $query);
        if (! $row = mysqli_fetch_assoc($result) ) {

            // Proceed with creating a user based on provided username
            $message['username'] = "Ooh! We can create a user with that username. Just give us a sec while that logic is written.";
            
        } else {
            
            // Throw an error, user already exists with this username
            $message['username'] = "That username is taken. Please select another.";
        }

    }

}



?>

<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Curriculum Tracker</title>

  <link rel="stylesheet" href="css/styles.css?v=1.0">

  <!--[if lt IE 9]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
  
  <!-- A properly secured site would serve this page over HTTPS (secure HTTP). Why is that? -->
  
</head>

<body>
    <script src="js/scripts.js"></script>

  <h1>Register</h1>
  
  <p>Create a new account:</p>
  
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        Username:<br/>
        <input type="text" name="username" value="<?php echo $_POST['username'] ?>" maxlength="45" size="45"> <?php echo $message['username']; ?><br/><br/>
        First name:<br/>
        <input type="text" name="firstname" value="<?php echo $_POST['firstname'] ?>" maxlength="45" size="45"> <?php echo $message['firstname']; ?><br/><br/>
        Last name:<br/>
        <input type="text" name="lastname" value="<?php echo $_POST['lastname'] ?>" maxlength="45" size="45"> <?php echo $message['lastname']; ?><br/><br/>
        Password:<br/>
        <input type="password" name="password" value="<?php echo $_POST['password'] ?>" maxlength="45" size="45"> <?php echo $message['password']; ?><br/><br/>
        <input type="submit" name="submit" value="Create account">
    </form>
    
    <p>Note that new accounts will not be usable until approved by the system administrator.</p>

</body>
</html>