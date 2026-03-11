<?php
/**
 * @author : Gaellan
 * @link : https://github.com/Gaellan
 */

    class CommentManager extends AbstractManager {
        public function __construct(){
            parent::__construct();
        }
        
        public function create(Comment $comment){
            $query = $this -> db -> prepare("
                INSERT INTO comments (content, user_id, post_id) 
                VALUES (:content, :user_id, :post_id)
            ");
            
            $parameters = [
                "content" => $comment -> getContent(),
                "user_id" => $comment -> getUserId(),
                "post_id" => $comment -> getPostId(),
            ];
            
            $query -> execute($parameters);
        }
        
        public function findByPost(int $postId):array{
            $query = $this->db->prepare(
                'SELECT comments.*
                FROM comments
                WHERE post_id = :id'    
            );
            $parameters = [
                'id' => $postId
            ];
            
            $query->execute($parameters);
            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            
            $comments = [];
            if($results !== false ){
                foreach($results as $result){
                    $userManager = new UserManager();
                    $user = $userManager -> findOne($result["user_id"]);
                    
                    $postManager = new PostManager();
                    $post = $postManager -> findOne($result["post_id"]);
                    
                    $comments[] = new Comment($result["content"], $user, $post, $result["id"]);
                }
            }
            else{
                return null;
            }
            return $comments;
        }
    }
?>