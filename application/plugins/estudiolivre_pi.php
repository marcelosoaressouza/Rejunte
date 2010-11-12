<?php

require_once(APPPATH.'/libraries/rejunte_plugin.php');

class Rejunte_Plugin extends Rejunte_Plugin_Abstract
{

  private $_resource = 'estudiolivre';

  public function getResponse($args) {
    $media    = $args['media'];
    $username = $args['username'];
    $qnty     = $args['qnty'];

    if (!$username) show_error('You need to set the name of the user.');
    if (!$media) show_error('You need to set the media type you want.');
    if ($qnty) $end = $qnty; else $end = 3;
    
    require_once(APPPATH.'3rdparty/simplepie/simplepie.class.php');

    $feed = new SimplePie();
    $feed->enable_cache(false);
    $feed->set_feed_url('http://estudiolivre.org/el-gallery_rss.php?ver=2&user='.$username.'&type='.$media);
    $feed->init();
    $feed->handle_content_type();

    $i = 0;

    foreach($feed->get_items(0, $end) as $item) {
      $response[$i++] = array('url'         => $item->get_permalink(),
                              'preview'     => NULL,
                              'title'       => htmlentities($item->get_title(), ENT_QUOTES, 'UTF-8'),
                              'description' => htmlentities($item->get_description(), ENT_QUOTES, 'UTF-8'),
                              'license'     => htmlentities($item->get_copyright(), ENT_QUOTES, 'UTF-8'),
                              'author'      => htmlentities($item->get_author()->get_name(), ENT_QUOTES, 'UTF-8'));

    }

    return $response;

  }

}

?>