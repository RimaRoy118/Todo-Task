function confirmMsg(msg, actionPage) {
    document.querySelector('.msgBox p').innerText = msg;

    document.getElementById('okBtn').addEventListener('click',()=>{
        location.assign(actionPage);
    })

    document.querySelector('.confirmMsg').style.display = 'flex';

}



function editTask(id, task, priority) {
    document.getElementById('task_id').value = id;
    document.getElementById('task').value = task;
    document.getElementById('priority').value = priority;
    
    document.getElementById('cancelbtn').style.display = 'block';
    document.querySelector('.form-sec').classList.remove('default-column');
    document.querySelector('.form-sec').classList.add('edit-column');

    document.getElementById('addbtn').innerText = 'Edit';
    document.getElementById('addbtn').addEventListener('click',()=>{
        document.querySelector('.form-sec').action = "backend/handle_edit.php"; 
    })

    document.getElementById('cancelbtn').addEventListener('click',()=>{
        location.replace('index.php');
    })

}