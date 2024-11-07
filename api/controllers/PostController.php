<?php
require('./models/Post.php');

class PostController {
    private $db;

    
    public function __construct($db) {
        $this->db = $db;
    }

  
    public function create($data, $userId) {
        try {
            $post = new Post($this->db);
            $post->userid = $userId;
            $post->category_id = $data['category_id'];
            $post->title = $data['title'];
            $post->content = $data['content'];

            if ($post->create()) {
                return json_encode(['message' => 'Post creado correctamente']);
            }
        return json_encode(['message' => 'Error al crear post']);
        } catch (\Exception $th) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }

    public function getPostsByCategory($category_id) {
        try {
            $post = new Post($this->db);
            $posts = $post->getPosts($category_id);
    
            if ($posts) {
                http_response_code(200);
                echo json_encode(['status' => 'success', 'data' => $posts]);
            } else {
                http_response_code(404);
                echo json_encode(['status' => 'error', 'message' => 'No posts found for this category']);
            }
        } catch (\Exception $th) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => $th->getMessage()]);
        }
       
    }

    public function getAllPosts() {
        try {
            $post = new Post($this->db);
            $posts = $post->getAllPosts();
    
            if ($posts) {
                http_response_code(200);
                echo json_encode(['status' => 'success', 'data' => $posts]);
            } else {
                http_response_code(404);
                echo json_encode(['status' => 'error', 'message' => 'No posts found']);
            }
        } catch (\Exception $th) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => $th->getMessage()]);
        }
        
    }
}
?>