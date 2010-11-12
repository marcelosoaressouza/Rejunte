<?php
class Rejunte_API extends Controller
{

  public function rejunteGet($args) {
    $resource  = $args['resource'];

    if (!$resource) show_error('You need to define the resource you wish to use.');

    $this->load->plugin($resource);

    $rejunte = new Rejunte_Plugin();

    return $rejunte->getResponse($args);
  }

}
?>
