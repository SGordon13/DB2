<!DOCTYPE html>
<html lang="en">
<head>
    <title>Database 2</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<h1> <font face="Times New Roman" color="black" size="+10"><center>Join/Leave Meetings</center></font></h1>
    <center>
    <?php
        // get posted variables
        $user = $_POST['user'];
        $mysqli = new mysqli('localhost', 'root', '', 'DB2');
        $email = $_POST['email'];
        $emailEDIT = $_POST['emailEDIT'];
        $password = $_POST['password'];

        // get the id of the user
        $getuserid = "SELECT id FROM users WHERE email = '$emailEDIT'";
        $idResult = $mysqli->query($getuserid);
        $idArr = mysqli_fetch_array($idResult);

        // get the users group to find what meetings they should see
        $getGrade = "SELECT grade FROM students WHERE student_id = {$idArr['id']}";
        $gradeResult = $mysqli->query($getGrade);
        $gradeArr = mysqli_fetch_array($gradeResult);

        //get the meetings that they should see
        $getMeetingInfo = "SELECT * FROM meetings WHERE group_id >= ({$gradeArr['grade']})";
        $result = $mysqli->query($getMeetingInfo);


        // Left side (mentee join)
        $columns = 3;
        $temp = 0;
        echo "<table><tr><td>Meetings you can Mentee in:";
        echo "<table><tr><td><br>";
        while($row = mysqli_fetch_array($result)){ // loop through result
            // get the time information for meeting
            $getMeetingTime = "SELECT start_time, end_time FROM time_slot WHERE time_slot_id = {$row['time_slot_id']}";
            $timeResult = $mysqli->query($getMeetingTime);
            $timeArr = mysqli_fetch_array($timeResult);
            // Display the table
            
            echo "  <table>
                    <tr>
                        <td>Subject:</td>
                        <td>" . $row['meet_name'] . "</td>
                    </tr>
                    <tr>
                        <td>Date:</td>
                        <td>" . $row['date'] . "</td>
                    </tr>
                    <tr>
                        <td>Start Time:</td>
                        <td>" . $timeArr['start_time'] . "</td>
                    </tr>
                    <tr>
                        <td>End Time:</td>
                        <td>" . $timeArr['end_time'] . "</td>
                    </tr>
                    <tr>
                        <td>Group:</td>
                        <td>" . $row['group_id'] . "</td>
                    </tr>
                    <tr>
                        <td>"; ?>
                        <form action="" method="post">
                            <input type="hidden" id="email" name="email" value="<?php echo $email;?>" >
                            <input type="hidden" id="emailEDIT" name="emailEDIT" value="<?php echo $emailEDIT;?>" > 
                            <input type="hidden" id="password" name="password" value="<?php echo $password;?>" >
                            <input type="hidden" id="user" name="user" value="<?php echo $user;?>" > 
                            <input type="hidden" name='id' value= <?php echo $idArr['id'] ?> >
                            <input type="hidden" name='meet_id' value= <?php echo $row['meet_id'] ?> >
                            <input type="hidden" name='ment' value='Mentee' >
                            <input type="submit" class="button" name="JoinMeeting" value="Join"/>
                        </form><?php echo "
                        </td>
                        <td>"; ?>
                        <form action="" method="post">
                            <input type="hidden" id="email" name="email" value="<?php echo $email;?>" >
                            <input type="hidden" id="emailEDIT" name="emailEDIT" value="<?php echo $emailEDIT;?>" >
                            <input type="hidden" id="password" name="password" value="<?php echo $password;?>" >
                            <input type="hidden" id="user" name="user" value="<?php echo $user;?>" > 
                            <input type="hidden" name='id' value= <?php echo $idArr['id'] ?> >
                            <input type="hidden" name='meet_id' value= <?php echo $row['meet_id'] ?> >
                            <input type="hidden" name='ment' value='Mentee' >
                            <input type="submit" class="button" name="LeaveMeeting" value="Leave"/>
                        </form><?php echo "
                        </td>
                    </tr>
                    </table>";
                    $temp+=1;
            // proper spacing for the table
            if(($temp % $columns) == 0){
                echo "</tr><tr>";
            } else echo "</td><td></td><td></td><td></td><td>
                </td><td></td><td></td><td></td><td>";
            echo "</td><td><br>";
        }
        echo "</td</tr></table>"; 

        // Split the sections in two
        echo "</td><td></td><td></td><td></td><td></td>
        <td></td><td></td><td></td><td></td><td></td>
        <td></td><td></td><td></td><td></td><td></td>
        <td></td><td></td><td></td><td></td><td></td><td>
        Meeting you can Mentor in:";

        // right side mentor join 
        $temp2 = 0;
        $getMeetingInfo2 = "SELECT * FROM meetings WHERE group_id <= ({$gradeArr['grade']}-3)";
        $result2 = $mysqli->query($getMeetingInfo2);
        echo "<table><tr><td><br>";
        while($row2 = mysqli_fetch_array($result2)){ // loop through result
            // get the time information for meeting
            $getMeetingTime2 = "SELECT start_time, end_time FROM time_slot WHERE time_slot_id = {$row2['time_slot_id']}";
            $timeResult2 = $mysqli->query($getMeetingTime2);
            $timeArr2 = mysqli_fetch_array($timeResult2);
            // Display the table
            echo "  <table>
                    <tr>
                        <td>Subject:</td>
                        <td>" . $row2['meet_name'] . "</td>
                    </tr>
                    <tr>
                        <td>Date:</td>
                        <td>" . $row2['date'] . "</td>
                    </tr>
                    <tr>
                        <td>Start Time:</td>
                        <td>" . $timeArr2['start_time'] . "</td>
                    </tr>
                    <tr>
                        <td>End Time:</td>
                        <td>" . $timeArr2['end_time'] . "</td>
                    </tr>
                    <tr>
                        <td>Group:</td>
                        <td>" . $row2['group_id'] . "</td>
                    </tr>
                    <tr>
                        <td>"; ?>
                        <form action="" method="post">
                        <input type="hidden" id="email" name="email" value="<?php echo $email;?>" >
                        <input type="hidden" id="emailEDIT" name="emailEDIT" value="<?php echo $emailEDIT;?>" >
                            <input type="hidden" id="password" name="password" value="<?php echo $password;?>" >
                            <input type="hidden" id="user" name="user" value="<?php echo $user;?>" > 
                            <input type="hidden" name='id' value= <?php echo $idArr['id'] ?> >
                            <input type="hidden" name='meet_id' value= <?php echo $row2['meet_id'] ?> >
                            <input type="hidden" name='ment' value='Mentor' >
                            <input type="submit" class="button" name="JoinMeeting" value="Join"/>
                        </form><?php echo "
                        </td>
                        <td>"; ?>
                        <form action="" method="post">
                            <input type="hidden" id="email" name="email" value="<?php echo $email;?>" > 
                            <input type="hidden" id="emailEDIT" name="emailEDIT" value="<?php echo $emailEDIT;?>" >
                            <input type="hidden" id="password" name="password" value="<?php echo $password;?>" >
                            <input type="hidden" id="user" name="user" value="<?php echo $user;?>" > 
                            <input type="hidden" name='id' value= <?php echo $idArr['id'] ?> >
                            <input type="hidden" name='meet_id' value= <?php echo $row2['meet_id'] ?> >
                            <input type="hidden" name='ment' value='Mentor' >
                            <input type="submit" class="button" name="LeaveMeeting" value="Leave"/>
                        </form><?php echo "
                        </td>
                    </tr>
                    </table>";
                    $temp2+=1;
            // proper spacing for the table
            if(($temp2 % $columns) == 0){
                echo "</tr><tr>";
            } else echo "</td><td></td><td></td><td></td><td>
                </td><td></td><td></td><td></td><td>";
            echo "</td><td><br>";
        }
        echo "</td</tr></table>";
        echo "</td></tr></table>";

//code for Joining the meeting 
if (isset($_POST['JoinMeeting']))
{
    $email = $_POST['email'];
    $emailEDIT = $_POST['emailEDIT'];
    $password = $_POST['password'];
    $user = $_POST['user'];
    $id = $_POST['id'];
    $meet_id = $_POST['meet_id'];
    $ment = $_POST['ment'];

    // if youre trying to mentee for a meeting
    if($ment == "Mentee"){
        $testJoined = "SELECT * FROM enroll WHERE mentee_id = $id AND meet_id = $meet_id";
        $testJoinedRes = $mysqli->query($testJoined);
        $noRows = mysqli_num_rows($testJoinedRes);
        if($noRows == 1){
            echo "Already Joined Meeting";
        }
        else{
            // make sure the user a mentee
            $isMentee = "SELECT * FROM enroll WHERE mentee_id = $id";
            $isMenteeRes = $mysqli->query($isMentee);
            $noRows2 = mysqli_num_rows($isMenteeRes);
            if($noRows2 == 0){
                $makeMentee = "INSERT INTO mentees(mentee_id) VALUES ($id)";
                $MenteeRes = $mysqli->query($makeMentee);
            }

            // 
            $isMentee2 = "SELECT * FROM mentees WHERE mentee_id = $id";
            if(!$isMentee2){
                echo "Error Joining";
            } else {
                // add them to the meeting
                $joinQuery = "INSERT INTO enroll(meet_id, mentee_id) VALUES ($meet_id,$id)";
                $joinRes = $mysqli->query($joinQuery);
                if($joinRes){
                    echo "Enrolled in Meeting";
                } else {
                    // if failed, and they are not a mentee in another meeting, remove them from mentee
                    echo "Error Joining2";
                    $isMentee2 = "SELECT * FROM enroll WHERE mentee_id = $id";
                    $isMenteeRes2 = $mysqli->query($isMentee2);
                    $noRows3 = mysqli_num_rows($isMenteeRes2);
                    if($noRows3 == 0){
                        $removeMentee = "DELETE FROM `mentees` WHERE mentee_id = $id ";
                        $RemoveMenteeRes = $mysqli->query($removeMentee);
                    }
                }
            }
        }
    } else {
        // if youre trying to mentor for a meeting
        $testJoined = "SELECT * FROM enroll2 WHERE mentor_id = $id AND meet_id = $meet_id";
        $testJoinedRes = $mysqli->query($testJoined);
        $noRows = mysqli_num_rows($testJoinedRes);
        if($noRows == 1){
            echo "Already Joined Meeting";
        }
        else{
            // make sure the user a mentor
            $ismentor = "SELECT * FROM enroll2 WHERE mentor_id = $id";
            $ismentorRes = $mysqli->query($ismentor);
            $noRows2 = mysqli_num_rows($ismentorRes);
            if($noRows2 == 0){
                $makementor = "INSERT INTO mentors(mentor_id) VALUES ($id)";
                $mentorRes = $mysqli->query($makementor);
            }

            // 
            $ismentor2 = "SELECT * FROM mentors WHERE mentor_id = $id";
            if(!$ismentor2){
                echo "Error Joining";
            } else {
                // add them to the meeting
                $joinQuery = "INSERT INTO enroll2(meet_id, mentor_id) VALUES ($meet_id,$id)";
                $joinRes = $mysqli->query($joinQuery);
                if($joinRes){
                    echo "Enrolled in Meeting";
                } else {
                    // if failed, and they are not a mentor in another meeting, remove them from mentor
                    echo "Error Joining2";
                    $ismentor2 = "SELECT * FROM enroll2 WHERE mentor_id = $id";
                    $ismentorRes2 = $mysqli->query($ismentor2);
                    $noRows3 = mysqli_num_rows($ismentorRes2);
                    if($noRows3 == 0){
                        $removementor = "DELETE FROM `mentors` WHERE mentor_id = $id";
                        $RemovementorRes = $mysqli->query($removementor);
                    }
                }
            }
        }

    }

}
// code for leaving a meeting
if (isset($_POST['LeaveMeeting']))
{
    $email = $_POST['email'];
    $emailEDIT = $_POST['emailEDIT'];
    $password = $_POST['password'];
    $user = $_POST['user'];
    $id = $_POST['id'];
    $meet_id = $_POST['meet_id'];
    $ment = $_POST['ment'];

    // if youre trying to leave a mentee meeting
    if($ment == "Mentee"){
        // if the user is not a mentee, no need to continue
        $isMentee = "SELECT * FROM enroll WHERE mentee_id = $id";
        $isMenteeRes = $mysqli->query($isMentee);
        $noRows = mysqli_num_rows($isMenteeRes);
        if($noRows == 0){
            echo "You are not a mentee for any meeting";
        }
        else{
            // If they are not a mentee of the desired meeting, stop
            $isInMeeting = "SELECT * FROM enroll WHERE mentee_id = $id AND meet_id = $meet_id";
            $isInMeetingRes = $mysqli->query($isInMeeting);
            $noRows2 = mysqli_num_rows($isInMeetingRes);
            if($noRows2 == 0){
                echo "You are not a mentee for this meeting";
            }
            else{
                $removeFromMeeting = "DELETE FROM enroll WHERE mentee_id = $id AND meet_id = $meet_id";
                $removeResult = $mysqli->query($removeFromMeeting);
                if(mysqli_affected_rows($mysqli) == 1){
                    echo "Successfully removed";
                }
                // if the user is not a mentee for any otherr meeting, remove them from mentee table
                $isMentee2 = "SELECT * FROM enroll WHERE mentee_id = $id";
                $isMenteeRes2 = $mysqli->query($isMentee2);
                $noRows3 = mysqli_num_rows($isMenteeRes2);
                if($noRows3 == 0){
                    $removeMentee = "DELETE FROM `mentees` WHERE mentee_id = $id";
                    $RemoveMenteeRes = $mysqli->query($removeMentee);
                }
            }
        }
    } else {
        // if youre trying to leave a mentor meeting
        // if the user is not a mentor, no need to continue
        $ismentor = "SELECT * FROM enroll2 WHERE mentor_id = $id";
        $ismentorRes = $mysqli->query($ismentor);
        if($ismentorRes){
            $noRows = mysqli_num_rows($ismentorRes);
            if($noRows == 0){
                echo "You are not a mentor for any meeting";
            }
            else{
                // If they are not a mentor of the desired meeting, stop
                $isInMeeting = "SELECT * FROM enroll2 WHERE mentor_id = $id AND meet_id = $meet_id";
                $isInMeetingRes = $mysqli->query($isInMeeting);
                $noRows2 = mysqli_num_rows($isInMeetingRes);
                if($noRows2 == 0){
                    echo "You are not a mentor for this meeting";
                }
                else{
                    $removeFromMeeting = "DELETE FROM enroll2 WHERE mentor_id = $id AND meet_id = $meet_id";
                    $removeResult = $mysqli->query($removeFromMeeting);
                    if(mysqli_affected_rows($mysqli) == 1){
                        echo "Successfully removed";
                    }
                    // if the user is not a mentor for any otherr meeting, remove them from mentor table
                    $ismentor2 = "SELECT * FROM enroll2 WHERE mentor_id = $id";
                    $ismentorRes2 = $mysqli->query($ismentor2);
                    $noRows3 = mysqli_num_rows($ismentorRes2);
                    if($noRows3 == 0){
                        $removementor = "DELETE FROM `mentors` WHERE mentor_id = $id";
                        $RemovementorRes = $mysqli->query($removementor);
                    }
                }
            }
        }
    }
}

?>
<!-- Join All button -->
<form action="" method="post"><br>
    <input type="hidden" id="email" name="email" value="<?php echo $email;?>" >
    <input type="hidden" id="emailEDIT" name="emailEDIT" value="<?php echo $emailEDIT;?>" >
    <input type="hidden" id="password" name="password" value="<?php echo $password;?>" >
    <input type="hidden" name='id' value= <?php echo $idArr['id'] ?> >
    <input type="hidden" id="user" name="user" value="<?php echo $user;?>" > 
    <input type="submit" class="button" name="JoinAllButton" value="Join All Meetings"/>
</form>

<!-- Leave All button -->
<form action="" method="post"><br>
    <input type="hidden" id="email" name="email" value="<?php echo $email;?>" >
    <input type="hidden" id="emailEDIT" name="emailEDIT" value="<?php echo $emailEDIT;?>" >
    <input type="hidden" id="password" name="password" value="<?php echo $password;?>" >
    <input type="hidden" name='id' value= <?php echo $idArr['id'] ?> >
    <input type="hidden" id="user" name="user" value="<?php echo $user;?>" > 
    <input type="submit" class="button" name="LeaveAllButton" value="Leave All Meetings"/>
</form>

<?php
// code for joining all the available meetings
if (isset($_POST['JoinAllButton']))
{
    $email = $_POST['email'];
    $emailEDIT = $_POST['emailEDIT'];
    $password = $_POST['password'];
    $user = $_POST['user'];
    $id = $_POST['id'];

    // get the users group to find what meetings they should see
    $getGrade = "SELECT grade FROM students WHERE student_id = '$id'";
    $gradeResult = $mysqli->query($getGrade);
    $gradeArr = mysqli_fetch_array($gradeResult);

    //get the mentee meetings that they should see
    $getMeetingInfo = "SELECT * FROM meetings WHERE group_id >= ({$gradeArr['grade']})";
    $meetingRes = $mysqli->query($getMeetingInfo);
    $numRows=mysqli_num_rows($meetingRes);
    while($meetingRow = mysqli_fetch_array($meetingRes)){ // loop through result
        if($numRows > 0){
            // join the mentee table
            $joinMentee = "INSERT INTO mentees(mentee_id) VALUES ($id)";
            $joinRes = $mysqli->query($joinMentee);

            // join all the available meetings
            $joinMenteeMeeting = "INSERT INTO enroll(meet_id, mentee_id) VALUES ({$meetingRow['meet_id']},$id)";
            $joinRes2 = $mysqli->query($joinMenteeMeeting);
        }
    }

    //get the mentor meetings that they should see
    $getMeetingInfo2 = "SELECT * FROM meetings WHERE group_id <= ({$gradeArr['grade']}-3)";
    $meetingRes2 = $mysqli->query($getMeetingInfo2);
    $numRows2=mysqli_num_rows($meetingRes2);
    while($meetingRow = mysqli_fetch_array($meetingRes2)){ // loop through result
        if($numRows2 > 0){
            // join the mentee table
            $joinMentor = "INSERT INTO mentors(mentor_id) VALUES ($id)";
            $joinRes3 = $mysqli->query($joinMentor);

            // join all the available meetings
            $joinMentorMeeting = "INSERT INTO enroll2(meet_id, mentor_id) VALUES ({$meetingRow['meet_id']},$id)";
            $joinRes4 = $mysqli->query($joinMentorMeeting);
        }
    }
    echo "Joined all meetings";

}
// code for leaving all the available meetings
if (isset($_POST['LeaveAllButton']))
{
    $email = $_POST['email'];
    $emailEDIT = $_POST['emailEDIT'];
    $password = $_POST['password'];
    $user = $_POST['user'];
    $id = $_POST['id'];

    // remove from all mentee meetings
    $leaveMenteeMeeting = "DELETE FROM enroll WHERE mentee_id = '$id'";
    $leaveRes = $mysqli->query($leaveMenteeMeeting);

    // remove from mentee table
    $leaveMentee = "DELETE FROM mentees WHERE mentee_id = '$id'";
    $leaveRes2 = $mysqli->query($leaveMentee);

    // remove from all mentor meetings
    $leaveMentorMeeting = "DELETE FROM enroll2 WHERE mentee_id = '$id'";
    $leaveRes3 = $mysqli->query($leaveMentorMeeting);

    // remove from mentor table
    $leaveMentor = "DELETE FROM mentors WHERE mentor_id = '$id'";
    $leaveRes4 = $mysqli->query($leaveMentor);

    echo "Left all meetings.";
}
?>

<!-- Return button -->
<?php if($user == "student") : ?>
    <form action="StudentPage.php" method="post"><br>
    <?php elseif($user == "parent") : ?>
    <form action="ParentPage.php" method="post"><br>
    <?php else : ?>
    <form action="AdminPage.php" method="post"><br>
    <?php endif; ?>
        <input type="hidden" id="email" name="email" value="<?php echo $email;?>" >
        <input type="hidden" id="emailEDIT" name="emailEDIT" value="<?php echo $emailEDIT;?>" >
        <input type="hidden" id="password" name="password" value="<?php echo $password;?>" >
        <input type="hidden" id="user" name="user" value="<?php echo $user;?>" > 
        <input type="submit" class="button" name="returnButton" value="Return"/>
    </form>

</center>
</body>
</html>