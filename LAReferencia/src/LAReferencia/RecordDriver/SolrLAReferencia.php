<?php

namespace LAReferencia\RecordDriver;

class SolrLAReferencia extends SolrDefault
{

  /**
   * Todos los autores
   **/
  public function getAllAuthors()
  {
    return $this->getFieldValues(["author_facet"]);
  }

  /**
   * Access Level
   **/
  public function getAccessLevel()
  {
    return $this->getFieldValue('eu_rights_str_mv');
  }

  /**
   * Status
   **/
  public function getStatus()
  {
    return $this->getFieldValue("status_str");
    #$value = null;
    #$value = $this->fields["status_str"];
    #return $value;
  }

  /**
   * Country
   **/
  public function getCountry()
  {
    return $this->getFieldValue("network_name_str");
  }

  /**
   * Institution
   **/
  public function getInstitution()
  {
    return $this->getFieldValue("instname_str");
  }

  /**
   * Repository   **/
  public function getRepository()
  {
    return $this->getFieldValue("reponame_str");
  }

  /**
   * OAI Identifier
   **/
  public function getIdentifierOAI()
  {
    return $this->getFieldValue("oai_identifier_str");
  }

  /**
   * Keywords
   **/
  public function getKeywords()
  {
    return array_unique($this->getFieldValues(["topic"]));
  }

  public function getAllAuthorsOneRole()
  {
    $allAuthors = parent::getDeduplicatedAuthors();
    $allAuthors2 = $allAuthors;

    foreach ($allAuthors2 as $key => $value) {
      $this->replaceKey($allAuthors2, 'secondary', 'primary');
    }

    //echo '<pre>'; var_dump(array_merge_recursive($allAuthors, $allAuthors2)); echo '</pre>';

    return array_merge_recursive($allAuthors, $allAuthors2);
  }

  function replaceKey(&$array, $curkey, $newkey)
  {
    if (array_key_exists($curkey, $array)) {
      $array[$newkey] = $array[$curkey];
      unset($array[$curkey]);
      return true;
    }
    return false;
  }
}
