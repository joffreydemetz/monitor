<?php 
/**
 * (c) Joffrey Demetz <joffrey.demetz@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace JDZ\Spy;

/**
 * Html
 * 
 * @author Joffrey Demetz <joffrey.demetz@gmail.com>
 */
class SpyHtml
{
  public function box(string|array $content, string $bgColor='#F9F9F9', string $fgColor='#121212'): string
  {
    $html = '';
    
    $html .= '<div style="background-color:'.$bgColor.';color:'.$fgColor.';padding:10px;margin-bottom:10px;">';
    
    if ( \is_array($content) ){
      foreach($content as $line){
        if ( \is_object($line) ){
          if ( isset($line->h) ){
            $html .= $this->h($line->h, !empty($line->level)?(int)$line->level:2);
            continue;
          }
          
          if ( isset($line->pre) ){
            $html .= $this->pre($line->pre);
            continue;
          }
          
          if ( isset($line->list) ){
            $html .= $this->list($line->list);
            continue;
          }
          
          $html .= $this->p($line->content, $line->label??'');
          continue;
        }
        
        $html .= $this->p((string)$line);
      }
    }
    else {
      $html .= (string)$content;
    }
    
    $html .= '</div>';
    return $html;
  }
  
  public function h(string $content, int $level=1): string
  {
    return '<h'.$level.'>'.$content.'</h'.$level.'>';
  }
  
  public function h1(string $content): string
  {
    return $this->h($content, 1);
  }
  
  public function h2(string $content): string
  {
    return $this->h($content, 2);
  }
  
  public function h3(string $content): string
  {
    return $this->h($content, 3);
  }
  
  public function h4(string $content): string
  {
    return $this->h($content, 4);
  }
  
  public function h5(string $content): string
  {
    return $this->h($content, 5);
  }
  
  public function h6(string $content): string
  {
    return $this->h($content, 6);
  }
  
  public function p(string $content='<br/>', string $label='', string $style=''): string
  {
    if ( '' !== $label ){
      return '<p'.($style?' style="'.$style.'"':'').'><strong>'.$label.'</strong>: '.$content.'</p>';
    }
    return '<p'.($style?' style="'.$style.'"':'').'>'.$content.'</p>';
  }
  
  public function pre(string|array $content, string $bgColor='#F9F9F9', string $fgColor='#121212'): string
  {
    if ( !\is_array($content) ){
      $content = explode("\n", $content);
    }
    
    if ( !empty($content) ){
      $pre='';
      foreach($content as $line){
        $pre .= $line."<br />";
      }
      return $this->box($pre, $bgColor, $fgColor);
    }
    
    return '';
  }
  
  public function list(array $list): string
  {
    $html='';
    if ( !empty($list) ){
      $html .= '<ul>';
      foreach($list as $line){
        $html .= '<li>'.$line.'</li>';
      }
      $html .= '</ul>';
    }
    return $html;
  }
}
