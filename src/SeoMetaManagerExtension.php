<?php

namespace Bolt\Extension\TreoLabs\SeoMetaManager;

use Bolt\Extension\SimpleExtension;
use Silex\Application;

/**
 * SeoMetaManagerExtension extension class.
 */
class SeoMetaManagerExtension extends SimpleExtension
{

    /**
     * Pretty extension name
     *
     * @return string
     */
    public function getDisplayName()
    {
        return 'SEO Meta Manager';
    }

    /**
     * {@inheritdoc}
     */
    protected function registerServices(Application $app)
    {
        $app['twig'] = $app->extend(
            'twig',
            function (\Twig_Environment $twig) use ($app) {
                $config = $this->getConfig();

                $meta = new Meta($app, $config);
                $twig->addGlobal('meta', $meta);

                return $twig;
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function registerTwigPaths()
    {
        return [
            'templates' => ['position' => 'prepend', 'namespace' => 'bolt'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultConfig()
    {
        return [
            'templates' => [
                'metatemplate' => '@bolt/_metatemplate.twig',
            ]
        ];
    }
}
