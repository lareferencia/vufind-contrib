<?php

namespace LAReferencia\RecordDriver;

use VuFind\RecordDriver\Response as Response;

class SolrIBICT extends SolrDefault
{

  const SUFFIX_STR = '.fl_str_mv';
  const SUFFIX_TXT = '.fl_txt_mv';
  const NA_MESSAGE = "Não Informado pela instituição";

/**
   * Get all field occurrences
   *
   * @param array $fields to compile and return
   * @return array
   */
  public function getFieldsValues($fields, $na_message = true)
  {
      $values = parent::getFieldsValues($fields);

      if(sizeof($values) == 0 && $na_message){
      	array_push($values, self::NA_MESSAGE);
      }

      return $values;
  }

  /**
   * Deduplicate author information into associative array with main/corporate/
   * secondary keys.
   *
   * @param array $dataFields An array of extra data fields to retrieve (see
   * getAuthorDataFields)
   *
   * @return array
   */
  public function getDeduplicatedAuthors($dataFields = ['profile'])
  {
      return parent::getDeduplicatedAuthors($dataFields);
  }

  /**
   * Get Author Information with Associated Data Fields
   *
   * @param string $index      The author index [primary, corporate, or secondary]
   * used to construct a method name for retrieving author data (e.g.
   * getPrimaryAuthors).
   * @param array  $dataFields An array of fields to used to construct method
   * names for retrieving author-related data (e.g., if you pass 'role' the
   * data method will be similar to getPrimaryAuthorsRoles). This value will also
   * be used as a key associated with each author in the resulting data array.
   *
   * @return array
   */
  /*public function getAuthorDataFields($index, $dataFields = [])
  {
      $data = $dataFieldValues = [];

      // Collect author data
      $authorMethod = sprintf('get%sAuthors', ucfirst($index));
      $authors = $this->tryMethod($authorMethod, [], []);

      // Collect attribute data
      foreach ($dataFields as $field) {
          $fieldMethod = $authorMethod . ucfirst($field) . 's';
          $dataFieldValues[$field] = $this->tryMethod($fieldMethod, [], []);
      }

      // Match up author and attribute data (this assumes that the attribute
      // arrays have the same indices as the author array; i.e. $author[$i]
      // has $dataFieldValues[$attribute][$i].
      foreach ($authors as $i => $author) {
          if (!isset($data[$author])) {
              $data[$author] = [];
          }

          foreach ($dataFieldValues as $field => $dataFieldValue) {
              if (!empty($dataFieldValue[$i])) {
                  $data[$author][$field][] = $dataFieldValue[$i];
              } else {
                $data[$author][$field][] = ["NA"];
              }
          }
      }

      return $data;
  }*/

  /**
  ** AUTHORS Data
  */

  /**
   *
   * @return array
   */
  public function getPrimaryAuthorsProfiles()
  {
    return $this->getFieldsValues(['dc.contributor.authorLattes.fl_str_mv'], false);
  }


  /**
  ** CONTRIBUTORS Data
  */

  /**
   * Main function called from RecordDataFormaterFactory, calls functions
   * with pattern get[XXX]Authors and get[XXX]Authors[YYY]s
   * where XXX is on of advisor, coadvisor, referee
   * and YYY is a datafile: ie: profile
   *
   * @param array $dataFields An array of extra data fields to retrieve (see
   * getAuthorDataFields)
   *
   * @return array
   */
  public function getContributors($dataFields = ['profile'])
  {
      $authors = [];
      foreach (['advisor', 'coadvisor', 'referee'] as $type) {
          $authors[$type] = parent::getAuthorDataFields($type, $dataFields);
      }
      return $authors;
  }


  /**
   * Advisors
   */
  public function getAdvisorAuthors()
  {
    return $this->getFieldsValues(['dc.contributor.advisor1.fl_str_mv','dc.contributor.advisor2.fl_str_mv']);
  }
  public function getAdvisorAuthorsProfiles()
  {
    return $this->getFieldsValues(['dc.contributor.advisor1Lattes.fl_str_mv','dc.contributor.advisor2Lattes.fl_str_mv'], false);
  }

  /**
   * Coadvisor
   */
  public function getCoadvisorAuthors()
  {
    return $this->getFieldsValues(['dc.contributor.advisor-co1.fl_str_mv','dc.contributor.advisor-co2.fl_str_mv']);
  }
  public function getCoadvisorAuthorsProfiles()
  {
    return $this->getFieldsValues(['dc.contributor.advisor-co1Lattes.fl_str_mv','dc.contributor.advisor-co2Lattes.fl_str_mv'], false);
  }

  /**
   * Referee
   */
  public function getRefereeAuthors()
  {
    return $this->getFieldsValues(['dc.contributor.referee1.fl_str_mv','dc.contributor.referee2.fl_str_mv',
      'dc.contributor.referee3.fl_str_mv','dc.contributor.referee4.fl_str_mv','dc.contributor.referee5.fl_str_mv']);
  }
  public function getRefereeAuthorsProfiles()
  {
    return $this->getFieldsValues(['dc.contributor.referee1Lattes.fl_str_mv','dc.contributor.referee2Lattes.fl_str_mv',
      'dc.contributor.referee3Lattes.fl_str_mv','dc.contributor.referee4Lattes.fl_str_mv','dc.contributor.referee5Lattes.fl_str_mv'], false);
  }


  /**
  *  SUBJECTS
  **/

  /**
   * Get all subject headings associated with this record.  Each heading is
   * returned as an array of chunks, increasing from least specific to most
   * specific.
   *
   * @param bool $extended Whether to return a keyed array with the following
   * keys:
   * - heading: the actual subject heading chunks
   * - type: heading type
   * - source: source vocabulary
   *
   * @return array
   */
  public function getSubjectsByField($field, $type, $source, $extended = false)
  {
      $headings =  $this->getFieldsValues([$field], false);

      // The Solr index doesn't currently store subject headings in a broken-down
      // format, so we'll just send each value as a single chunk.  Other record
      // drivers (i.e. MARC) can offer this data in a more granular format.
      $callback = function ($i) use ($extended) {
          return $extended
              ? ['heading' => [$i], 'type' => $type, 'source' => $source ]
              : [$i];
      };
      return array_map($callback, array_unique($headings));
  }

  public function getAllSubjectHeadings($extended = false)
  {
      $headings = [];

      $headings = array_merge($headings,  $this->getSubjectsByField("dc.subject.cnpq.fl_str_mv", "cnpq", "cnpq", $extended) );
      $headings = array_merge($headings,  $this->getSubjectsByField("dc.subject.eng.fl_str_mv", "original", "eng", $extended) );
      $headings = array_merge($headings,  $this->getSubjectsByField("dc.subject.spa.fl_str_mv", "original", "spa", $extended) );
      $headings = array_merge($headings,  $this->getSubjectsByField("dc.subject.por.fl_str_mv", "original", "por", $extended) );

      if(sizeof($headings) == 0){
      	array_push($headings, self::NA_MESSAGE);
      }

      return $headings;
  }

  public function getCNPQSubjects() {
    return  $this->getSubjectsByField("dc.subject.cnpq.fl_str_mv", "cnpq", "cnpq");
  }

  public function getEngSubjects() {
  	return  $this->getSubjectsByField("dc.subject.eng.fl_str_mv", "original", "eng");
  }

  public function getSpaSubjects() {
    	return  $this->getSubjectsByField("dc.subject.spa.fl_str_mv", "original", "spa");
  }

  public function getPorSubjects() {
    return  $this->getSubjectsByField("dc.subject.por.fl_str_mv", "original", "por");
  }


  /**
  *  Published
  **/
  /**
   * Get an array of publication detail lines combining information from
   * getPublicationDates(), getPublishers() and getPlacesOfPublication().
   *
   * @return array
   */
  public function getPublicationDetailsByPublishers($names)
  {

      $i = 0;
      $retval = [];
      while ( isset($names[$i]) ) {
          // Build objects to represent each set of data; these will
          // transform seamlessly into strings in the view layer.
          $retval[] = new Response\PublicationDetails(
              '',
              $names[$i],
              ''
          );
          $i++;
      }

      return $retval;
  }



  public function getRootPublishers()
  {
    return $this->getPublicationDetailsByPublishers( $this->getFieldsValues(['dc.publisher.none.fl_str_mv']) );
  }

  public function getProgramPublishers()
  {
    return  $this->getPublicationDetailsByPublishers($this->getFieldsValues(['dc.publisher.program.fl_str_mv']));
  }

  public function getDepartmentPublishers()
  {
    return $this->getPublicationDetailsByPublishers($this->getFieldsValues(['dc.publisher.department.fl_str_mv']));
  }

  public function getCountryPublishers()
  {
    return $this->getPublicationDetailsByPublishers($this->getFieldsValues(['dc.publisher.country.fl_str_mv']));
  }

 /**
 * DESCRIPTION
 *
 */
 public function getAbstractPor()
 {
   return $this->getFieldsValues(['dc.description.abstract.por.fl_str_mv'], false);
 }

 public function getAbstractEng()
 {
   return $this->getFieldsValues(['dc.description.abstract.eng.fl_str_mv'], false);
 }

 public function getAbstracSpa()
 {
   return $this->getFieldsValues(['dc.description.abstract.spa.fl_str_mv'], false);
 }

 public function getCitation()
 {
   return $this->getFieldsValues(['dc.identifier.citation.fl_str_mv']);
 }

 /**
 * Access Level
 **/
 public function getAccessLevel()
 {
   return $this->getFieldsValues(['eu_rights_str_mv']);
 }

 public function getURLsArray()
 {
     return $this->getFieldsValues(['url'], false);
 }

}