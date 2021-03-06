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
        $user = "student";
        $bool = false;
        $mysqli = new mysqli('localhost', 'root', '', 'DB2');
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        // get the target ID entered
        $qGetId = "SELECT id FROM users WHERE email = '$email'";
        $id = $mysqli->query($qGetId);
        $targetID = mysqli_fetch_array($id);

        // get an array of all student ID's
        $sids = [];
        $qstudentIDs = "SELECT student_id from students";
        $res = $mysqli->query($qstudentIDs);
        while($row = mysqli_fetch_assoc($res)){
            foreach($row as $cname => $cvalue){
                array_push($sids,$cvalue);
            }
        }

        // check if target ID is in array of student ID's
        if(empty($targetID)){
            echo 'Invalid Student Email';
        } else{
            if (!in_array($targetID['id'], $sids)){
                $bool = false;
                echo 'Invalid Student Email';
            }
            else{
                // get all of the information from database starting with data in the users table
                // then accessing parent email using parent id

                // first grab student info from user table 
                $bool = true;
                $qGetInfo = "SELECT * FROM users WHERE email = '$email'";
                $result = $mysqli->query($qGetInfo);
                $testrow = mysqli_fetch_array($result);

                // get the relevant parent id
                $getPID = "SELECT parent_id, grade FROM students WHERE student_id = {$targetID['id']}";
                $pidRes = $mysqli->query($getPID);
                $pidrow = mysqli_fetch_array($pidRes);

                // get the parent email
                $getPE = "SELECT email FROM users WHERE id = {$pidrow['parent_id']}";
                $peRes = $mysqli->query($getPE);
                $peRow = mysqli_fetch_array($peRes);

                if($password != $testrow['password']){
                    $bool = false;
                    echo "Incorrect Password";
                }else{
                    ?><!-- Displaying the header with the users name -->
                    <h1><font face="Times New Roman" color="black" size="+10"><center><?php echo $testrow['name']?>'s Info</center></font></h1>
                    <?php
                    $bool = true;
                    $result2 = $mysqli->query($qGetInfo); // need second instance of variable to work with
                    echo "<table>"; // start a tag in the HTML

                    
                    while($row = mysqli_fetch_array($result2)){ // loop through result
                    echo "
                            <tr>
                                <td>Grade:</td>
                                <td>" . $pidrow['grade'] . "</td>
                            </tr>
                            <tr>
                                <td>Parent Email:</td>
                                <td>" . $peRow['email'] . "</td>
                            </tr>
                            <tr>  
                                <td>Email:</td>
                                <td>" . $row['email'] . "</td>
                                <td>";?>
                                <form action="UserEditEmail.php" method="post">
                                        <input type="hidden" name="email" value="<?php echo $email;?>" > 
                                        <input type="hidden" id="emailEDIT" name="emailEDIT" value="<?php echo $email;?>" >
                                        <input type="hidden" name="password" value="<?php echo $password;?>" >
                                        <input type="hidden" id="user" name="user" value="<?php echo $user;?>" >
                                        <input type="submit" class="button" name="editEmail" value="Edit Email"/>
                                </form><?php echo "
                                </td>
                            </tr>
                            <tr>
                                <td>Phone:</td>
                                <td>" . $row['phone'] . "</td>
                                <td>";?>
                                <form action="UserEditPhone.php" method="post">
                                        <input type="hidden" name='email' value= <?php echo $email ?> >
                                        <input type="hidden" id="emailEDIT" name="emailEDIT" value="<?php echo $email;?>" >
                                        <input type="hidden" name="password" value= <?php echo $password ?> >
                                        <input type="hidden" id="user" name="user" value="<?php echo $user;?>" >
                                        <input type="submit" class="button" name="editPhone" value="Edit Phone"/>
                                </form><?php echo "
                                </td>
                            </tr>
                            <tr>
                                <td>Password:</td>
                                <td>";/* . $row['password'] . */ echo "</td>
                                <td>";?>
                                <form action="UserEditPassword.php" method="post">
                                        <input type="hidden" name='email' value= <?php echo $email ?> >
                                        <input type="hidden" id="emailEDIT" name="emailEDIT" value="<?php echo $email;?>" >
                                        <input type="hidden" name="password" value= <?php echo $password ?> >
                                        <input type="hidden" id="user" name="user" value="<?php echo $user;?>" > 
                                        <input type="submit" class="button" name="editPassword" value="Edit Password"/>
                                </form><?php echo "
                                </td>
                            </tr>";
                    }
                   // echo "</table>";
                   // dispaly the buttons for viewing and editing meetings
                echo "
                    <tr></tr><tr></tr><tr></tr><tr>
                    </tr><tr></tr><tr></tr><tr></tr>
                    <tr><td>Meetings:</td><td>"; ?>
                <form action="JoinLeaveMeeting.php" method="post">
                    <input type="hidden" name="email" value= <?php echo $email ?> >
                    <input type="hidden" id="emailEDIT" name="emailEDIT" value="<?php echo $email;?>" > 
                    <input type="hidden" name="password" value= <?php echo $password ?> >
                    <input type="hidden" id="user" name="user" value="<?php echo $user;?>" >
                    <input type="submit" class="button" name="meetingButton" value="Join/Leave Meetings"/>
                </form><?php echo "</td><td>"; ?>
                <form action="UserViewMeetings.php" method="post">
                    <input type="hidden" name='email' value= <?php echo $email ?> >
                    <input type="hidden" id="emailEDIT" name="emailEDIT" value="<?php echo $email;?>" > 
                    <input type="hidden" name="password" value= <?php echo $password ?> >
                    <input type="hidden" id="user" name="user" value="<?php echo $user;?>" >
                    <input type="submit" class="button" name="meetingButton" value="View My Meetings"/>
                </form><?php echo "</td></tr>
                <tr>
                    <td></td>
                    <td>";?>
                        <form action="UserStudyMaterials.php" method="post">
                            <input type="hidden" name='email' value= <?php echo $email ?> >
                            <input type="hidden" id="emailEDIT" name="emailEDIT" value="<?php echo $email;?>" > 
                            <input type="hidden" name="password" value= <?php echo $password ?> >
                            <input type="hidden" name='id' value= <?php echo $targetID['id'] ?> >
                            <input type="hidden" id="user" name="user" value="<?php echo $user;?>" >
                            <input type="submit" class="button" name="meetingButton" value="View Study Materials"/>
                        </form><?php echo "</td></tr>
                    </td>
                </tr>
                </table>";
                }
            }
        }
        $mysqli->close();
    ?>

<form action="StudentSignIn.php" method="post"><br>
    <input type="submit" class="button" name="returnButton" value="Return"/>
</form>
</center>
</body>
</html>