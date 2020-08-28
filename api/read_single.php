<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/dbs.php';
  include_once '../../model/post.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $post = new Post($db);

  // Get ID
  $post->post_id = isset($_GET['cat_title']) ? $_GET['cat_title'] : die();

  // Get post
  $post->read_single();
  while($row = $stmt->fetch(PDO::FETCH_ASSOC);)
    extract($row);
  // Create array
  $post_arr = array(
    'post_id' => $post->post_id,
    'post_title' => $post->post_title,
    'post_content' => $post->post_content,
    'post_author' => $post->post_author,
    'post_cat_id' => $post->post_cat_id,
    'post_cat_title' => $post->cat_title
  );
  array_push($posts_arr['data'], $post_item);

  // Make JSON
  print_r(json_encode($post_arr));
