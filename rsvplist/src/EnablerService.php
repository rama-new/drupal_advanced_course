<?php
/**
 * @file
 * Contains \Drupal\rsvplist\EnablerService
 */

namespace Drupal\rsvplist;

use Drupal\Core\Database\Database;
use Drupal\Node\Entity\Node;

/**
 * Defines a service for managing RSVP list enabled for nodes.
 */

class EnablerService{
  /**
   * Constructor
   */
  public function __construct() {
  }
  /**
   * Sets a individual node to be RSVP enabled.
   * 
   * @param \Drupal\node\Entity\Node $node
   */
  public function setEnabled(Node $node) {
    if (!$this->isEnabled($node)){
      $insert = Database::getConnection()->insert('rsvp_enabled');
      $insert->fields(['nid'],[$node->id()]);
      $insert->execute();
    }
  }
  /**
   * Checks if an indivudual node is RSVP enabled.
   * 
   * @param \Drupal\node\Entity\Node $node
   * 
   * $return bool
   *  whether the node is enabled for RSVP functionality
   */
  public function isEnabled(Node $node){
    if ($node->isNew()) {
      return FALSE;
    }
    $select = Database::getConnection()->select('rsvp_enabled', 're');
    $select->fields('re',['nid']);
    $select->condition('nid',$node->id());
    $results = $select->execute();
    return !empty($results->fetchCol());
  }
/**
 * Deletes enabled settings for an individual node.
 * 
 * @param \Drupal\Node\Entity\Node $node
 */
public function delEnabled(Node $node) {
  $delete = Database::getConnection()->delete('rsvp_enabled');
  $delete->condition('nid', $node->id());
  $delete->execute();
}


}