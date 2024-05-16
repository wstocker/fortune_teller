<?php 

namespace Drupal\fortune_teller\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\node\NodeInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\node\NodeEvents;
use Drupal\node\Event\NodeInsertEvent;
use Drupal\node\Event\NodeUpdateEvent;
use Drupal\fortune_teller\FortuneTellerService;

class FortuneTellerSubscriber implements EventSubscriberInterface {

  protected $fortuneService;

  public function __construct(FortuneTellerService $fortuneService) {
    $this->fortuneService = $fortuneService;
  }

  public static function getSubscribedEvents() {
    return [
      'entity.node.insert' => 'onNodeInsert',
      'entity.node.update' => 'onNodeUpdate',
    ];
  }

  public function onNodeInsert(NodeInterface $node) {
    if ($node->bundle() == 'blog') {
      $this->fortuneService->addFortune($node);
      $this->fortuneService->addInsertMessage($node);
    }
  }

  public function onNodeUpdate(NodeInterface $node) {
    if ($node->bundle() == 'blog') {
      $this->fortuneService->addFortune($node);
      $this->fortuneService->addUpdateMessage($node);
    }
  }
}
