<?php

namespace JDZ\Monitor\Tests;

use PHPUnit\Framework\TestCase;
use JDZ\Monitor\Monitor;
use JDZ\Monitor\MonitorHtml;

class MonitorTest extends TestCase
{
    public function testConstructor(): void
    {
        $monitor = new Monitor();

        $this->assertInstanceOf(MonitorHtml::class, $monitor->html);
        $this->assertFalse($monitor->hasContent());
    }

    public function testHasContentFalseWhenEmpty(): void
    {
        $monitor = new Monitor();

        $this->assertFalse($monitor->hasContent());
    }

    public function testHasContentTrueAfterAdd(): void
    {
        $monitor = new Monitor();
        $monitor->h1('Title');

        $this->assertTrue($monitor->hasContent());
    }

    public function testToString(): void
    {
        $monitor = new Monitor();
        $monitor->h1('Title');
        $monitor->p('Paragraph');

        $result = (string)$monitor;

        $this->assertStringContainsString('<h1>Title</h1>', $result);
        $this->assertStringContainsString('<p>Paragraph</p>', $result);
    }

    public function testToStringJoinsWithSpace(): void
    {
        $monitor = new Monitor();
        $monitor->h1('A');
        $monitor->h2('B');

        $result = (string)$monitor;

        $this->assertEquals('<h1>A</h1> <h2>B</h2>', $result);
    }

    // ========================================
    // HEADINGS
    // ========================================

    public function testH1ThroughH6(): void
    {
        $monitor = new Monitor();

        $this->assertSame($monitor, $monitor->h1('H1'));
        $this->assertSame($monitor, $monitor->h2('H2'));
        $this->assertSame($monitor, $monitor->h3('H3'));
        $this->assertSame($monitor, $monitor->h4('H4'));
        $this->assertSame($monitor, $monitor->h5('H5'));
        $this->assertSame($monitor, $monitor->h6('H6'));

        $result = (string)$monitor;
        $this->assertStringContainsString('<h1>H1</h1>', $result);
        $this->assertStringContainsString('<h6>H6</h6>', $result);
    }

    public function testHWithLevel(): void
    {
        $monitor = new Monitor();
        $result = $monitor->h('Custom', 3);

        $this->assertSame($monitor, $result);
        $this->assertStringContainsString('<h3>Custom</h3>', (string)$monitor);
    }

    // ========================================
    // PARAGRAPH
    // ========================================

    public function testP(): void
    {
        $monitor = new Monitor();
        $result = $monitor->p('Text', 'Label', 'color:blue');

        $this->assertSame($monitor, $result);
        $output = (string)$monitor;
        $this->assertStringContainsString('<strong>Label</strong>: Text', $output);
        $this->assertStringContainsString('style="color:blue"', $output);
    }

    public function testPDefault(): void
    {
        $monitor = new Monitor();
        $monitor->p();

        $this->assertStringContainsString('<p><br/></p>', (string)$monitor);
    }

    // ========================================
    // PRE
    // ========================================

    public function testPre(): void
    {
        $monitor = new Monitor();
        $result = $monitor->pre("line1\nline2");

        $this->assertSame($monitor, $result);
        $this->assertStringContainsString('line1<br />', (string)$monitor);
    }

    public function testPreEmptyIgnored(): void
    {
        $monitor = new Monitor();
        $monitor->pre([]);

        $this->assertFalse($monitor->hasContent());
    }

    // ========================================
    // BOX
    // ========================================

    public function testBox(): void
    {
        $monitor = new Monitor();
        $result = $monitor->box('Content', '#000', '#FFF');

        $this->assertSame($monitor, $result);
        $this->assertStringContainsString('Content', (string)$monitor);
        $this->assertStringContainsString('background-color:#000', (string)$monitor);
    }

    // ========================================
    // LIST
    // ========================================

    public function testList(): void
    {
        $monitor = new Monitor();
        $result = $monitor->list(['item1', 'item2']);

        $this->assertSame($monitor, $result);
        $this->assertStringContainsString('<li>item1</li>', (string)$monitor);
        $this->assertStringContainsString('<li>item2</li>', (string)$monitor);
    }

    public function testListEmptyIgnored(): void
    {
        $monitor = new Monitor();
        $monitor->list([]);

        $this->assertFalse($monitor->hasContent());
    }

    // ========================================
    // ADD HTML STRING
    // ========================================

    public function testAddHtmlString(): void
    {
        $monitor = new Monitor();
        $result = $monitor->addHtmlString('<div>Custom</div>');

        $this->assertSame($monitor, $result);
        $this->assertStringContainsString('<div>Custom</div>', (string)$monitor);
    }

    public function testAddHtmlStringEmptyIgnored(): void
    {
        $monitor = new Monitor();
        $monitor->addHtmlString('');

        $this->assertFalse($monitor->hasContent());
    }

    // ========================================
    // CHAINING
    // ========================================

    public function testFluentChaining(): void
    {
        $monitor = new Monitor();

        $result = $monitor
            ->h1('Report')
            ->p('Status: OK', 'Info')
            ->list(['Step 1', 'Step 2'])
            ->box('Summary');

        $this->assertSame($monitor, $result);
        $this->assertTrue($monitor->hasContent());

        $output = (string)$monitor;
        $this->assertStringContainsString('<h1>Report</h1>', $output);
        $this->assertStringContainsString('<strong>Info</strong>', $output);
        $this->assertStringContainsString('<li>Step 1</li>', $output);
        $this->assertStringContainsString('Summary', $output);
    }
}
