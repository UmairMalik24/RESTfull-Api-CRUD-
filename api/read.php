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

  // Blog post query
  $result = $post->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any posts
  if($num > 0) {
    // Post array
    $posts_arr['data'] = array();
    // $posts_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $post_item = array(
        'post_id' => $post_id,
        'post_title' => $post_title,
        'post_content' => html_entity_decode($post_content),
        'post_author' => $post_author,
        'post_cat_id' => $post_cat_id,
        'cat_title' => $cat_title
      );

      // Push to "data"
      array_push($posts_arr['data'], $post_item);
      // array_push($posts_arr['data'], $post_item);
    }

    // Turn to JSON & output
    echo json_encode($posts_arr);
  } else {
    // No Posts
    echo json_encode(
      array('message' => 'No Posts Found')
    );
  }




?>
