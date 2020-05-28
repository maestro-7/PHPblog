<?php

class Post extends DB_Connection{
    private $conn;
    private $errorArray;

    public function __construct()
    {
        $this->conn = $this->connect();
        $this->errorArray =array();
    }

    public function getAllPosts(){
        $sql = "SELECT * FROM posts";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([]);
        $result = $stmt->fetchAll();
        return $result;
    }
    public function insertPost($user,$title, $details)
    {
        $date = date("Y-m-d");

        $sql = "insert into posts(title,details, user_id, created_at) values(?,?,?,?)";
        $stmt = $this->conn->prepare($sql);
        try{
            $stmt->execute([$title,$details,$user,$date]);
            return true;
        }
        catch(Exception $e)
        {
            echo $e;
            return false;
        }
    }

    public function deletePost($post_id)
    {
        $sql = "DELETE FROM posts WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        try{
            $stmt->execute([$post_id ]);
            return true;
        }
        catch(Exception $e)
        {
            echo $e;
            return false;
        }
    }
}

?>