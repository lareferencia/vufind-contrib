<?php
/**
 * Factory for record driver data formatting view helper
 *
 * PHP version 5
 *
 * Copyright (C) Villanova University 2016.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License version 2,
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category VuFind
 * @package  View_Helpers
 * @author   Demian Katz <demian.katz@villanova.edu>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @link     https://vufind.org/wiki/development:architecture:record_data_formatter
 * Wiki
 */
namespace LaReferencia\View\Helper\Root;

use VuFind\View\Helper\Root\RecordDataFormatterFactory as OriginalRecordDataFormatterFactory;
use VuFind\View\Helper\Root\RecordDataFormatter as RecordDataFormatter;

/**
 * Factory for record driver data formatting view helper
 *
 * @category VuFind
 * @package  View_Helpers
 * @author   Demian Katz <demian.katz@villanova.edu>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @link     https://vufind.org/wiki/development:architecture:record_data_formatter
 * Wiki
 */
class RecordDataFormatterFactory extends OriginalRecordDataFormatterFactory
{

  /**
   * Get default specifications for displaying data in core metadata.
   *
   * @return array
   */
  public function getDefaultCoreSpecs()
  {
      $spec = new RecordDataFormatter\SpecBuilder();
      $spec->setTemplateLine(
          'Published in', 'getContainerTitle', 'data-containerTitle.phtml'
      );
      $spec->setLine(
          'New Title', 'getNewerTitles', null, ['recordLink' => 'title']
      );

      $spec->setLine(
          'Access Level', 'getAccessLevel');

      $spec->setLine(
          'Previous Title', 'getPreviousTitles', null, ['recordLink' => 'title']
      );

      $spec->setLine(
          'Publication Date', 'getPublicationDates');

      $spec->setTemplateLine(
          'Main Authors', 'getDeduplicatedAuthors', 'data-authors.phtml',
          [
              'useCache' => true,
              'labelFunction' => function ($data) {
                  return count($data['primary']) > 1
                      ? 'Main Authors' : 'Main Author';
              },
              'context' => [
                  'type' => 'primary',
                  'schemaLabel' => 'author',
                  'requiredDataFields' => [
                      ['name' => 'profile', 'prefix' => '']
                  ]
              ]
          ]
      );

      $spec->setTemplateLine(
          'Corporate Authors', 'getDeduplicatedAuthors', 'data-authors.phtml',
          [
              'useCache' => true,
              'labelFunction' => function ($data) {
                  return count($data['corporate']) > 1
                      ? 'Corporate Authors' : 'Corporate Author';
              },
              'context' => [
                  'type' => 'corporate',
                  'schemaLabel' => 'creator',
                  'requiredDataFields' => [
                      ['name' => 'role', 'prefix' => 'CreatorRoles::']
                  ]
              ]
          ]
      );
      $spec->setTemplateLine(
          'Other Authors', 'getDeduplicatedAuthors', 'data-authors.phtml',
          [
              'useCache' => true,
              'context' => [
                  'type' => 'secondary',
                  'schemaLabel' => 'contributor',
                  'requiredDataFields' => [
                      ['name' => 'role', 'prefix' => 'CreatorRoles::']
                  ]
              ],
          ]
      );

      $spec->setTemplateLine(
          'Advisors', 'getContributors', 'data-authors.phtml',
          [
              'useCache' => true,
              'labelFunction' => function ($data) {
                  return 'Advisor';
              },
              'context' => [
                  'type' => 'advisor',
                  'schemaLabel' => 'contributor',
                  'requiredDataFields' => [
                      ['name' => 'profile', 'prefix' => '']
                  ]
              ]
          ]
      );

      $spec->setTemplateLine(
          'Co-advisors', 'getContributors', 'data-authors.phtml',
          [
              'useCache' => true,
              'labelFunction' => function ($data) {
                  return 'Co-advisor';
              },
              'context' => [
                  'type' => 'coadvisor',
                  'schemaLabel' => 'contributor',
                  'requiredDataFields' => [
                      ['name' => 'profile', 'prefix' => '']
                  ]
              ]
          ]
      );

      $spec->setTemplateLine(
          'Referees', 'getContributors', 'data-authors.phtml',
          [
              'useCache' => true,
              'labelFunction' => function ($data) {
                  return 'Referee';
              },
              'context' => [
                  'type' => 'referee',
                  'schemaLabel' => 'contributor',
                  'requiredDataFields' => [
                      ['name' => 'profile', 'prefix' => '']
                  ]
              ]
          ]
      );


      $spec->setLine(
          'Format', 'getFormats', 'RecordHelper',
          ['helperMethod' => 'getFormatList']
      );
      $spec->setLine('Language', 'getLanguages');

      $spec->setTemplateLine(
          'Published', 'getRootPublishers', 'data-publicationDetails.phtml'
      );

      $spec->setTemplateLine(
          'Program', 'getProgramPublishers', 'data-publicationDetails.phtml'
      );

      $spec->setTemplateLine(
          'Department', 'getDepartmentPublishers', 'data-publicationDetails.phtml'
      );

      $spec->setLine(
          'Edition', 'getEdition', null,
          ['prefix' => '<span property="bookEdition">', 'suffix' => '</span>']
      );
      $spec->setTemplateLine('Series', 'getSeries', 'data-series.phtml');

      $spec->setTemplateLine(
          'Portuguese Subjects', 'getPorSubjects', 'data-allSubjectHeadings.phtml'
      );

      $spec->setTemplateLine(
          'English Subjects', 'getEngSubjects', 'data-allSubjectHeadings.phtml'
      );

      $spec->setTemplateLine(
          'Spanish Subjects', 'getSpaSubjects', 'data-allSubjectHeadings.phtml'
      );

      $spec->setTemplateLine(
          'CNPQ Subjects', 'getCNPQSubjects', 'data-allSubjectHeadings.phtml'
      );


      $spec->setTemplateLine(
          'child_records', 'getChildRecordCount', 'data-childRecords.phtml',
          ['allowZero' => false]
      );
      $spec->setTemplateLine('Online Access', true, 'data-onlineAccess.phtml');
      $spec->setTemplateLine(
          'Related Items', 'getAllRecordLinks', 'data-allRecordLinks.phtml'
      );
      $spec->setTemplateLine('Tags', true, 'data-tags.phtml');
      return $spec->getArray();
  }

  /**
   * Get default specifications for displaying data in the description tab.
   *
   * @return array
   */
  public function getDefaultDescriptionSpecs()
  {
      $spec = new RecordDataFormatter\SpecBuilder();

      $spec->setLine('Citation', 'getCitation');

      $spec->setLine('Portuguese Abstract', 'getAbstractPor');
      $spec->setLine('English Abstract', 'getAbstractEng');
      $spec->setLine('Spanish Abstract', 'getAbstractSpa');

      return $spec->getArray();
  }



}
