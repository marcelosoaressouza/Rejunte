<?php

require_once(APPPATH.'/libraries/rejunte_plugin.php');

class Rejunte_Plugin extends Rejunte_Plugin_Abstract
{

  private $_resource = 'youtube';

  public function getResponse($args) {
    $username = $args['username'];
    $tag      = $args['tag'];
    $qnty     = $args['qnty'];

    if ((!$username) && (!$tag)) show_error('You need to set a username or a tag.');

    require_once('Zend/Loader.php');
    Zend_Loader::loadClass('Zend_Gdata_HttpClient');
    Zend_Loader::loadClass('Zend_Gdata_YouTube');

    $youtube = new Zend_Gdata_YouTube();
    
    if ($username)
      $query = $youtube->newVideoQuery('http://gdata.youtube.com/feeds/users/' . $username . '/uploads');
    else if ($tag)
      $query = $youtube->newVideoQuery()->setQuery($tag);

    if (!$qnty) $query->maxResults = 5; else $query->maxResults = $qnty;

    $videos = $youtube->getVideoFeed($query);

    $i = 0;
    
    foreach($videos as $entry) {
      $response[$i++] = array('url'         => htmlentities($this->extractURL($entry), ENT_QUOTES, 'UTF-8'),
                              'preview'     => htmlentities($entry->mediaGroup->thumbnail[0]->url, ENT_QUOTES, 'UTF-8'),
                              'title'       => htmlentities($entry->mediaGroup->title, ENT_QUOTES, 'UTF-8'),
                              'description' => htmlentities($entry->mediaGroup->description, ENT_QUOTES, 'UTF-8'),
                              'license'     => NULL,
                              'author'      => htmlentities($entry->author[0]->name, ENT_QUOTES, 'UTF-8'));

    }

    return $response;

  }

  public function extractURL($entry) {
    foreach($entry->mediaGroup->content as $content) {
      if ($content->type === 'application/x-shockwave-flash')
        $url = $content->url;

    }

    return $url;

  }

}

?>