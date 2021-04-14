<?php

require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-gannwp-users.php';


/**
* This class defines the user list.
*
* @since      1.0.0
* @package    Gannwp
* @subpackage Gannwp/components
* @author     Your Name <email@example.com>
*/


class Gannwp_User_list extends Gannwp_Users
{
   /**
   * @var    array
   */
   protected $users = array();

   /**
   * @var    string
   */
   private $table ;


   /**
   * Constructor
   *
   */
   public function __construct()
   {
      parent::__construct();

      $this->setUsers();
   }

   /**
   * return users
   *
   * @return    array    users
   */
   public function getUsers()
   {
      return $this->users;
   }


   /**
   * users list seter
   */
   public function setUsers()
   {

      $users = $this->wpdb->get_results("SELECT * FROM {$this->wpdb->prefix}users", OBJECT);
      $gannwp_users = $this->wpdb->get_results("SELECT * FROM {$this->wpdb->prefix}gannwp_users", OBJECT);

      foreach ($gannwp_users as $key => $gannwp_user) {
         foreach ($users as $key => $user) {
            if ($user->ID == $gannwp_user->userID) {
               foreach ($gannwp_user as $key => $value) {
                  $user->$key = $value;
               }
            }
         }
      }

      foreach ($users as $key => $user) {
         // $this->users = $user;
         array_push($this->users,$user);

      }

      // var_dump($this->users);
   }

}