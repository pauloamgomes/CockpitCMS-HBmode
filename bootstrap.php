<?php

if (!COCKPIT_API_REQUEST) {

  $this->module('hbmode')->extend([
    'isEnabled' => function() {
      // Only serve public routes if user is not authenticated.
      $user = $this->app->module('cockpit')->getUser();
      if ($user && $user['user'] !== 'anonymous') {
        return FALSE;
      }

      // Check if config contains required variables.
      $config = $this->app->config['hbmode'] ?? [];
      extract($config);

      if (!isset($homepage, $routes, $theme)) {
        return FALSE;
      }
      return TRUE;
    },
    'getTheme' => function($name) {
      if ($folder = $this->app->path("#storage:themes/{$name}")) {
        require_once ($folder . "/bootstrap.php");

        return Spyc::YAMLLoad("{$folder}/info.yaml");
      }
    },
    'getRenderer' => function($name) {
      if ($folder = $this->app->path("#storage:themes/{$name}")) {
        // Set theme templates folders.
        $folders = [
          $folder . "/templates",
          $folder . "/templates/fields",
        ];

        // Load templates.
        $loader = new \Twig_Loader_Filesystem($folders);

        // Set the cache folder.
        $cacheFolder = $this->app->path("#storage:cache/twig");
        if (!$cacheFolder) {
          $this->app->helper('fs')->mkdir("#storage:cache/twig");
        }

        // Initialize twig environment.
        $options = [
          'cache' => $cacheFolder,
          'debug' => FALSE,
        ];
        $twig = new \Twig_Environment($loader, $options);

        // Load extensions.
        $twig->addExtension(new \HBMode\Twig\AssetExtension());
        $twig->addExtension(new \Twig_Extensions_Extension_Text());
        $twig->addExtension(new \buzzingpixel\twigswitch\SwitchTwigExtension());
        return $twig;
      }
    }
  ]);

  $app->on('admin.init', function() use ($app) {

    if (!$app->module('hbmode')->isEnabled()) {
      return;
    }

    // Set a virtual anonymous user to be able to hook on error pages.
    $app->module('cockpit')->setUser(['user' => 'anonymous']);

    $config = $app->config['hbmode'];
    extract($config);

    // Bind homepage route.
    $this->bind('/', function() use($homepage, $theme) {
      $options = [
        'collection' => $homepage['collection'],
        'theme' => $theme,
        'slug' => $homepage['slug'],
      ];
      return $this->invoke('HBMode\\Controller\\Render', 'index', $options);
    });

    // Bind collections route.
    foreach ($routes as $name => $params) {
      $options = [
        'collection' => $name,
        'theme' => $theme,
      ];
      $this->bind($params['route'], function() use ($options) {
        return $this->invoke('HBMode\\Controller\\Render', 'index', $options);
     });
    }

  });

  // Rebind error routes.
  $app->on('after', function() use ($app) {
    if (!$app->module('hbmode')->isEnabled()) {
      return;
    }

    $config = $app->config['hbmode'];
    extract($config);

    switch ($this->response->status) {
      case 401:
        $this->response->status = 404;
      case 500:
      case 404:
        $args = [
          'theme' => $theme,
          'type' => $this->response->status,
        ];
        $contents = $this->invoke('HBMode\\Controller\\Render', 'error', $args);
        $this->response->body = $contents;
        break;
    }
  });

}

// Include admin.
if (COCKPIT_ADMIN && !COCKPIT_API_REQUEST) {
  include_once __DIR__ . '/admin.php';
}
