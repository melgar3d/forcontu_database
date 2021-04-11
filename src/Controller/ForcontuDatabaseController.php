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
use Drupal\dblog\Controller;

class ForcontuDatabaseController extends ControllerBase{

    protected $database;
    protected $current_user;

    public function __construct(Connection $database, AccountInterface $current_user) {
        $this->database = $database;
        $this->current_user = $current_user;
    }

    public static function create(ContainerInterface $container){
        return new static(
            $container->get('database'),
            $container->get('current_user')
        );
    }

    public function pageCount() {
        
    }

    public function comment() {
        
        $query = $this->database->select('comment_field_data', 'n')
        ->fields('n', ['cid', 'entity_id', 'subject', 'uid']);
        $query->innerJoin('comment', 'c', 'c.cid = n.uid');
        dpq($query);
        $result = $query->execute();

        $header = ['cid', 'entity_id', 'subject', 'uid'];
        $rows = $result->fetchAllAssoc('cid', \PDO::FETCH_ASSOC);

        dpm($rows);

        $build['forcontu_comment_table'] = [
            '#type' => 'table',
            '#header' => $header,
            '#rows' => $rows,
        ];

        return $build;
    }
}