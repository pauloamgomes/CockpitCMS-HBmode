# Cockpit Hybrid Mode Addon

This addon provides the ability to use Cockpit in an "non headless" mode!
Cockpit is by nature an headless CMS, providing a rich UI to manage contents and an API to fetch them, that means the need of a frontend that can consume, transform and display the page contents. That is the current trend of the CMS's, so why reverting that?

Mostly for fun and to confirm how flexible Cockpit can be.
But also because that can help the guys that don't want to deal with javascript frontends or static website generators.

Please note that the addon is the result of a Proof of Concept and therefore wasn't tested, it's possible that it doesn't work properly in some scenarios.

## Concept

The concept is quite simple, in Cockpit we can bind routes to a Controller, so we can make a strategy to have routes that correspond to a collection, e.g.:

* Basic Page  `page/*`
* Blog Post   `blog/*`
* Events      `event/*`

Using the BetterSlugs addon we can define a slug field that will match the above routes, so a blog entry will be `/blog/<blog-title>`

And implement our own controller that will get the page path, find the matching entry using the slug as filter, and finally render the entry.
Twig engine is used for rendering the pages, so we have all flexibility that we need to manipulate the markup.
The example theme is using Boostrap 4 native.
Its possible to preprocess the results using the following hooks:

- theme_hbmode_process_entry($app, &$entry)
The entry array can be manipulated before being rendered.
- theme_hbmode_process_header($app, &$vars)
The header variables can be changed, in the example theme the navigation menu is build using a collection.
- theme_hbmode_process_footer($app, &$vars)
The footer variables (e.g. copyright, etc..) can be changed.

## Installation

1. Install the BetterSlugs addon - https://github.com/pauloamgomes/CockpitCMS-BetterSlugs
2. Download and unpack addon to `<cockpit-folder>/addons/HBmode` folder.
3. Inside `<cockpit-folder>/addons/HBmode` install dependencies by running:
  `$ composer install`
4. Copy the example theme (hbmode) from the install folder to `storage/themes/`
5. Copy the example collection files from the install folder to `storage/collections/`
6. Import the collections entries from the install folder `storage/collections/*.json` files
   Step 5 and 6 are only required in way to work with the example theme.

If using the Helpers addon https://github.com/pauloamgomes/CockpitCMS-Helpers the steps 4, 5 and 6 can be simplified by running on the cockpit root folder:

```bash
$ ./cp install --name HBMode
```

## Configuration

add to `config/config.yaml`:

```yaml
hbmode:
  theme: hbmode
  homepage:
    collection: basic_page
    slug: /page/homepage
  routes:
      blog_post:
        collection: blog_post
        route: /blog/*
        template: blog.html.twig
      basic_page:
        collection: basic_page
        route: /page/*
        template: page.html.twig
```

The theme element defines the active theme (themes must be inside the `/storage/themes` folder).
The homepage element defines the collection and corresponding slug that will be used to serve the homepage.
The routes will define the pattern and template used for our collections, so we can have different templates.

## Usage

Play with the theme and change according to your needs.
Twig templates are cached, caches are removed when cleaning the global cockpit cache.

## Limitations

* Public pages only work when user is logged out of cockpit
* Just text and image/assets are being handled
* Security?! This is mostly a Proof of Concept, security or performaace are not being addressed.
* Depending on the needs, the theme may need to be adjusted
* Not handling layouts, blocks or more dynamic contents.
* Excluding the homepage all slugs need to have a prefix (e.g. page, blog)

## Todo

* Rethink how to deal with complex fields like layout grid
* Handle of custom components
* Handle authentication (right now pages cannot be previewed)
* Have non prefixed slugs working
* Load CSS and JS from the theme info.yaml file
* Code refactoring
* ...

## Demo

[![HBMode Addon Demo](http://img.youtube.com/vi/y7XehxEuw24/0.jpg)](http://www.youtube.com/watch?v=y7XehxEuw24 "HBMode Addon for Cockpit CMS")

## Copyright and license

Copyright 2019 pauloamgomes under the MIT license.
