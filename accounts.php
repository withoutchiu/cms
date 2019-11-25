<?php
require('connect.php');
session_start();

$query = "SELECT * FROM users";
$statement = $db->prepare($query);
$statement->execute();

 ?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title></title>
   </head>
   <body>
     <?php include('nav.php') ?>
     <br>
     <br>
     <br>
     <table class="table">
       <thead>
         <tr>
           <th scope="col">User Id</th>
           <th scope="col">First Name</th>
           <th scope="col">Last Name</th>
           <th scope="col">Username</th>
           <th scope="col">Account Type</th>
           <th scope="col">Date Created</th>
           <th scope="col">Controls</th>
         </tr>
       </thead>
       <tbody>
         <?php while($row = $statement -> fetch()): ?>
         <tr>
           <th scope="row"><?= $row['userId'] ?></th>
           <td><?= $row['firstName'] ?></td>
           <td><?= $row['lastName'] ?></td>
           <td><?= $row['username'] ?></td>
           <td><?= $row['accountType'] ?></td>
           <td><?= $row['dateCreated'] ?></td>
           <td> <a href="editAccount.php?id=<?= $row['userId']?>"> Edit </a></td>
         </tr>
        <?php endwhile ?>
       </tbody>
     </table>

     <?php include('footer.php') ?>
   </body>
 </html>
