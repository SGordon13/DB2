<!DOCTYPE html>
<html lang="en">
<head>
    <title>Database 2</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <center>
    <?php
        $mysqli = new mysqli('localhost', 'root', '', 'DB2');
        $email = $_POST['email'];
        $emailEDIT = $_POST['emailEDIT'];
        $password = $_POST['password'];
        $user = $_POST['user'];
    ?>

    <label><font face="Times New Roman" color="black" size="+1">Edit Password</font></label>
    <form action="UserEditPassword2.php" method="post"><br>
        <br><label for="password">Enter a new password:</label>
        <input type="input" id="passwordIn" name="passwordIn"><br><br>

        <input type="hidden" id="email" name="email" value="<?php echo $email;?>" > 
        <input type="hidden" id="emailEDIT" name="emailEDIT" value="<?php echo $emailEDIT;?>" >
        <input type="hidden" id="password" name="password" value="<?php echo $password;?>" >
        <input type="hidden" id="user" name="user" value="<?php echo $user;?>" >
        <input type="submit" name="ChEmail" class="button" value="Change Password" />
    </form>

    <?php if($user == "student") : ?>
    <form action="StudentPage.php" method="post"><br>
    <?php elseif($user == "parent") : ?>
    <form action="ParentPage.php" method="post"><br>
    <?php else : ?>
    <form action="AdminPage.php" method="post"><br>
    <?php endif; ?>
        <input type="hidden" id="email" name="email" value="<?php echo $email;?>" > 
        <input type="hidden" id="password" name="password" value="<?php echo $password;?>" >
        <input type="hidden" id="user" name="user" value="<?php echo $user;?>" >
        <input type="submit" class="button" name="returnButton" value="Return"/>
    </form>
    </center>
</body>
</html>