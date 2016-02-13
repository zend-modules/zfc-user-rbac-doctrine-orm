<?php
return [
    'doctrine' => array(
        'driver' => array(
            'zfcuserrbac_entity' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\XmlDriver',
                'paths' => __DIR__ . '/xml/zfcuserrbacdoctrineorm'
            ),

            'orm_default' => array(
                'drivers' => array(
                    'ZfcUserRbacDoctrineORM\Entity'  => 'zfcuserrbac_entity'
                )
            )
        )
    ),
];