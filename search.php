<?php

 require('connect.php');
// This is the data that will be return from the API if the province id
// is missing or is not a valid integer.
$ajax_data = [
  "success" => false,
  "message" => 'The queryString GET parameter is missing.',
  "categories"  => []
];


if(filter_input(INPUT_GET,'query', FILTER_SANITIZE_STRING)){
  $queryString = $_GET['query'];
  $query = "SELECT * FROM categories WHERE categoryTitle LIKE '%$queryString%'";
  $statement = $db->prepare($query);
  $statement->execute();

  $categories = $statement->fetchAll();
  $no_of_categories = count($categories);

  if($no_of_categories === 0){
    $ajax_data['success'] = true;
    $ajax_data['message'] = "Found {$no_of_categories} cities.";
    $ajax_data['categories'] = $categories;
  }else{
    $ajax_data['success'] = true;
    $ajax_data['message'] = "Found {$no_of_categories} cities.";
    $ajax_data['categories'] = $categories;
  }
}

// Return the data in JSON format.
header('Content-Type: application/json');
echo json_encode($ajax_data);
 ?>
