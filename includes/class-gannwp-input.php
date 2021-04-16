<?php

/**
* This class defines input fields.
*
* @since      1.0.0
* @package    Gannwp
* @subpackage Gannwp/components
* @author     Your Name <email@example.com>
*/

// namespace Admin\Components;

class Gannwp_Input
{
   /**
   * @var    string
   */
   protected $columnName = '';

   /**
   * @var    string
   */
   protected $description = '';

   /**
   * @var    string
   */
   protected $name = '';

   /**
   * @var    string
   */
   protected $value = '';


   /**
   * @var    string
   */
   protected $dataType = '';

   /**
   * @var    string
   */
   protected $inputType = '';


   /**
   * Constructor
   *
   * @param   array       $data
   */
   public function __construct($data)
   {
      $this->columnName = $data->COLUMN_NAME;
      $this->description = $data->description;
      $this->name = $data->name;
      $this->dataType = $data->dataType;
      $this->inputType = $data->inputType;
   }

   /**
   * return input columnName
   *
   * @return    string      input columnName
   */
   public function getColumnName()
   {
      return $this->columnName;
   }

   /**
   * return input description
   *
   * @return    string      input description
   */
   public function getDescription()
   {
      return $this->description;
   }

   /**
   * return input name
   *
   * @return    string      input name
   */
   public function getName()
   {
      return $this->name;
   }

   /**
   * return input dataType
   *
   * @return    string      input dataType
   */
   public function getDataType()
   {
      return $this->dataType;
   }

   /**
   * return input inputType
   *
   * @return    string      input inputType
   */
   public function getInputType()
   {
      return $this->inputType;
   }



   /**
   * add array of entities
   *
   * the given entities will be wrapped in a entity containers.
   * this entity containers are registred in a map storage by a given entity name.
   * the entity names are the keys of the given array.
   *
   * @param     array         $entities       array of entities, the key of the array will be used as entity name
   */
   public function render($inputValue = "")
   {
      switch ($this->inputType) {
         case 'textarea':
         return "<textarea name=$this->columnName rows='8' cols='80' placeholder=$this->columnName>$inputValue</textarea>";
         break;

         default:
         return "<input type=$this->inputType name=$this->columnName placeholder=$this->columnName value=$inputValue >";
         break;
      }
   }

}
