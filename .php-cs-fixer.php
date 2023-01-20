<?php

$finder = (new PhpCsFixer\Finder())
    ->exclude('vendor')
    ->in(__DIR__);

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setUsingCache(true)
    ->setCacheFile(__DIR__ . '/.php_cs.cache')
    ->setRules([
        '@PSR2' => true,
        'array_syntax' => ['syntax' => 'short'],
        'blank_line_before_statement' => true,
        'cast_spaces' => true,
        'concat_space' => ['spacing' => 'one'],
        'no_empty_statement' => true,
        'no_extra_blank_lines' => true,
        'no_leading_import_slash' => true,
        'no_multiline_whitespace_around_double_arrow' => true,
        'multiline_whitespace_before_semicolons' => false,
        'no_trailing_comma_in_singleline_array' => true,
        'no_unused_imports' => true,
        'no_whitespace_in_blank_line' => true,
        'object_operator_without_whitespace' => true,
        'ordered_imports' => ['sort_algorithm' => 'length'],
        'phpdoc_order' => true,
        'phpdoc_separation' => false,
        'phpdoc_summary' => true,
        'space_after_semicolon' => true,
        'standardize_not_equals' => true,
        'ternary_to_null_coalescing' => true,
        'trailing_comma_in_multiline' => true,
    ])
    ->setFinder($finder);
