<?php include "inc/header.php"; ?>
<a href="/therapy-box">Back</a>
<?php

$host='localhost';
$dbname='therapy_box';
$username='root';
$passw='';
$table='tasks';

try {
$dbh = new PDO('mysql:host='.$host.';dbname='.$dbname, $username, $passw);

} catch (PDOException $e) {
print "Error!: " . $e->getMessage() . "<br/>";
die();
}

$sql="SELECT * FROM tasks";
$stmt=$dbh->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);




?>


<div class="task-add">
    <input type="text" placeholder="task" name="task" class="task">
    <input type="submit" value="Add" class="add">
</div>

<div class="task-list">
    <?php foreach ($rows as $row): ?>
        <div>
            <?php echo $row['description'] ?>
            <input type="checkbox"
                <?php echo ($row['status']=='0')?'':'checked'; ?>
            >
        </div>
    <?php endforeach; ?>
</div>

<script>

    function addTask(task){
        console.log('XHR');

        var xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function () {
            if(this.readyState==4 && this.status==200){
                document.querySelector('.task-list').innerHTML+=this.responseText;
                document.querySelector('.task').value='';
            }
        }

        xhr.open('GET','ajax/tasks.php?task='+task, true);

        xhr.send();
    }

    document.addEventListener('DOMContentLoaded', function(){
        // do something

        var taskEl = document.querySelector('.task');
        var addEl = document.querySelector('.add');
        var taskListEl = document.querySelector('.task-list');
        var checkboxEl = document.querySelector('input[type=checkbox]');


        var task;

        function xhrRequest() {
            task = taskEl.value;
            if(task ==""){
                console.log('empty', task.value);
            }else{
                console.log('addTask', task);
                addTask(task);
            }
        }


        addEl.addEventListener('click', xhrRequest);

        taskEl.addEventListener('keyup', function (e) {
            if(e.keyCode===13){
                xhrRequest();
            }
        });

        checkboxEl.addEventListener("click", function () {
            console.log('end');
        });

    });
</script>


<?php include "inc/footer.php"; ?>
