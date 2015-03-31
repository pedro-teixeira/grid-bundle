<?php

namespace PedroTeixeira\Bundle\GridBundle\Twig;

use Twig_Extension;
use Twig_Environment;
use Twig_TemplateInterface;

use PedroTeixeira\Bundle\GridBundle\Grid\GridView;

/**
 * Grid Twig Extension
 */
class GridExtension extends Twig_Extension
{
    /**
     * @var \Symfony\Component\DependencyInjection\Container
     */
    protected $container;

    /**
     * @var Twig_Environment
     */
    protected $environment;

    /**
     * @var Twig_TemplateInterface[]
     */
    protected $templates;

    /**
     * @var string
     */
    const DEFAULT_TEMPLATE = 'PedroTeixeiraGridBundle::block.html.twig';

    /**
     * Construct
     *
     * @param \Symfony\Component\DependencyInjection\Container $container Container
     */
    public function __construct(\Symfony\Component\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }

    /**
     * Init runtime
     *
     * @param Twig_Environment $environment
     */
    public function initRuntime(Twig_Environment $environment)
    {
        $this->environment = $environment;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return 'pedroteixeira_grid_extension';
    }

    /**
     * Template Loader
     *
     * @return Twig_TemplateInterface[]
     *
     * @throws \Exception
     */
    protected function getTemplates()
    {
        if (empty($this->templates)) {
            $this->templates[] = $this->environment->loadTemplate($this::DEFAULT_TEMPLATE);
        }

        return $this->templates;
    }

    /**
     * Render block
     *
     * @param string $name
     * @param array  $parameters
     *
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    protected function renderBlock($name, $parameters)
    {
        /** @var Twig_TemplateInterface $template */
        foreach ($this->getTemplates() as $template) {
            if ($template->hasBlock($name)) {

                $context = array_merge(
                    $template->getEnvironment()->getGlobals(),
                    $parameters
                );

                return $template->renderBlock($name, $context);
            }
        }

        throw new \InvalidArgumentException(sprintf('Block "%s" doesn\'t exist in grid template.', $name));
    }

    /**
     * Check if has block
     *
     * @param string $name
     *
     * @return bool
     */
    protected function hasBlock($name)
    {
        /** @var Twig_TemplateInterface $template */
        foreach ($this->getTemplates() as $template) {
            if ($template->hasBlock($name)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get functions
     *
     * @return array
     */
    public function getFunctions()
    {
        return array(
            'pedroteixeira_grid' => new \Twig_Function_Method(
                $this,
                'renderGrid',
                array(
                    'is_safe' => array('html')
                )
            ),
            'pedroteixeira_grid_html' => new \Twig_Function_Method(
                $this,
                'renderHtmlGrid',
                array(
                    'is_safe' => array('html')
                )
            ),
            'pedroteixeira_grid_js' => new \Twig_Function_Method(
                $this,
                'renderJsGrid',
                array(
                    'is_safe' => array('html')
                )
            )
        );
    }

    /**
     * Render grid view
     *
     * @param GridView $gridView
     *
     * @return mixed
     */
    public function renderGrid(GridView $gridView)
    {
        if (!$gridView->getGrid()->isAjax()) {
            return $this->renderBlock(
                'grid',
                array(
                    'view' => $gridView
                )
            );
        }
    }

    /**
     * Render (only html) grid view
     *
     * @param GridView $gridView
     *
     * @return mixed
     */
    public function renderHtmlGrid(GridView $gridView)
    {
        if (!$gridView->getGrid()->isAjax()) {
            return $this->renderBlock(
                'grid_html',
                array(
                    'view' => $gridView
                )
            );
        }
    }

    /**
     * Render (only js) grid view
     *
     * @param GridView $gridView
     *
     * @return mixed
     */
    public function renderJsGrid(GridView $gridView)
    {
        if (!$gridView->getGrid()->isAjax()) {
            return $this->renderBlock(
                'grid_js',
                array(
                    'view' => $gridView
                )
            );
        }
    }
}
