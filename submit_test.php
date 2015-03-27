submit_test.php <br /><br />
<?php
    include 'db_connection.php';
    
    $numEntries = $_POST['numEntries'];
    for($x = 1; $x <= $numEntries; $x++)
    {
        echo '<br />Question ';
        $qID = isset($_POST['Q'.$x.'ID']) ? $_POST['Q'.$x.'ID'] : 'No such question';
        echo $qID;
        echo ': ';
        if(!empty($_POST['Q'.$x.'A']))
        {
            $sqlComm = "insert into student_answer (student_id, ques_id, stu_ans_text)
                        values (112233, ".$qID.", '".$_POST['Q'.$x.'A']."')";
            // mysqli_query($connection, $sqlComm);
            echo '<br />'.$sqlComm;
            
        }
        else
        {
            for($i = 1; $i <= 4; $i++)
            {
                if(isset($_POST['Q'.$x.'A'.$i]))
                {
                    $sqlComm = "insert into student_answer (student_id, ques_id, stu_ans_text)
                            values (112233, ".$qID.", '".$_POST['Q'.$x.'A'.$i]."')";
                    // mysqli_query($connection, $sqlComm);
                    echo '<br />'.$sqlComm;
                }
            }
        }
        echo '<br />';
    }

    mysqli_close($connection);
    
    // header("Location: studentHomePage2.php");
?>