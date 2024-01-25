<?php 
include('db_conn.php');

// Add task to list.
if ( $_POST["action"] === 'save' ) {
    $input = isset($_POST["list-item"]) ? $_POST["list-item"] : null;

    $database = new Database;
    $result = $database->insertTask($input); 
}
// Delete tasks from list.
if ( $_POST["action"] === 'delete' ) {
    $input = $_POST["id"];

    $database = new Database;
    $result = $database->deleteTask($input); 
}

// Delete tasks from list.
if ( $_POST["action"] === 'update' ) {
    $input = $_POST["task"];

    $database = new Database;
    $result = $database->updateTask($input); 
}

// Update task status.
if ( $_POST["action"] === 'change-status' ) {
    $id = $_POST["id"];
    $status = $_POST["status"];

    $database = new Database;
    $result = $database->updateTaskStatus($id, $status); 
}

echo $result;
?>