<!DOCTYPE html>
<html>
    <head>
        <title>To-do List</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="styles.css">
        <meta name="viewport" content="width-device, initial-scale=1.0">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js">
        </script>
    </head>
    <body>
        <?php require_once('db_conn.php'); ?>
        <div class="main-container">
            <header class="header-wrapper">
                <h1>
                    <i class="material-icons">check_box</i><u>Todo List</u>
                </h1>
            </header>
            <div class="content-wrapper">
                <!-- Display alerts-->
                <div class="action-message"></div>
                <!-- Add Tasks form-->
                <form id="input_form">
                    <div class="input-container container-styles">
                        <div class="input-content">
                            <input placeholder="Add new.." class="todo-input" type="text" id="title" name="list-item[title]"/>
                            <input class="todo-input" type="datetime-local" id="date" name="list-item[date]"/>
                            <div class="input-button">
                                <input class="add-item" id="addItem" type="submit" value="Add">
                            </div>
                        </div>
                    </div>
                </form>
                
                <div class="line-divider">
                    <hr class="hrclass">
                </div>
                <!-- Display Filters-->
                <div class="filters-wrapper container-styles">
                    <label>filter</label>
                    <select class="allFilter"><option>All</option></select>
                    <label>sort</label>
                    <select class="dateFilter"><option>Added date</option></select>
                    <i class="material-icons">sort</i>
                </div>
                
                <!-- Display Todo List tasks-->
                <div class="todo_list-wrapper container-styles" id="myList">
                    <!-- Fetch tasks from database -->
                    <?php 
                        $database = new Database();
                        $tasks = $database->getTasks();
                        if($tasks->num_rows){
                            while($todoz = $tasks->fetch_assoc()){?>
                                <div class="checkboxes">
                                    <div class="list-item">
                                        <label>
                                            <input type="checkbox" class="task-checkbox" <?php echo ! empty($todoz['task_status'])? 'checked': ''; ?> value="<?php echo $todoz['id']; ?>"><span><?php echo $todoz['title']; ?></span>
                                        </label>
                                        <div class="item-actions">
                                            <span id="demo" class="dateSpan"><?php echo date( 'd/m/Y H:i:s', $todoz['date'] ); ?></span>
                                            <button class="editIcon"><i class="material-icons">edit</i></button>
                                            <button class="delIcon"><i id="delete" class="material-icons">delete</i></button>
                                            
                                        </div>
                                    </div>
                                        <!-- Edit task form-->
                                        <form class="edit input-content" id="edit-<?php echo $todoz['id']; ?>">
                                            <input type="text" class="todo-input" name="title-edit-<?php echo $todoz['id']; ?>" value="<?php echo $todoz['title']; ?>">
                                            <input type="datetime-local" class="todo-input" name="date-edit-<?php echo $todoz['id']; ?>" value="<?php echo date("Y-m-d\TH:i:s", $todoz['date'] ); ?>">
                                            <button type="submit" class="add-item update-task">Apply</button>
                                            <button class="close-edit">Cancel</button>
                                            <input type="hidden" name="id-edit-<?php echo $todoz['id']; ?>" value="<?php echo $todoz['id']; ?>" />
                                        </form>
                                </div>
                            <?php
                            }
                        }else{
                            echo "No tasks at the moment.";
                        }
                    ?>

                </div>
            </div>
        </div>
        
        <script src="main.js"></script>
    </body>
</html>