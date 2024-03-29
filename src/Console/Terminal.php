<?php
namespace Wadahkode\Console;

use \Wadahkode\Console\Command\Help;
use \Wadahkode\Console\Command\Make;

class Terminal
{
  use Help, Make;
  
  protected $command;
  protected $basepath = "";
  
  public function __construct($command=null)
  {
    $this->command = $command;
    
    if (php_sapi_name() !== "cgi-fcgi") {
        $this->basepath = realpath(
            rtrim(__DIR__, '/\\')
        ) . DIRECTORY_SEPARATOR;
    } else {
        $this->basepath = __DIR__;
    }
    
    return $this;
  }
  
  public function execute()
  {
    if (count($this->command) < 2) {
        return $this->show();
    }
    unset($this->command[0]);
    $command = array_values($this->command);
    
    if (count($command) > 1) {
      list($method, $name) = $command;
      
      if (preg_match('/:/', $method)) {
        $method = explode(":", $method);
        $this->{$method[0]}($method[1], $name);
      } else {
        $this->{$method}($name);
      }
    } else {
      $this->{$command[0]}(null);
    }
  }
  
  private function help($param)
  {
    if ($param !== "list") {
      exit(1);
    }
    return $this->show();
  }
  
  private function make($name, $param)
  {
    switch ($name) {
      case 'controller':
        $this->createController($param);
        break;
          
      case 'model':
        $this->createModel($param);
        break;
      
      default:
        // code...
        break;
    }
  }
  
  static public function register(callable $console)
  {
    return $console(new self(TERMINAL_INPUT));
  }
  
  private function serve($argv)
  {
    if (!empty($argv) && $argv == '--with-nodejs') {
      return exec('nodemon ./build/serve.js');
    } else {
      exec("echo -n '\e[32m[+] Server running on http://localhost:8000\e[0m\n';", $output);

      printf("%s\n", $output[0]);

      return exec("php -S localhost:8000 -t ./public");
    }
  }
}