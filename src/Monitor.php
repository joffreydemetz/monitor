<?php 
/**
 * (c) Joffrey Demetz <joffrey.demetz@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace JDZ\Monitor;

use JDZ\Monitor\MonitorHtml;

/**
 * Monitor
 * used to export infos into HTML content
 * for debug or info printing to screen or sending it by mail
 * 
 * @author Joffrey Demetz <joffrey.demetz@gmail.com>
 */
class Monitor
{
  public MonitorHtml $html;
  
  protected array $data = [];
  
  public function __construct()
  {
    $this->html = new MonitorHtml();
  }
  
  public function __toString(): string
  {
    return implode(" ", $this->data);
  }
  
  public function hasContent(): bool
  {
    return !empty($this->data);
  }
  
  public function addHtmlString(string $html)
  {
    if ( !empty($html) ){
      $this->data[] = $html;
    }
    return $this;
  }
  
  public function h(string $content, int $level=1)
  {
    $this->data[] = $this->html->h($content, $level);
    return $this;
  }
  
  public function h1(string $content)
  {
    return $this->h($content, 1);
  }
  
  public function h2(string $content)
  {
    return $this->h($content, 2);
  }
  
  public function h3(string $content)
  {
    return $this->h($content, 3);
  }
  
  public function h4(string $content)
  {
    return $this->h($content, 4);
  }
  
  public function h5(string $content)
  {
    return $this->h($content, 5);
  }
  
  public function h6(string $content)
  {
    return $this->h($content, 6);
  }
  
  public function p(string $content='<br/>', string $label='', string $style='')
  {
    $this->data[] = $this->html->p($content, $label, $style);
    return $this;
  }
  
  public function pre(string|array $content)
  {
    if ( $content ){
      $this->data[] = $this->html->pre($content);
    }
    return $this;
  }
  
  public function box(string|array $content, string $bgColor='#F9F9F9', string $fgColor='#121212')
  {
    if ( $html = $this->html->box($content, $bgColor, $fgColor) ){
      $this->data[] = $html;
    }
    
    return $this;
  }
  
  public function list(array $list)
  {
    if ( !empty($list) ){
      $this->data[] = $this->html->list($list);
    }
    return $this;
  }
}
