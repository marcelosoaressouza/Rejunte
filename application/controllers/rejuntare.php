<?php

require_once(APPPATH.'/libraries/rejunte_api.php');
require_once(APPPATH.'/libraries/REST_Controller.php');

class Rejuntare extends REST_Controller {

  function index() {}

  public function rest_get() {
    $rejunte = new Rejunte_API();

    $args = array('resource' => $this->get('resource'),
                  'media'    => $this->get('media'),
                  'username' => $this->get('username'),
                  'tag'      => $this->get('tag'),
                  'qnty'     => $this->get('qnty')
                 );
    
    $response = $rejunte->rejunteGet($args);

    if (!$response) die("Error in response.");

    $this->response($response, 200);
  }

  public function resource_list_get() {
    
    $dir = getcwd().'/application/plugins';
    $files = scandir($dir);

    $i = 0;

    foreach ($files as $file) {
      $resource = substr($file, 0, strrpos($file, '_'));
      if($resource) $response[$i++] = array('resource' => $resource);

    }

    $this->response($response, 200);
  }

}

?>
