# Fortune Teller Module

The Fortune Teller module adds a custom fortune-telling functionality to blog posts in a Drupal site. It uses the OpenAI API to generate fortunes based on the content of the blog post.

## Features

- Adds a "Your Fortune" field to the blog content type.
- Automatically generates a fortune based on the body text of the blog post using the OpenAI API.
- Displays messages upon creating or updating blog posts to indicate that the fortune has been added or updated.

## Installation

1. Place the `fortune_teller` module in the `modules/custom` directory of your Drupal installation.
2. Enable the module by navigating to **Extend** and searching for `Fortune Teller`. Alternatively, you can enable it using Drush:
   ```sh
   drush en fortune_teller

## Requirements
- Drupal 10.x
- PHP 7.4 or higher
