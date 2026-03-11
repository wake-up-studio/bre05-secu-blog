<?php
/**
 * @author : Gaellan
 * @link : https://github.com/Gaellan
 */

    class PostManager extends AbstractManager {
        public function __construct(){
            parent::__construct();
        }
        
        public function findLatest(){
            $query = $this -> db -> prepare('
                SELECT posts.*
                FROM posts
                ORDER BY created_at DESC
                LIMIT 4
            ');

            $query -> execute();
            
            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            
            $posts = [];
            
            foreach($results as $result){
                $manager = new UserManager();
                $user = $manager -> findOne($result["author"]);
                
                $categoryManager = new CategoryManager();
                $categories = $categoryManager -> findByPost($result["id"]);
                
                $posts[] = new Post($result["title"], $result["excerpt"], $result["content"], $result["created_at"], 
                $user, $categories, $result["id"]);
            }
            return $posts;
        }
        
        public function findOne(int $id){
            $query = $this -> db -> prepare('
                SELECT * FROM posts
                WHERE id = :id
            ');
            
            $parameters = [
                'id' => $id
            ];
            
            $query -> execute($parameters);
            
            $result = $query->fetch(PDO::FETCH_ASSOC);
            
            if($result !== false){
                $manager = new UserManager();
                $user = $manager -> findOne($result["author"]);
                
                $categoryManager = new CategoryManager();
                $categories = $categoryManager -> findByPost($result["id"]);
                
                $post = new Post($result["title"], $result["excerpt"], $result["content"], $result["created_at"], 
                $user, $categories, $result["id"],);
                return $post;
            }
            else{
                return null;
            }
        }
        
        public function findByCategory(int $categoryId){
            $query = $this -> db -> prepare('
                SELECT posts.* 
                FROM posts
                JOIN posts_categories
                ON posts_categories.post_id = posts.id
                WHERE posts_categories.category_id = :categoryId
            ');

            $parameters = [
                'categoryId' => $categoryId
            ];

            $query -> execute($parameters);
            
            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            
            $posts = [];
            
            foreach($results as $result){
                $userManager = new UserManager();
                $user = $userManager -> findOne($result["author"]);
                
                $categoryManager = new CategoryManager();
                $categories = $categoryManager -> findByPost($result["id"]);
                
                $posts[] = new Post($result["title"], $result["excerpt"], $result["content"], $result["created_at"], 
                $user, $categories , $result["id"]);
            }
            return $posts;
        }
    }
?>