<?php
return array(
   'doctrine' => array(
  'driver' => array(
    'minivan_entities' => array(
      'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
      'cache' => 'array',
      'paths' => array(__DIR__ . '/../src/Minivan/Entity')
    ),
    'orm_default' => array(
      'drivers' => array(
        'Minivan\Entity' => 'minivan_entities'
      )
))),
    'controllers' => array(
        'invokables' => array(
            'Minivan\Controller\User' => 'Minivan\Controller\UserController',
        ),
    ),
    'router' => array(
        'routes' => array(

            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'minivan' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/minivan',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Minivan\Controller',
                        'controller'    => 'User',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'minivan' => __DIR__ . '/../view',
        ),
    ),
);
