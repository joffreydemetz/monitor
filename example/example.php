<?php

/**
 * JDZ Monitor - Example usage
 */
require __DIR__ . '/../vendor/autoload.php';

use JDZ\Monitor\Monitor;

$monitor = new Monitor();

// Add headings
$monitor->h1('Process Report');
$monitor->h2('Summary');

// Add paragraphs
$monitor->p('Process completed successfully.');
$monitor->p('42 items processed', 'Total');
$monitor->p('0 errors found', 'Errors', 'color:green;');

// Add a list
$monitor->list([
    'Step 1: Data fetched',
    'Step 2: Data validated',
    'Step 3: Data imported',
]);

// Add preformatted content
$monitor->pre("SELECT * FROM users\nWHERE active = 1");

// Add a colored box with mixed content
$monitor->box([
    (object)['h' => 'Details', 'level' => 3],
    (object)['content' => '150ms', 'label' => 'Duration'],
    (object)['list' => ['cache: HIT', 'db: 2 queries']],
], '#E8F5E9', '#1B5E20');

// Add raw HTML
$monitor->addHtmlString('<hr/>');

// Check if there is content
if ($monitor->hasContent()) {
    // Get the full HTML output
    $html = (string)$monitor;

    // Display in browser
    echo $html;

    // Or use with jdz/mailer to send by email
    // $mailer->setContent(['isHtml' => true, 'content' => $html]);
    // $mailer->send();
}
