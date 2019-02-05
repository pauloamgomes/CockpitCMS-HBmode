<?php
 return array (
  'name' => 'blog_post',
  'label' => 'Blog Post',
  '_id' => 'blog_post5c578c8a63b0f',
  'fields' => 
  array (
    0 => 
    array (
      'name' => 'title',
      'label' => 'Title',
      'type' => 'text',
      'default' => '',
      'info' => '',
      'localize' => false,
      'options' => 
      array (
        'slug' => true,
      ),
      'width' => '1-2',
      'lst' => true,
      'required' => true,
    ),
    1 => 
    array (
      'name' => 'slug',
      'label' => '',
      'type' => 'slug',
      'default' => '',
      'info' => '',
      'group' => '',
      'localize' => false,
      'options' => 
      array (
        'format' => '/blog/[field:title]',
      ),
      'width' => '1-2',
      'lst' => true,
      'acl' => 
      array (
      ),
    ),
    2 => 
    array (
      'name' => 'image',
      'label' => 'Featured Image',
      'type' => 'asset',
      'default' => '',
      'info' => '',
      'localize' => false,
      'options' => 
      array (
      ),
      'width' => '1-1',
      'lst' => true,
    ),
    3 => 
    array (
      'name' => 'excerpt',
      'label' => 'Excerpt',
      'type' => 'wysiwyg',
      'default' => '',
      'info' => '',
      'localize' => false,
      'options' => 
      array (
      ),
      'width' => '1-1',
      'lst' => false,
    ),
    4 => 
    array (
      'name' => 'content',
      'label' => 'Content',
      'type' => 'wysiwyg',
      'default' => '',
      'info' => '',
      'localize' => false,
      'options' => 
      array (
      ),
      'width' => '1-1',
      'lst' => false,
    ),
    5 => 
    array (
      'name' => 'tags',
      'label' => 'Tags',
      'type' => 'tags',
      'default' => '',
      'info' => '',
      'localize' => false,
      'options' => 
      array (
      ),
      'width' => '1-1',
      'lst' => true,
    ),
  ),
  'sortable' => false,
  'in_menu' => false,
  '_created' => 1549241482,
  '_modified' => 1549322467,
  'color' => '',
  'acl' => 
  array (
  ),
  'rules' => 
  array (
    'create' => 
    array (
      'enabled' => false,
    ),
    'read' => 
    array (
      'enabled' => false,
    ),
    'update' => 
    array (
      'enabled' => false,
    ),
    'delete' => 
    array (
      'enabled' => false,
    ),
  ),
);