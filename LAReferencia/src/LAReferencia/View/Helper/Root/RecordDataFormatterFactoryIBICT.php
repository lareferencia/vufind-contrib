<?php
 
 namespace LAReferencia\View\Helper\Root;
 
 use VuFind\View\Helper\Root\RecordDataFormatter\SpecBuilder;
 
 class RecordDataFormatterFactoryIBICT extends \VuFind\View\Helper\Root\RecordDataFormatterFactory
 {
    public function getDefaultCoreSpecs()
    {
        //$spec = new RecordDataFormatter\SpecBuilder();
        $spec = new SpecBuilder();

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
            'Authors', 'getDeduplicatedAuthors', 'data-authors.phtml',
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
  
        $spec->setTemplateLine(
            'Country', 'getCountryPublishers', 'data-publicationDetails.phtml'
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
        //$spec = new RecordDataFormatter\SpecBuilder();
        $spec = new SpecBuilder();
  
        $spec->setLine('Citation', 'getCitation');
  
        $spec->setLine('Portuguese Abstract', 'getAbstractPor');
        $spec->setLine('English Abstract', 'getAbstractEng');
        $spec->setLine('Spanish Abstract', 'getAbstractSpa');
  
        return $spec->getArray();
    }
 }
