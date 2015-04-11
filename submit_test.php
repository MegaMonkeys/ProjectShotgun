<?php
    session_start();
    include_once 'sessionCheck.php';
    user_type_check('Student');



   
    echo 'submit_test.php <br /><br />';

    include 'db_connection.php';
    $student_id = $_SESSION['user_id'];
    $testID = $_POST['testID'];
    $numEntries = $_POST['numEntries'];
    $hasEssay = false;
    $objPoints = 0;
    for($x = 1; $x <= $numEntries; $x++)
    {
        echo '<br />Question ';
        $qIDtype = isset($_POST['Q'.$x.'ID']) ? $_POST['Q'.$x.'ID'] : 'No such question';
        $qInfo = explode(",", $qIDtype);
        $qID = $qInfo[0];
        $qType = $qInfo[1];
        echo $qType.' ';
        echo $qID;
        echo ': ';

        if($qType === 'True/False')
        {
            if(!empty($_POST['Q'.$x.'A']))
            {
                $ptsEarned = 0;
                $sqlSelectAns = 'select ans_text, points from question join answer using (ques_id) where correct = 1 and ques_id = '.$qID;
                $correctAnswers = mysqli_query($connection, $sqlSelectAns);
                $row = mysqli_fetch_row($correctAnswers);
                if($_POST['Q'.$x.'A'] === $row[0])
                    $ptsEarned = $row[1];
                
                $sqlComm = "insert into student_answer (student_id, ques_id, stu_ans_text, stu_points)
                            values (".$student_id.", ".$qID.", '".$_POST['Q'.$x.'A']."', ".$ptsEarned.")";
                mysqli_query($connection, $sqlComm);
                echo '<br />'.$sqlComm;
                $objPoints += $ptsEarned;
                
            }
            else
            {
                $sqlComm = "insert into student_answer (student_id, ques_id, stu_ans_text, stu_points)
                            values (".$student_id.", ".$qID.", '', 0)";
                mysqli_query($connection, $sqlComm);
                echo '<br />'.$sqlComm;
            }
        }
        else if($qType === 'Multiple Choice')
        {
            if(!empty($_POST['Q'.$x.'A']))
            {
                $ptsEarned = 0;
                $sqlSelectAns = 'select ans_text, points from question join answer using (ques_id) where correct = 1 and ques_id = '.$qID;
                $correctAnswers = mysqli_query($connection, $sqlSelectAns);
                $row = mysqli_fetch_row($correctAnswers);
                if($_POST['Q'.$x.'A'] === $row[0])
                    $ptsEarned = $row[1];
                
                $sqlComm = "insert into student_answer (student_id, ques_id, stu_ans_text, stu_points)"
                         . "values (".$student_id.", ".$qID.", '".$_POST['Q'.$x.'A']."', ".$ptsEarned.")";
                mysqli_query($connection, $sqlComm);
                echo '<br />'.$sqlComm;
                $objPoints += $ptsEarned;
                
            }
            else
            {
                $sqlComm = "insert into student_answer (student_id, ques_id, stu_ans_text, stu_points)"
                         . "values (".$student_id.", ".$qID.", '', 0)";
                mysqli_query($connection, $sqlComm);
                echo '<br />'.$sqlComm;
            }
        }
        else if($qType === 'Many Choice')
        {
            $sqlSelectAns = 'select ans_text, points, correct from question join answer using (ques_id) where ques_id = '.$qID;
            $correctAnswers = mysqli_query($connection, $sqlSelectAns);
            $corAns = mysqli_fetch_all($correctAnswers, MYSQLI_NUM);
            $correct = false;
            for($c = 0; $c < 4; $c++)            
            {
                echo "<br />".$c." new option";
                if(isset($corAns[$c][0]))
                {
                    if($corAns[$c][2] == true)
                    {
                        $correct = false;
                        $i = 1;
                        while($i <= 4 && !$correct)
                        {
                            if(isset($_POST['Q'.$x.'A'.$i]))
                            {
                                echo "<br />".$i." is set";
                                if($corAns[$c][0] === $_POST['Q'.$x.'A'.$i])
                                {
                                    $correct = true;
                                }
                                else
                                    echo "<br />".$i."- not a match";
                            }
                            $i++;
                        }
                        echo "<br />Correct: ".$correct;
                    }
                }
            }
            echo "<br />Correct: ".$correct;
            if($correct)
            {
                $ptsEarned = $corAns[0][1];
                $objPoints += $ptsEarned;
            }
            else
                $ptsEarned = 0;
            
            $firstAnswer = true;
            for($i = 1; $i <= 4; $i++)
            {
                if(isset($_POST['Q'.$x.'A'.$i]))
                {
                    $sqlComm = "insert into student_answer (student_id, ques_id, stu_ans_text, stu_points)
                                values (".$student_id.", ".$qID.", '".$_POST['Q'.$x.'A'.$i]."', ".$ptsEarned.")";
                    mysqli_query($connection, $sqlComm);
                    echo '<br />'.$sqlComm;
                    
                    if($firstAnswer)
                    {
                        $ptsEarned = 0;
                        $firstAnswer = false;
                    }
                }
            }
            if($firstAnswer) // If student didn't select any answers.
            {
                $sqlComm = "insert into student_answer (student_id, ques_id, stu_ans_text, stu_points)
                                values (".$student_id.", ".$qID.", '', 0)";
                mysqli_query($connection, $sqlComm);
                echo '<br />'.$sqlComm;
            }
        }
        else if($qType === 'Short Answer')
        {
            $hasEssay = true;
            if(isset($_POST['Q'.$x.'A']))
            {
                $sqlComm = "insert into student_answer (student_id, ques_id, stu_ans_text)
                            values (".$student_id.", ".$qID.", '".$_POST['Q'.$x.'A']."')";
                mysqli_query($connection, $sqlComm);
                echo '<br />'.$sqlComm;
            }   
        }
        else if($qType === 'Essay')
        {
            $hasEssay = true;
            if(isset($_POST['Q'.$x.'A']))
            {
                $sqlComm = "insert into student_answer (student_id, ques_id, stu_ans_text)
                            values (".$student_id.", ".$qID.", '".$_POST['Q'.$x.'A']."')";
                mysqli_query($connection, $sqlComm);
                echo '<br />'.$sqlComm;
            }   
        }
        echo '<br />';
    }
    
    // Update grade in student_test table
    if($hasEssay)
    {
        $essayPoints = "null";
        $grade = "null";
    }
    else
    {
        $essayPoints = "0";
        
        $sql = "select sum(points) from question where test_id = " . $testID;
        $result = mysqli_query($connection, $sql);
        $row = mysqli_fetch_row($result);
        $grade = (float)$objPoints / (float)$row[0] * 100.0;
    }

    $sqlComm = "update student_test set objective_grade = " . $objPoints . ","
                                      . " essay_grade = " . $essayPoints . ","
                                      . " final_grade = " . $grade
                 . " where test_id = " . $testID . " and student_id = " . $student_id;
    mysqli_query($connection, $sqlComm);
    echo '<br /><br />'.$sqlComm;

    
    mysqli_close($connection);
    
    header("Location: studentHomePage2.php");
?>