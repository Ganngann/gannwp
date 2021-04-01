<?php

// 1st Method - Declaring $wpdb as global and using it to execute an SQL query statement that returns a PHP object
global $wpdb;
$params = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}gannwp_params WHERE id = 1", OBJECT );
$users = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}users", OBJECT);
$gannwp_users = $wpdb->get_results("SHOW COLUMNS FROM {$wpdb->prefix}gannwp_users;", OBJECT);
$posts = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}posts", OBJECT);


// SHOW COLUMNS FROM cf_pagetree_elements;

var_dump($_POST)

?>


<?php
if (isset($_POST["update_settings"])) {
   $num_elements = esc_attr($_POST["num_elements"]);
   update_option("theme_name_num_elements", $num_elements);
   $front_page_elements = array();

   $max_id = esc_attr($_POST["element-max-id"]);
   for ($i = 0; $i < $max_id; $i ++) {
      $field_name = "element-page-id-" . $i;
      if (isset($_POST[$field_name])) {
         $front_page_elements[] = esc_attr($_POST[$field_name]);
      }
   }

   update_option("theme_name_front_page_elements", $front_page_elements);
   ?>
   <div id="message" class="updated">Settings saved</div>
   <?php
}

?>
<?php
$num_elements = get_option("theme_name_num_elements");
$front_page_elements = get_option("theme_name_front_page_elements");
$element_counter = 0;
?>




<div class="wrap">
   <h2>Front page elements</h2>

   <form method="POST" action="">
      <input type="hidden" name="update_settings" value="Y" />
      <input type="hidden" name="element-max-id" value="<?php echo $element_counter; ?>" />
      <table class="form-table">
         <tr valign="top">
            <th scope="row">
               <label for="num_elements">
                  Number of elements on a row:
               </label>
            </th>
            <td>
               <input type="text" name="num_elements" value="<?php echo $num_elements;?>" size="25" />
            </td>
         </tr>
      </table>

      <h3>Featured posts</h3>

      <ul id="featured-posts-list">
         <?php
         foreach ($front_page_elements as $element) : ?>
         <li class="front-page-element" id="front-page-element-<?php echo $element_counter; ?>">
            <label for="element-page-id-<?php $element_counter; ?>">Featured post:</label>
            <select name="element-page-id-<?php $element_counter; ?>">

               <?php foreach ($posts as $post) : ?>
                  <?php $selected = ($post->ID == $element) ? "selected" : ""; ?>
                  <option value="<?php echo $post->ID; ?>" <?php echo $selected; ?>>
                     <?php echo $post->post_title; ?>
                  </option>
               <?php endforeach; ?>

            </select>

            <a href="#" onclick="removeElement(jQuery(this).closest('.front-page-element'));">Remove</a>
         </li>

         <?php $element_counter++;
      endforeach; ?>
   </ul>

   <input type="hidden" name="element-max-id" />

   <a href="#" id="add-featured-post">Add featured post</a>
   <p>
      <input type="submit" value="Save settings" class="button-primary"/>
   </p>
</form>

<li class="front-page-element" id="front-page-element-placeholder" style="display:none;">
   <label for="element-page-id">Featured post:</label>
   <select name="element-page-id">
      <?php foreach ($posts as $post) : ?>
         <option value="<?php echo $post->ID; ?>">
            <?php echo $post->post_title; ?>
         </option>
      <?php endforeach; ?>
   </select>
   <a href="#">Remove</a>
</li>
</div>
<script type="text/javascript">
var elementCounter = 0;
function setElementId(element, id) {
   var newId = "front-page-element-" + id;

   jQuery(element).attr("id", newId);

   var inputField = jQuery("select", element);
   inputField.attr("name", "element-page-id-" + id);

   var labelField = jQuery("label", element);
   labelField.attr("for", "element-page-id-" + id);
}
jQuery(document).ready(function() {
   var elementCounter = jQuery("input[name=element-max-id]").val();

   jQuery("#add-featured-post").click(function() {
      var elementRow = jQuery("#front-page-element-placeholder").clone();
      var newId = "front-page-element-" + elementCounter;

      elementRow.attr("id", newId);
      elementRow.show();

      var inputField = jQuery("select", elementRow);
      inputField.attr("name", "element-page-id-" + elementCounter);

      var labelField = jQuery("label", elementRow);
      labelField.attr("for", "element-page-id-" + elementCounter);

      var removeLink = jQuery("a", elementRow).click(function() {
         removeElement(elementRow);
         return false;
      });

      elementCounter++;
      jQuery("input[name=element-max-id]").val(elementCounter);

      jQuery("#featured-posts-list").append(elementRow);

      function removeElement(element) {
         jQuery(element).remove();
      }

      return false;
   });
   jQuery("#featured-posts-list").sortable( {
      stop: function(event, ui) {
         var i = 0;

         jQuery("li", this).each(function() {
            setElementId(this, i);
            i++;
         });

         elementCounter = i;
         jQuery("input[name=element-max-id]").val(elementCounter);
      }
   });

});
</script>
