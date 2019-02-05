<?php

/**
 * Process functions for hbmode theme.
 */

/**
 * Process entry.
 */
function theme_hbmode_process_entry($app, &$entry) {
}

/**
 * Process header vars, e.g. site name, links.
 */
function theme_hbmode_process_header($app, &$vars) {
  $entries = $app->module('collections')->find("main_menu");
  foreach ($entries as $entry) {
    $vars['links'][$entry['_id']] = [
      'title' => $entry['title'],
      'slug' => $entry['link'],
    ];
  }
}

/**
 * Process footer vars, e.g. copyright, links.
 * You can get data from singletons or collections and return it inside $vars.
 * e.g.$vars['data'] = $app->module('singletons')->getData("footer");
 */
function theme_hbmode_process_footer($app, &$vars) {
}
