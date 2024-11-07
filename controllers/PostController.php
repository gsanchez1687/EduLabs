<?php
require('./models/Post.php');

class PostController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($data, $userId) {
        $post = new Post($this->db);
        $post->title = $data['title'];
        $post->content = $data['content'];
        $post->userid = $userId;

        if ($post->create()) {
            return json_encode(['message' => 'Post creado correctamente']);
        }
        return json_encode(['message' => 'Error al crear post']);
    }

    public function getByCategory($categoryId) {
        $post = new Post($this->db);
        return json_encode($post->getByCategory($categoryId));
    }
}
?>