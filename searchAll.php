<?php
require('connect.php');
if($_POST AND isset($_POST['search']) AND isset($_POST['query'])){
  $queryString = filter_input(INPUT_POST, 'query', FILTER_SANITIZE_STRING);

  $query = "SELECT * FROM categories where categoryTitle LIKE '%$queryString%'";
  $statement = $db->prepare($query);
  $statement->execute();

  $qry = "SELECT * FROM items where itemTitle LIKE '%$queryString%'";
  $stmt = $db->prepare($qry);
  $stmt->execute();

}

 ?>


 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>WCMS</title>
   </head>
   <body>
     <br>
     <br>
     <br>
     <br>
     <?php include('nav.php') ?>
     <table class="table is-fullwidth is-hoverable" id="myTable">
         <thead>
             <tr>
               <th>Title</th>
               <th>Description</th>
               <th>Link</th>
             </tr>
         </thead>
         <tbody id="myTableTbody">
              <?php while($row = $statement->fetch()): ?>
              <tr>
                <td><?= $row['categoryTitle']?></td>
                <td><?= substr($row['categoryPlainDescription'], 0, 50) ?></td>
                <td><a href="items.php?id=<?= $row['categoryId']?>">Go to this item</a></td>
              </tr>
              <?php endwhile ?>
              <tr>
                <td>1</td>
                <td>1</td>
                <td>1</td>
              </tr>
         </tbody>
   </table>
     <?php include('footer.php') ?>
   </body>
 </html>
