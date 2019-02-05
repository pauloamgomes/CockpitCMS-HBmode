<?php

namespace HBMode\Twig;

class AssetExtension extends \Twig_Extension {
    public function getFilters() {
        $filter = new \Twig_SimpleFilter('image_path', function ($context, $image) {
            $config = $context['vars']['config'];
            $prefix = $config['media.path'] ?? '/storage/uploads';
            if (!preg_match("|^{$prefix}|", $image['path'])) {
                return $prefix . $image['path'];
            }
            return $image['path'];
        }, ['needs_context' => true]);

        return [$filter];
    }

    public function getName() {
        return 'asset_extension';
    }
}
