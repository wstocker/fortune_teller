<?php

namespace Drupal\fortune_teller;

/**
 * Drupal AI Chat Interface.
 */
interface OpenAiChatInterface {

  /**
   * Get Chat.
   *
   * @param string $prompt
   *   The AI prompt.
   *
   * @return string
   *   The AI completion response.
   */
  public function getChat(string $prompt): string;

}
