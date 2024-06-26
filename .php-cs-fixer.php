<?php
declare(strict_types=1);

$fixers = [
  '@Symfony' => true,
  'array_syntax' => [
    'syntax' => 'short',
  ],
  'combine_consecutive_unsets' => true,
  'no_useless_else' => true,
  'no_useless_return' => true,
  'no_extra_blank_lines' => [
    'tokens' => [
      'attribute',
      'case',
      'continue',
      'curly_brace_block',
      'default',
      'extra',
      'parenthesis_brace_block',
      'square_brace_block',
      'throw',
      'use',
    ],
  ],
  'ordered_imports' => [
    'sort_algorithm' => 'length',
  ],
  'phpdoc_indent' => false,
  'phpdoc_annotation_without_dot' => false,
  'phpdoc_no_empty_return' => false,
  'phpdoc_no_alias_tag' => [
    'replacements' => [
      // 'property-read' => 'property',
      // 'property-write' => 'property',
      'type' => 'var',
      'link' => 'see',
    ],
  ],
  'no_superfluous_phpdoc_tags' => false,
  'concat_space' => [
    'spacing' => 'one',
  ],
  'yoda_style' => false,
  'no_null_property_initialization' => false,
  'nullable_type_declaration_for_default_null_value' => true,
  'global_namespace_import' => [
    'import_classes' => true,
    'import_constants' => null,
    'import_functions' => null,
  ],
];

return (new \PhpCsFixer\Config())
  ->setFinder(
    PhpCsFixer\Finder::create()
      ->in(__DIR__ . '/src')
      ->in(__DIR__ . '/tests')
      ->notPath('cache') // Note: The pattern is seen relative from one of the `->in()` directories. And works for files too this way.
  )
  ->setRules($fixers)
;
