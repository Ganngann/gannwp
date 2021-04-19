<?php

$usersList = new Gannwp_User_list();
$users = $usersList->getUsers();
$roles = $usersList->getRoles();

?>
<div class="wrap">
   <h2>GannWP Agora Shortcode</h2>
   <table>
      <thead>
         <?php $index = 0 ?>
         <?php foreach ($usersList->getFields() as $key => $value) : ?>
            <th onclick="sortTable(<?php echo $index ?>)">
               <?php echo $value->name ?>
            </th>
            <?php $index ++; ?>
         <?php endforeach; ?>
      </thead>
      <tbody id="myTable">
         <?php foreach ($users as $key => $user) : ?>
            <tr>
               <?php foreach ($usersList->getFields() as $key => $field) : ?>
                  <?php $columnName = $field->COLUMN_NAME; ?>
                  <td>
                     <form class="" action="" method="post" id="<?php echo $user->ID ?>"></form>
                     <?php echo isset($user->$columnName) ? $user->$columnName : ''; ?>
                  </td>
               <?php endforeach; ?>
            </tr>
         <?php endforeach; ?>
      </tbody>
   </table>
</div>
