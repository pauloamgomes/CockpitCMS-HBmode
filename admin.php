<?php

// Hook into global cockpit cache clear.
$this->on('cockpit.clearcache', function ()  {
  $cacheFolder = $this->app->path("#storage:cache/twig");

  if ($cacheFolder) {
    $this->app->helper('fs')->delete($cacheFolder);
  }
});
