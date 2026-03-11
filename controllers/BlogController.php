<?php
    /**
     * @author : Gaellan
     * @link : https://github.com/Gaellan
    */
    
    class BlogController extends AbstractController{
        public function home() : void{
            $postManager = new PostManager();
            $data = $postManager -> findLatest();
            
            $this->render("home", $data);
        }
    
        public function category(string $categoryId) : void{
            $categoryManager = new CategoryManager();

            if($categoryManager -> findOne($categoryId) !== null){
                $postManager = new PostManager();
                
                $data = ["category" => $categoryManager -> findOne($categoryId), 
                "posts" => $postManager -> findByCategory($categoryId)];
                
                $this->render("category", $data);
            }

            else{
                $this->redirect("index.php");              
            }

        }
    
        public function post(string $postId) : void{
            $postManager = new PostManager();
            $commentManager = new CommentManager();
            
            if($postManager -> findOne($postId) !== null){
                $data = ["post" => $postManager -> findOne($postId), 
                "comments" => $commentManager -> findByPost($postId),
                ];
                $this->render("post", $data);
            }
    
            else{
                $this->redirect("index.php");
            }
        }
    
        public function checkComment() : void{
            $this->redirect("index.php?route=post&post_id={$_POST["post_id"]}");
        }
    }

?>