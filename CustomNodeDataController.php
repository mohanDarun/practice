<?php

namespace Drupal\custom_node_data\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class CustomNodeDataController.
 *
 * @package Drupal\custom_node_data\Controller
 */
class CustomNodeDataController extends ControllerBase {

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager')
    );
  }

  /**
   * Constructs a new CustomNodeDataController object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * Fetch and return data for a particular node.
   */
  public function getNodeData($node_id) {
    // Load the node.
    $node = \Drupal::entityTypeManager()->getStorage('node')->load($node_id);

    // Check if the node exists.
    if ($node) {
      // Extract relevant data.
      $data = [
        'title' => $node->getTitle(),
        'body' => $node->get('body')->value,
        // Add other fields as needed.
      ];

      // Return JSON response.
      return new JsonResponse($data);
    }
    else {
      // Handle the case where the node does not exist.
      return new JsonResponse(['error' => 'Node not found.'], 404);
    }
  }

}
