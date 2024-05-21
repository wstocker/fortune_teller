<?php

namespace Drupal\fortune_teller;

use Drupal\Core\Messenger\MessengerInterface;
use Drupal\fortune_teller\ChatInterface;
use Drupal\node\Entity\Node;

class FortuneTellerService {

  protected $messenger;
  protected $openAiChat;

  public function __construct(MessengerInterface $messenger, ChatInterface $openAiChat) {
    $this->messenger = $messenger;
    $this->openAiChat = $openAiChat;
  }

  public function addFortune(Node $node) {
    if ($node->bundle() == 'blog') {
      $body_text = $node->body->value;
      $fortune = $this->getFortune($body_text);
      $node->set('field_your_fortune', $fortune);
      $node->save();
    }
  }

  public function getFortune($text) {
    $get_fortune = 'You are a fortune teller, respond with a fortune for a person based on this post: ' . $text;
    return $this->openAiChat->getChat($get_fortune);
  }

  public function addInsertMessage(Node $node) {
    if ($node->bundle() === 'blog') {
      $this->messenger->addMessage('Fortune added to your blog post.');
    }
  }

  public function addUpdateMessage(Node $node) {
    if ($node->bundle() === 'blog') {
      $this->messenger->addMessage('Fortune updated on your blog post.');
    }
  }
}
