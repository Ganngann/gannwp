<?php

/**
* This class defines the users
*
* @since      1.0.0
* @package    Gannwp
* @subpackage Gannwp/components
* @author     Your Name <email@example.com>
*/


class Gannwp_Users
{

   /**
   * @var    string
   */
   public $wpdb;

   /**
   * @var    array
   */
   public $fields;

   /**
   * @var    array
   */
   public $customFields;

   /**
   * @var    array
   */
   public $defaultFields;


   /**
   * @var    array
   */
   public $roles;

   /**
   * Constructor
   *
   */
   public function __construct()
   {
      global $wpdb;
      $this->wpdb = $wpdb;
      $this->fields = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}gannwp_users_meta", OBJECT);
      $this->roles = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}gannwp_users_roles", OBJECT);
      $this->defaultFields = $wpdb->get_results("select COLUMN_NAME, DATA_TYPE from INFORMATION_SCHEMA.COLUMNS where TABLE_NAME='{$wpdb->prefix}users'", OBJECT);
      $this->customFields = $wpdb->get_results("select COLUMN_NAME, DATA_TYPE from INFORMATION_SCHEMA.COLUMNS where TABLE_NAME='{$wpdb->prefix}gannwp_users'", OBJECT);


      $this->setCustomFields();
   }



   /**
   * return user fields
   *
   * @return    array      user fields
   */
   public function getFields()
   {
      return $this->fields;
   }

   /**
   * return user roles
   *
   * @return    array      user fields
   */
   public function getRoles()
   {
      return $this->roles;
   }


   /**
   * return user custom fields
   *
   * @return    array      user fields
   */
   public function getCustomFields()
   {
      return $this->customFields;
   }

   /**
   * set custom fields
   *
   * @return    array      user fields
   */
   private function setCustomFields()
   {
      $customFields = $this->customFields;

      foreach ($customFields as $key => $cfield) {

         foreach ($this->fields as $key => $mfield) {

            if ($mfield->COLUMN_NAME == $cfield->COLUMN_NAME) {
               // var_dump($mfield);
               echo "</br>";
               var_dump($cfield);
               echo "</br>";
               echo "</br>";

               foreach ($mfield as $key => $value) {
                  $cfield->$key = $value;
                  var_dump($cfield);
                  echo "</br>";

               }

               // var_dump($mfield);
               echo "</br>";
               var_dump($cfield);
               echo "</br>";
               echo "</br>";
            }
         }
      }

      $this->customFields = $customFields;

      var_dump($customFields);

   }

   /**
   * set custom fields
   *
   * @return    array      user fields
   */
   public function setdefaultFields()
   {
      // foreach ($this->fields as $key => $field) {
      // code...
      // }
      // $this->customFields ;
   }

}
