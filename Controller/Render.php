<?php

namespace HBMode\Controller;

use \Lime\AppAware;

require __DIR__ . '../../vendor/autoload.php';

/**
 * Admin controller class.
 */
class Render extends AppAware {

  /**
   * Default controller action.
   */
  public function index($name, $theme, $slug = FALSE) {
    if (!$slug) {
      $slug = $_SERVER['REQUEST_URI'];
    }

    $options = [
      'slug' => $slug,
    ];

    $entry = $this->module('collections')->findOne($name, $options);
    if ($entry) {
      $this->render($name, $theme, $entry);
    }
  }

  public function error($theme, $type) {
    $info = $this->module('hbmode')->getTheme($theme);
    $renderer = $this->module('hbmode')->getRenderer($theme);

    $contents['main'] = $renderer->render("{$type}.html.twig", []);
    return print $renderer->render("page.html.twig", $contents);
  }

  /**
   * Renders a collection entry.
   */
  public function render($name, $theme, $entry = []) {

    $info = $this->module('hbmode')->getTheme($theme);
    $renderer = $this->module('hbmode')->getRenderer($theme);

    $vars = $info['vars'];
    $vars['config'] = $this->config;
    $vars['path'] = $_SERVER['REQUEST_URI'];

    call_user_func_array("theme_{$theme}_process_entry", [$this, &$entry]);

    $contents = [];
    // Render Regions.
    foreach ($info['regions'] as $key => $template) {
      if (function_exists("theme_{$theme}_process_{$key}")) {
        call_user_func_array("theme_{$theme}_process_{$key}", [$this, &$vars]);
      }
      $contents[$key] = $renderer->render($template, ['vars' => $vars]);
    }

    // Render entry.
    $contents['main'] = $renderer->render("{$name}.html.twig", ['entry' => $entry, 'vars' => $vars]);

    print $renderer->render("page.html.twig", $contents);

    $this->stop();
  }

}
