<?php
include_once 'db/db.php';

$sql = "SELECT * FROM `todo_task`";

try {
    $res = mysqli_query($conn, $sql);
} catch (\Throwable $th) {
    header("location: errors/500.html");
    exit();
}

$no_of_data = mysqli_num_rows($res);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do App</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="message/msg.css">
    <link rel="stylesheet" href="css/confirmMsg.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="message/script.js" defer></script>
    <script src="js/script.js" defer></script>
</head>
<body>
    <?php include_once 'message/showMsg.php'?>

    <div class="confirmMsg">
        <div class="msgBox">
            <p></p>
            <div class="btns">
                <button id="okBtn">OK</button>
                <button onclick="location.replace('index.php')">Cancel</button>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="header"><h1>To-Do App</h1></div>

        <form action="backend/handle_submit.php" method="post"  class="form-sec default-column">
            <input type="hidden" name="task_id" id="task_id" readonly>
            <input type="text" placeholder="Add a new task..." name="task" id="task">
            <select name="priority" id="priority">
                <option value="High">High</option>
                <option value="Medium">Medium</option>
                <option value="Low">Low</option>
            </select>
            <button type="submit" id="addbtn">Add</button>
            <button type="button" id="cancelbtn">Cancel</button>
        </form>

        <div class="scrollbar">
        <table class="list-sec">
            <?php
                if ($no_of_data > 0) {
                   
                while ($data = mysqli_fetch_assoc($res)) {
                    
            ?>
            <tr class="list">
                <td class="<?php echo $data['isComplete']? 'complete' : null?>"><input type="checkbox" class="checkbox" onclick="confirmMsg('Do you want to complete this task?', 'backend/task_complete.php?com_id=<?php echo $data['id']?>')" <?php echo $data['isComplete']? 'checked disabled' : null?>> <?php echo $data['task']?> <strong class="<?php echo $data['priority']?> <?php echo $data['isComplete']? 'complete' : null?>">- <?php echo $data['priority']?></strong></td>
                <td><strong class="<?php echo $data['priority']?> <?php echo $data['isComplete']? 'complete' : null?>"><?php echo $data['priority']?></strong></td>
                <td class="actionbtn">
                    <i class="fa-solid fa-pen-to-square <?php echo $data['isComplete']? 'e_disabled' : null?>" onclick="editTask('<?php echo $data['id']?>', '<?php echo $data['task']?>', '<?php echo $data['priority']?>')"></i>
                    <i class="fa-solid fa-trash" onclick="confirmMsg('Do you want to delete this task?', 'backend/handle_delete.php?del_id=<?php echo $data['id']?>')"></i>
                </td>
            </tr>
            <?php
                }
                }
                else{

            ?>
            <tr class="no-task">
                <td>No task available here...</td>
            </tr>
            <?php
                }
            ?>
        </table>
        </div>
        <?php
            try {
                $res2 = mysqli_query($conn, "SELECT * FROM `todo_task` WHERE isComplete = false"); 
                $noOfTask = mysqli_num_rows($res2);              
            } catch (\Throwable $th) {
                header("location: errors/500.html");
                exit();
            }
           
        ?>

        <?php
            try {
                $res3 = mysqli_query($conn, "SELECT * FROM `todo_task` WHERE isComplete = true");
                $com_task = mysqli_num_rows($res3);
            } catch (\Throwable $th) {
                header("location: errors/500.html");
                exit(); 
            }
        ?>
        <div class="footer-sec">
            <button onclick="confirmMsg('Are you sure to delete all completed task?', 'backend/clear_completed.php')" class="<?php echo $com_task < 1 ? 'disabled' : null?>">Clear Completed</button>
            <span><strong><?php echo $noOfTask?></strong> task remaining</span>
        </div>
    </div>

</body>
</html>