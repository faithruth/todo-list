<?php 
/**
 * Database connection class
 */
class Database{

    public function __construct(){
        $this->servername = 'localhost';
        $this->username = 'root';
        $this->password = 'root';
        $this->db_name = 'wp_course';
        $this->createTable();
    }

    /**
     * Configure database connection parameters
     *
     * @return void
     */
    public function config(){
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->db_name);
        if ($conn->connect_error){
            die('Connection failed:'.$conn->connect_error);
        }
        return $conn;
    }

    /**
     * Create todo_list table in database
     *
     * @return void
     */
    public function createTable(){
        $query = "SELECT * FROM todo_list";
        $conn = $this->config();
        $result =$conn->query($query);
        
        if(empty($result)) {
            $conn = $this->config();
            $sql = "CREATE TABLE todo_list (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                title LONGTEXT NOT NULL,
                task_status BOOLEAN,
                date VARCHAR(25)
                )";
            $conn->query($sql);
            $conn->close();
        }
    }

    /**
     * Show task list
     *
     * @return $result
     */
    public function getTasks(){
        $conn = $this->config();
        $sql = "SELECT * FROM todo_list ORDER BY id DESC";
        $result = $conn->query($sql);

        $conn->close();            
        return $result;
    }
    
    /**
     * Insert new task into todo_list
     *
     * @param Array $input
     * @return $message
     */
    public function insertTask( $input ){
        $conn = $this->config();
        $message = '';
        // Check if task is empty;
        if( empty( $input["title"] ) || empty( $input["date"] ) ) {
            if( empty( $input["title"] ) ) {
                $message .= '<div>Task title cannot be empty</div>';
            }

            if( empty( $input["date"] ) ) {
                $message .= '<div>Task date cannot be empty</div>';
            }
        } else {
            $title = $input["title"];
            $date = strtotime( $input["date"] );
    
            // Check if task exists;
            $search = "SELECT title FROM todo_list WHERE title = '$title' AND date = '$date'";
            $search_db = $conn->query($search);
            if( ! empty( $search_db->num_rows ) ) {
                return 'Task already exists please add new task';
            }
    
    
            $sql = "INSERT INTO todo_list (title, date) VALUES ('$title', '$date')";
            $result = $conn->query($sql);
    
            if($result){
                $message = "success";
                
            }else{
                $message = 'Error: ' . $sql . '<br>' . $conn->error;
            }
            
            $conn->close();
        }
    
        return $message;

    }

    /**
     * Delete task from Todo List
     *
     * @param int|string $id
     * @return $message
     */
    public function deleteTask( $id ){
        $conn = $this->config();

        // Check if task exists;
        $search = "SELECT title FROM todo_list WHERE id = '$id'";
        $search_db = $conn->query($search);
        if( empty( $search_db->num_rows ) ) {
            return 'Task does not exist';
        }

        $sql = "DELETE FROM todo_list WHERE id= '$id'";
        $result = $conn->query($sql);
        if($result){
            $message = "success";
            
        }else{
            $message = 'Error: ' . $sql . '<br>' . $conn->error;
        }
        
        $conn->close();
    
        return $message;

    }

    /**
     * Update task item
     *
     * @param Array $input
     * @return $message
     */
    public function updateTask( $input ){
        $conn = $this->config();

        // Check if task is empty;
        if( empty( $input["title"] ) ) {
            return 'Task title cannot be empty';
        }

        if( empty( $input["date"] ) ) {
            return 'Schedule a date and time form this task';
        }

        $id = $input["id"];
        $title = $input["title"];
        $date = strtotime( $input["date"] );

        // Check if task exists;
        $search = "SELECT title FROM todo_list WHERE title = '$title' AND date = '$date'";
        $search_db = $conn->query($search);
        if( ! empty( $search_db->num_rows ) ) {
            return 'Task already exists please add new task';
        }

        $sql = "UPDATE todo_list SET title = '$title', date = '$date' WHERE id = '$id' ";
        $result = $conn->query($sql);

        if($result){
            $message = "success";
            
        }else{
            $message = 'Error: ' . $sql . '<br>' . $conn->error;
        }
        
        $conn->close();
    
        return $message;

    }

    /**
     * Update a task's status
     *
     * @param int $id
     * @param string $status
     * @return $message
     */
    public function updateTaskStatus( $id, $status ) {
        $conn = $this->config();

        $sql = "UPDATE todo_list SET task_status = '$status' WHERE id = '$id' ";
        $result = $conn->query($sql);

        if($result){
            $message = "success";
            
        }else{
            $message = 'Error: ' . $sql . '<br>' . $conn->error;
        }
        
        $conn->close();
    
        return $message;
    }
}
?>