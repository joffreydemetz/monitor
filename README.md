# JDZ Monitor

Formatted HTML monitoring output for PHP processes. Build structured HTML reports (headings, paragraphs, lists, boxes, preformatted blocks) to display in a browser or send by email via `jdz/mailer`.

## Installation

```bash
composer require jdz/monitor
```

## Requirements

- PHP >= 8.2

## Usage

### Basic Example

```php
use JDZ\Monitor\Monitor;

$monitor = new Monitor();

$monitor->h1('Process Report');
$monitor->p('Process completed successfully.');
$monitor->p('42 items processed', 'Total');

echo (string)$monitor;
```

### Headings

```php
$monitor->h1('Title');      // <h1>
$monitor->h2('Subtitle');   // <h2>
// ... up to h6()
```

### Paragraphs

```php
// Simple paragraph
$monitor->p('Some text');

// With a bold label prefix
$monitor->p('150ms', 'Duration');
// Output: <p><strong>Duration</strong>: 150ms</p>

// With inline style
$monitor->p('All good', 'Status', 'color:green;');
```

### Lists

```php
$monitor->list([
    'Step 1: Data fetched',
    'Step 2: Data validated',
    'Step 3: Data imported',
]);
```

### Preformatted Content

```php
// String (newlines are converted to <br />)
$monitor->pre("line 1\nline 2");

// Or an array of lines
$monitor->pre(['line 1', 'line 2']);
```

### Colored Boxes

```php
// Simple string box
$monitor->box('Some content', '#E8F5E9', '#1B5E20');

// Mixed content box with structured objects
$monitor->box([
    (object)['h' => 'Details', 'level' => 3],
    (object)['content' => '150ms', 'label' => 'Duration'],
    (object)['pre' => "SELECT * FROM users"],
    (object)['list' => ['cache: HIT', 'db: 2 queries']],
    'Plain string line',
]);
```

### Raw HTML

```php
$monitor->addHtmlString('<hr/>');
```

### Checking for Content

```php
if ($monitor->hasContent()) {
    $html = (string)$monitor;
}
```

### Sending by Email

Pair with `jdz/mailer` (^2.0) to email the report — a sender and a domain are required:

```php
use JDZ\Monitor\Monitor;
use JDZ\Mailer\Mailer;

$monitor = new Monitor();
$monitor->h1('Cron Report');
$monitor->p('Everything OK');

$mail = new Mailer();
$mail->domain = 'example.com';
$mail->dsn = $_ENV['MAILER_DSN'];   // jdz/mailer 2.x: any symfony/mailer DSN (or setSMTP([...]))
$mail->setFrom('cron@example.com', 'Cron');
$mail->setContent([
    'isHtml' => true,
    'content' => (string)$monitor,
]);
$mail->addRecipient('admin@example.com');
$mail->set('subject', 'Cron Report');
$mail->send();
```

## Fluent Interface

All content methods return `$this`, so calls can be chained:

```php
$monitor
    ->h1('Report')
    ->p('All systems operational')
    ->list(['API: OK', 'DB: OK', 'Cache: OK'])
    ->box('No errors', '#E8F5E9', '#1B5E20');
```

## Testing

```bash
composer test
# or
vendor/bin/phpunit
```

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
