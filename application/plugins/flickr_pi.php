<?php
require_once(APPPATH.'/libraries/rejunte_plugin.php');

class Rejunte_Plugin extends Rejunte_Plugin_Abstract
{

  private $_resource = 'flickr';

  public function getResponse($args) {
    $username = $args['username'];

    if (!$username) show_error('You need to set the name of the user.');

    require_once(APPPATH.'3rdparty/phpflickr/phpFlickr.php');

    $rejunte_flickr = new phpFlickr("281dec6d918658698150073a281e9a85", "006793fe5ff8225f");
    $user = $rejunte_flickr->people_findByUsername($username);
    $photos_page = $rejunte_flickr->photos_search(array('user_id' => $user['nsid']));
    
    $i = 0;

    foreach($photos_page['photo'] as $photo) {
     
      $url = 'http://farm'.$photo['farm'].'.static.flickr.com/'.$photo['server'].'/'.$photo['id'].'_'.$photo['secret'].'.jpg';

      $response[$i++] = array('url'         => $url,
                              'preview'     => $url,
                              'title'       => htmlentities($photo['title'], ENT_QUOTES, 'UTF-8'),
                              'description' => NULL,
                              'license'     => NULL,
                              'author'      => NULL);

    }

    return $response;

  }

}
?>
