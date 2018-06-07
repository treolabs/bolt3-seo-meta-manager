<?php

namespace Bolt\Extension\Zinit\SeoMetaManager;

use Bolt\Helpers\Html;
use Bolt\Legacy\Content;
use Silex\Application;
use Bolt\Storage\Field\Collection\RepeatingFieldCollection;

class Meta
{
    /** @var Application */
    protected $app;
    /** @var array */
    protected $config;
    /** @var string */
    protected $uri;

    /**
     * Constructor.
     *
     * @param Application $app
     * @param array       $config
     */
    public function __construct(Application $app, $config)
    {
        $this->app = $app;
        $this->config = $config;
        $this->uri = '';
    }

    /**
     * @param string $uri
     * @return boolean
     */
    public function isSpecified($uri = null)
    {
        $this->uri = (!is_null($uri)) ? $uri : $this->app['request']->server->get('REQUEST_URI');
        
        return (isset($this->config['meta'][$this->uri]));
    }

    /**
     * @param string $uri
     *
     * @return string
     */
    public function title($uri = null)
    {
        if (!$this->isSpecified($uri)) {
            return null;
        }
        
        return (isset($this->config['meta'][$this->uri]['title'])) ? $this->config['meta'][$this->uri]['title'] . ' | ' . $this->app['config']->get('general/sitename') : '';
    }

    /**
     * @param string $uri
     *
     * @return string
     */
    public function description($uri = null)
    {
        if (!$this->isSpecified($uri)) {
            return null;
        }
        
        $description = (isset($this->config['meta'][$this->uri]['description'])) ? $this->config['meta'][$this->uri]['description'] : '';
        
        return $this->cleanUp($description);
    }

    /**
     * @param string $uri
     *
     * @return string
     */
    public function keywords($uri = null)
    {
        if (!$this->isSpecified($uri)) {
            return null;
        }
        
        $keywords = (isset($this->config['meta'][$this->uri]['keywords'])) ? $this->config['meta'][$this->uri]['keywords'] : '';
        
        return $this->cleanUp($keywords);
    }

    /**
     * @param string $uri
     *
     * @return \Twig_Markup
     */
    public function metatags($uri = null)
    {
        if (!$this->isSpecified($uri)) {
            return null;
        }

        $data = [
            'title'       => $this->title($uri),
            'description' => $this->description($uri),
            'keywords'    => $this->keywords($uri)
        ];

        $html = $this->app['twig']->render($this->config['templates']['metatemplate'], $data);

        return new \Twig_Markup($html, 'UTF-8');
    }

    private function cleanUp($string)
    {
        $string = strip_tags($string);
        $string = str_replace(["\r", "\n"], '', $string);
        $string = preg_replace('/\s+/u', ' ', $string);

        return $string;
    }

}
