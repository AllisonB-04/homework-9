<?php

namespace app\models;

class Post
{
    //todo make methods here
    private function connect()
    {
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        $dsn = "mysql:hostname=".DBHOST.";dbname=".DBNAME;

        try {
            return new PDO($dsn, DBUSER,DBPASS, $options);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }

    public function getPostByID($id){
        $connectedPDO = $this->connect();
        $sql = "SELECT * FROM posts WHERE id = :id";

        $statement = $connectedPDO->prepare($sql);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        
        return $statement->fetch();
    }
   
    public function getAllPosts(){
        $connectedPDO = $this->connect();
        $sql = "SELECT * FROM posts";

        $statement = $connectedPDO->query($sql);
        return $statement->fetchAll();

    }

    public function savePost($postData){
        $connectedPDO = $this->connect();
        $sql = "INSERT INTO posts (title, description) VALUES (:title, :description)";
        
        $statement = $connectedPDO->prepare($sql);
        return $statement->execute($postData);
    }

    public function updatePost($inputData){
        $connectedPDO = $this->connect();
        $sql = "UPDATE posts SET title = :title, description = :description WHERE id = :id";

        $statement = $connectedPDO->prepare($sql);
        $statement->execute($inputData);

        $result = $statement->fetch();
        return $result;     
    }

    public function deletePost($id){
        $connectedPDO = $this->connect();
        $sql = "DELETE FROM posts WHERE id = :id";
    
        $statement = $connectedPDO->prepare($sql);
        return $statement->execute(['id' => $id]);
    }
}
