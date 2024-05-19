<?php

namespace Drupal\fortune_teller;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Drupal\fortune_teller\OpenAiChatInterface;

/**
 * OpenAI implementation of Chat.
 */
class OpenAiChat implements OpenAiChatInterface {

  /**
   * The contents of the request.
   *
   * @var array
   */
  private $contents = [];

  /**
   * Get Chat.
   *
   * @param string $prompt
   *   The prompt to send to the API.
   *
   * @return string
   *   The response from the API.
   */
  public function getChat(string $prompt): string {
    $config = \Drupal::config('fortune_teller.settings');
    $api_key = $config->get('openai_api_key');
    $url = $config->get('chat_endpoint');

    if (!$api_key) {
      \Drupal::logger('fortune_telleri')->error('OpenAI API key not set.');
      return FALSE;
    }

    $client = new Client();

    $this->contents[] = [
      "role" => "user",
      "content" => $prompt,
    ];

    try {
      $response = $client->request('POST', $url, [
        'headers' => [
          'Content-Type' => 'application/json',
          'Authorization' => 'Bearer ' . $api_key,
        ],
        'json' => [
          "model" => "gpt-4-turbo",
          "messages" => $this->contents,
          "temperature" => 1,
          "max_tokens" => 4096,
          "top_p" => 1,
          "frequency_penalty" => 0,
          "presence_penalty" => 0,
        ],
      ]);
    }
    catch (RequestException $e) {
      \Drupal::logger('drupalai')->error($e->getMessage());
      return FALSE;
    }

    if ($response->getStatusCode() != 200) {
      \Drupal::logger('drupalai')->error($response->getBody()->getContents());
      return FALSE;
    }
    else {
      $data = $response->getBody()->getContents();
      $content = json_decode($data)->choices[0]->message->content;

      $this->contents[] = [
        "role" => "assistant",
        "content" => $content,
      ];

      return $content;
    }
  }
}
