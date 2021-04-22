<?php
 
 namespace LAReferencia\View\Helper\Root;
 
 use VuFind\View\Helper\Root\RecordDataFormatter\SpecBuilder;
 
 class RecordDataFormatterFactory extends \VuFind\View\Helper\Root\RecordDataFormatterFactory
 {
     public function getDefaultCoreSpecs()
     {
    
        $spec = new SpecBuilder();

        //Autores principales
        $spec->setTemplateLine(
            //'Main Authors', 'getDeduplicatedAuthors', 'data-authors.phtml',
            'Authors', 'getAllAuthorsOneRole', 'data-authors.phtml',
            [
                'useCache' => true,
                'labelFunction' => function ($data) {
                    return count($data['primary']) > 1
                //        ? 'Main Authors' : 'Main Author';
                ? 'Authors' : 'Author';
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

        //Otros autores
        /*$spec->setTemplateLine(
            'Other Authors', 'getDeduplicatedAuthors', 'data-authors.phtml',
            [
                'useCache' => true,
                'context' => [
                    'type' => 'secondary',
                    'schemaLabel' => 'contributor',
                    'requiredDataFields' => [
                        ['name' => '', 'prefix' => 'CreatorRoles::']
                    ]
                ],
            ]
        );*/

         //Autores corporativos
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
  
        //Colaboradores
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


        //Tipo
        $spec->setLine(
            'Format', 'getFormats', 'RecordHelper',
            ['helperMethod' => 'getFormatList']
        );

        //Estado 
        $spec->setLine('Status', 'getStatus', null, ['translate'  => true]);

        //Año de publicación
        $spec->setLine('Publication Date', 'getPublicationDates');
  
        //País 
        $spec->setLine('Country', 'getCountry');
        
        //Institución 
        $spec->setLine('Institution', 'getInstitution');

        //Repositorio 
        $spec->setLine('Repository', 'getRepository');

        //Idioma
        $spec->setLine('Language', 'getLanguages', null, ['translate'  => true]);

        //OAI Identifier 
        $spec->setLine('OAI Identifier', 'getIdentifierOAI');

        //Enlace del recurso
        $spec->setTemplateLine('Online Access', true, 'data-onlineAccess.phtml');

        //Nivel de acceso
        $spec->setLine('Access Level', 'getAccessLevel', null, ['translate'  => true]);

        //Publicado en
        $spec->setTemplateLine(
            'Published in', 'getContainerTitle', 'data-containerTitle.phtml'
        );

        //Nuevo título
        $spec->setLine(
            'New Title', 'getNewerTitles', null, ['recordLink' => 'title']
        );
  
        //Título previo
        $spec->setLine(
            'Previous Title', 'getPreviousTitles', null, ['recordLink' => 'title']
        );     
        
        //Editorial
        $spec->setTemplateLine(
            'Published', 'getRootPublishers', 'data-publicationDetails.phtml'
        );
  
        //Programa
        $spec->setTemplateLine(
            'Program', 'getProgramPublishers', 'data-publicationDetails.phtml'
        );
  
        //Departamento
        $spec->setTemplateLine(
            'Department', 'getDepartmentPublishers', 'data-publicationDetails.phtml'
        );
  
        //Edición
        $spec->setLine(
            'Edition', 'getEdition', null,
            ['prefix' => '<span property="bookEdition">', 'suffix' => '</span>']
        );

        //Serie
        $spec->setTemplateLine('Series', 'getSeries', 'data-series.phtml');
  
        //Subjects 
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
  
        //Hijos
        $spec->setTemplateLine(
            'child_records', 'getChildRecordCount', 'data-childRecords.phtml',
            ['allowZero' => false]
        );
        
        //Ítems relacionados
        $spec->setTemplateLine(
            'Related Items', 'getAllRecordLinks', 'data-allRecordLinks.phtml'
        );

        //Tags
        $spec->setTemplateLine('Tags', true, 'data-tags.phtml');

        //Keywords
        $spec->setLine('Keyword', 'getKeywords');


        return $spec->getArray();

     }
 }
