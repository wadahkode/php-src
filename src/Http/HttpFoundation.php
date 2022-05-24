<?php

namespace Wadahkode\Http;

class HttpFoundation
{
  /**
   * @var array $supportedHttpMethods = []
   */
  private $supportedHttpMethods = [];

  /**
   * @var array $urlToMatch = []
   */
  private $urlToMatch = ["/"];

  /**
   * @var object $globalHttpMethods
   */
  public $globalHttpMethods;

  // public function __construct(array $httpMethods=[])
  // {
  //   $this->supportedHttpMethods = !empty($httpMethods) ? $httpMethods : [
  //     'GET', 'POST', 'FILES', 'PUT', 'OPTIONS'
  //   ];
  // }

  // public function __call($name, $arguments)
  // {
  //   return $this->{$name}($arguments);
  // }

  public function __get($name)
  {
    return $this->{$name};
  }

  public function defaultRequestHandler()
  {
    header("{$this->globalHttpMethods->serverProtocol} 404 Not Found");
  }

  public function invalidMethodHandler()
  {
    header("{$this->globalHttpMethods->serverProtocol} 405 Method Not Allowed");
  }

  public function setUrlToMatch($url="/")
  {
    var_dump($this->urlToMatch);
//    return $this->urlToMatch = array_unique(
//      array_merge($this->urlToMatch, [$url])
//    );
  }

  public function parseURL()
  {
    $requestUri = "/";
    
    foreach ($this->urlToMatch as $url) {
      if (preg_match("/^\/([\w]+)(.*)/", $url, $match)) {
        $requestUri = rtrim($match[0], DIRECTORY_SEPARATOR);
      }
    }

    return filter_var($requestUri, FILTER_SANITIZE_URL);
  }

  public function pathHandler(string $pathname="")
  { 
    $result = (rtrim($pathname, '/'));
    return (($result !== '') ? $result : '/');
  }
}