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
            
            $intPostId = intval($postId);
            
            if($postManager -> findOne($intPostId) !== null){
                $data = ["post" => $postManager -> findOne($intPostId), 
                "comments" => $commentManager -> findByPost($intPostId),
                ];
                $this->render("post", $data);
            }
    
            else{
                $this->redirect("index.php");
            }
        }
    
        public function checkComment() : void{
            if(isset($_POST["token"]) && isset($_POST["content"]) && isset($_POST["post-id"]) && isset($_SESSION["user"]))
            {
                $tokenManager = new CSRFTokenManager();
    
                if($tokenManager->validateCSRFToken($_POST["token"]))
                {
                    $um = new UserManager();
                    $pm = new PostManager();
                    $cm = new CommentManager();
    
                    $post = $pm->findOne(intval($_POST["post-id"]));
                    $user = $um->findOne($_SESSION["user"]);
                    $comment = new Comment(htmlspecialchars($_POST["content"]), $user, $post);
                    $cm->create($comment);
                }
            }
            $this->redirect("index.php?route=post&post_id={$_POST["post-id"]}");
        }
    }
?>