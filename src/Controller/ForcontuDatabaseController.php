<?php

/**
 * @file
 * Contains \Drupal\forcontu_database\Controller\ForcontuDatabaseController.
 */

namespace Drupal\forcontu_database\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Connection;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ForcontuDatabaseController extends ControllerBase{

    protected $database;
    protected $currentUser;

    public function __construct(Connection $database, AccountInterface $current_user) {
        $this->database = $database;
        $this->currentUser = $currentUser;
    }

    public static function create(ContainerInterface $container){
        return new static(
            $container->get('database'),
            $container->get('current_user')
        );
    }

    public function comment() {

        
        $query = $this->database->select('comment_field_data', 'n')
        ->fields('n', ['cid', 'entity_id', 'subject', 'uid']);
        $query2 = $this->database->select('comment', 'f')
        ->fields('f', ['uuid', 'extra']);
        $query2->union($query, 'ALL');
        //dpq($query);
        $result = $query2->execute();
        foreach($result as $record){
            dpm($record);
        }

        return [
            '#markup' => '<p>' . $this->t('Respuesta al modulo de database') . '</p>',
        ];
    }
}