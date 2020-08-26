<?php
  class Post {
    // DB stuff
    private $conn;
    private $table = 'post';

    // Post Properties
    public $post_id;
    public $post_cat_id;
    public $cat_title;
    public $post_title;
    public $post_content;
    public $post_author;
    public $post_date;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get Posts
    public function read() {
      // Create query
      $query = 'SELECT c.cat_title as cat_title, p.post_id, p.post_cat_id, p.post_title, p.post_content, p.post_author, p.post_date
                                FROM ' . $this->table . ' p
                                LEFT JOIN
                                  category c ON p.post_cat_id = c.cat_id
                                ORDER BY
                                  p.post_date DESC';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    // Get Single Post
    public function read_single() {
          // Create query
          $query = 'SELECT c.cat_title as cat_title, p.post_id, p.post_cat_id, p.post_title, p.post_content, p.post_author, p.post_date
                                    FROM ' . $this->table . ' p
                                    LEFT JOIN
                                      category c ON p.post_cat_id = c.cat_id
                                    WHERE
                                      p.post_id = ?
                                    LIMIT 0,1';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Bind ID
          $stmt->bindParam(1, $this->post_id);

          // Execute query
          $stmt->execute();

          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          // Set properties
          $this->post_title = $row['post_title'];
          $this->post_content = $row['post_content'];
          $this->post_author = $row['post_author'];
          $this->post_cat_id = $row['post_cat_id'];
          $this->cat_title = $row['cat_title'];
    }

    // Create Post
    public function create() {
          // Create query
          $query = 'INSERT INTO ' . $this->table . ' SET post_title = :post_title, post_content = :post_content, post_author = :post_author, post_cat_id = :post_cat_id';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->post_title = htmlspecialchars(strip_tags($this->post_title));
          $this->post_content = htmlspecialchars(strip_tags($this->post_content));
          $this->post_author = htmlspecialchars(strip_tags($this->post_author));
          $this->post_cat_id = htmlspecialchars(strip_tags($this->post_cat_id));

          // Bind data
          $stmt->bindParam(':post_title', $this->post_title);
          $stmt->bindParam(':post_content', $this->post_content);
          $stmt->bindParam(':post_author', $this->post_author);
          $stmt->bindParam(':post_cat_id', $this->post_cat_id);

          // Execute query
          if($stmt->execute()) {
            return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    // Update Post
    public function update() {
          // Create query
          $query = 'UPDATE ' . $this->table . '
                                SET post_title = :post_title, post_content = :post_content, post_author = :post_author, post_cat_id = :post_cat_id
                                WHERE post_id = :post_id';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->post_title = htmlspecialchars(strip_tags($this->post_title));
          $this->post_content = htmlspecialchars(strip_tags($this->post_content));
          $this->post_author = htmlspecialchars(strip_tags($this->post_author));
          $this->post_cat_id = htmlspecialchars(strip_tags($this->post_cat_id));
          $this->post_id = htmlspecialchars(strip_tags($this->post_id));

          // Bind data
          $stmt->bindParam(':post_title', $this->post_title);
          $stmt->bindParam(':post_content', $this->post_content);
          $stmt->bindParam(':post_author', $this->post_author);
          $stmt->bindParam(':post_cat_id', $this->post_cat_id);
          $stmt->bindParam(':post_id', $this->post_id);

          // Execute query
          if($stmt->execute()) {
            return true;
          }

          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);

          return false;
    }

    // Delete Post
    public function delete() {
          // Create query
          $query = 'DELETE FROM ' . $this->table . ' WHERE post_id = :post_id';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->post_id = htmlspecialchars(strip_tags($this->post_id));

          // Bind data
          $stmt->bindParam(':post_id', $this->post_id);

          // Execute query
          if($stmt->execute()) {
            return true;
          }

          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);

          return false;
    }

  }
