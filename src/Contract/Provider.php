<?php

namespace Wadahkode\Contract;

class Provider
{
  // public function __call($name, $arguments)
  // {
  //   try {
  //     if (!method_exists($this, $name)) {
  //       throw new \Exception("Method: <b>$name</b> not found on the class " . self::class);
  //     }

  //     $this->{$name}($arguments[0]);
  //   } catch (\Exception $e) {
  //     printf("%s", $e->getMessage());
  //   }
  // }
  public function __get($name)
  {
    return $this->{$name};
  }

  public function store($request)
  {
    $this->__set('request', $request);
  }

  public function __set($name, $value)
  {
    $this->{$name} = $value;
  }
}