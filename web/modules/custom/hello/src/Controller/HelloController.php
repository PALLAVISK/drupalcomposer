<?php

namespace Drupal\hello\Controller;

use Drupal\Core\Controller\ControllerBase;


class HelloController extends ControllerBase{
  /**
   * Returns a simple page.
   *
   * @return array
   *   A simple renderable array.
   */
  public function content() {
    $element = array(
      '#markup' => 'Hello world!',
    );
    return $element;
  }

}