<?php

require_once(APPPATH.'/libraries/rejunte_plugin.php');
/*
 * demo_pi.php
 */
class Rejunte_Plugin extends Rejunte_Plugin_Abstract
{

  private $_resource = 'demo';

  /*
   * getResponse($args)
   * 
   */
  public function getResponse($args) {
    $username = $args['username'];

    if (!$username) show_error('You need to set the name of the user.');

    $response[0] = array('url'         => NULL,
                         'preview'     => NULL,
                         'title'       => $this->_resource,
                         'description' => NULL,
                         'license'     => NULL,
                         'author'      => $username);

    return $response;

  }

}

?>