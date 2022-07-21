<?php
namespace Wadahkode\Console\Command;

trait Help
{
  protected $filename = "";
  protected $version = "0.0.1";
  
  public function show($list = "")
  {
    if (!empty($list)) {
      return false;
    }
    
    if (file_exists($this->basepath . 'samples/help.txt')) {
      $this->filename = $this->basepath . 'src/Console/Command/samples/help.txt';
    } else {
      $this->basepath = dirname(dirname($this->basepath)) . DIRECTORY_SEPARATOR;
      
      if (file_exists($this->basepath . 'src/Console/Command/samples/help.txt')) {
        $this->filename = $this->basepath . 'src/Console/Command/samples/help.txt';
      }
    }

    $version = file_get_contents($this->basepath . "composer.json");
    preg_match("/version.*/", $version, $v);
    preg_match('/\d.+/', $v[0], $verbose);
    $version = trim($verbose[0], ",\"");
    $this->version = $version;

    $help = file_get_contents($this->filename);
    $help = str_replace("@version", "v".$this->version, $help);

    echo $help . "\n";
  }
}