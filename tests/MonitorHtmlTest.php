<?php

namespace JDZ\Monitor\Tests;

use PHPUnit\Framework\TestCase;
use JDZ\Monitor\MonitorHtml;

class MonitorHtmlTest extends TestCase
{
    private MonitorHtml $html;

    protected function setUp(): void
    {
        $this->html = new MonitorHtml();
    }

    // ========================================
    // HEADINGS
    // ========================================

    public function testH(): void
    {
        $this->assertEquals('<h1>Title</h1>', $this->html->h('Title', 1));
        $this->assertEquals('<h3>Sub</h3>', $this->html->h('Sub', 3));
    }

    public function testH1ThroughH6(): void
    {
        $this->assertEquals('<h1>T</h1>', $this->html->h1('T'));
        $this->assertEquals('<h2>T</h2>', $this->html->h2('T'));
        $this->assertEquals('<h3>T</h3>', $this->html->h3('T'));
        $this->assertEquals('<h4>T</h4>', $this->html->h4('T'));
        $this->assertEquals('<h5>T</h5>', $this->html->h5('T'));
        $this->assertEquals('<h6>T</h6>', $this->html->h6('T'));
    }

    // ========================================
    // PARAGRAPH
    // ========================================

    public function testPBasic(): void
    {
        $this->assertEquals('<p>Hello</p>', $this->html->p('Hello'));
    }

    public function testPDefault(): void
    {
        $this->assertEquals('<p><br/></p>', $this->html->p());
    }

    public function testPWithLabel(): void
    {
        $this->assertEquals('<p><strong>Name</strong>: John</p>', $this->html->p('John', 'Name'));
    }

    public function testPWithStyle(): void
    {
        $this->assertEquals('<p style="color:red">Error</p>', $this->html->p('Error', '', 'color:red'));
    }

    public function testPWithLabelAndStyle(): void
    {
        $result = $this->html->p('value', 'key', 'font-weight:bold');
        $this->assertStringContainsString('style="font-weight:bold"', $result);
        $this->assertStringContainsString('<strong>key</strong>: value', $result);
    }

    // ========================================
    // LIST
    // ========================================

    public function testList(): void
    {
        $result = $this->html->list(['one', 'two', 'three']);

        $this->assertEquals('<ul><li>one</li><li>two</li><li>three</li></ul>', $result);
    }

    public function testListEmpty(): void
    {
        $this->assertEquals('', $this->html->list([]));
    }

    // ========================================
    // PRE
    // ========================================

    public function testPreWithString(): void
    {
        $result = $this->html->pre("line1\nline2");

        $this->assertStringContainsString('line1<br />', $result);
        $this->assertStringContainsString('line2<br />', $result);
        $this->assertStringContainsString('background-color:', $result);
    }

    public function testPreWithArray(): void
    {
        $result = $this->html->pre(['foo', 'bar']);

        $this->assertStringContainsString('foo<br />', $result);
        $this->assertStringContainsString('bar<br />', $result);
    }

    public function testPreEmptyReturnsEmpty(): void
    {
        $this->assertEquals('', $this->html->pre([]));
    }

    public function testPreCustomColors(): void
    {
        $result = $this->html->pre('text', '#000', '#FFF');

        $this->assertStringContainsString('background-color:#000', $result);
        $this->assertStringContainsString('color:#FFF', $result);
    }

    // ========================================
    // BOX
    // ========================================

    public function testBoxWithString(): void
    {
        $result = $this->html->box('Content');

        $this->assertStringContainsString('<div style="background-color:#F9F9F9;color:#121212;padding:10px;margin-bottom:10px;">', $result);
        $this->assertStringContainsString('Content', $result);
        $this->assertStringContainsString('</div>', $result);
    }

    public function testBoxWithCustomColors(): void
    {
        $result = $this->html->box('X', '#FF0000', '#FFFFFF');

        $this->assertStringContainsString('background-color:#FF0000', $result);
        $this->assertStringContainsString('color:#FFFFFF', $result);
    }

    public function testBoxWithArrayOfStrings(): void
    {
        $result = $this->html->box(['Line 1', 'Line 2']);

        $this->assertStringContainsString('<p>Line 1</p>', $result);
        $this->assertStringContainsString('<p>Line 2</p>', $result);
    }

    public function testBoxWithObjectContent(): void
    {
        $line = (object)['content' => 'Value', 'label' => 'Key'];
        $result = $this->html->box([$line]);

        $this->assertStringContainsString('<strong>Key</strong>: Value', $result);
    }

    public function testBoxWithObjectHeading(): void
    {
        $line = (object)['h' => 'Title', 'level' => 2];
        $result = $this->html->box([$line]);

        $this->assertStringContainsString('<h2>Title</h2>', $result);
    }

    public function testBoxWithObjectHeadingDefaultLevel(): void
    {
        $line = (object)['h' => 'Title'];
        $result = $this->html->box([$line]);

        $this->assertStringContainsString('<h2>Title</h2>', $result);
    }

    public function testBoxWithObjectPre(): void
    {
        $line = (object)['pre' => "code\nhere"];
        $result = $this->html->box([$line]);

        $this->assertStringContainsString('code<br />', $result);
    }

    public function testBoxWithObjectList(): void
    {
        $line = (object)['list' => ['a', 'b']];
        $result = $this->html->box([$line]);

        $this->assertStringContainsString('<ul><li>a</li><li>b</li></ul>', $result);
    }
}
