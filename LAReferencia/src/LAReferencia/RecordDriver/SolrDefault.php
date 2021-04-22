<?php

namespace LAReferencia\RecordDriver;

class SolrDefault extends \VuFind\RecordDriver\SolrDefault
{

  const SUFFIX_STR = '.fl_str_mv';
  const SUFFIX_TXT = '.fl_txt_mv';


  public function getFieldValues($fields)
  {
      $values = [];

      foreach ($fields as $field) {
          if (isset($this->fields[$field])) {
              $field_value = $this->fields[$field];
              if(!is_array($field_value))
                $field_value = array($field_value);
                              
              $values = array_merge($values, $field_value);
          }
      }

      return array_unique($values);

  }


  public function getFieldValue($field)
  {
      $value = null;
      $onlyField = array($field);
 
      $value = $this->getFieldValues($onlyField);

      if (is_array($value) )
      {
	 if ( count($value) > 0 )      
	      
		 $value = $value[0];
	 else 
		 return "";
      }

      return $value;
  }

}

