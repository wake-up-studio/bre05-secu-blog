<?php
/**
 * @author : Gaellan
 * @link : https://github.com/Gaellan
 */
 
    class Comment {
        public function __construct(private string $content, private User $user, private Post $post, private ?int $id = NULL){
            
        }
        
        public function getContent() : string {
            return $this->content;
        }
        
        public function setContent(string $content) : void {
            $this -> content = $content;
        }
        
        public function getId() : ?int {
            return $this->id;
        }
        
        public function setId(?int $id) : void {
            $this -> id = $id;
        }
        
        public function getUser() : User {
            return $this->user;
        }
        
        public function setUser(User $user) : void {
            $this -> user = $user;
        }
        
        public function getPostId() : Post {
            return $this->post;
        }
        
        public function setPostId(Post $post) : void {
            $this -> post = $post;
        }
    }

?>