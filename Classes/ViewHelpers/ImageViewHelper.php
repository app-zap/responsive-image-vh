<?php
namespace AppZap\ResponsiveImageVh\Classes\ViewHelpers;

use TYPO3\CMS\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Fluid\Core\ViewHelper\Facets\CompilableInterface;

class ImageViewHelper extends AbstractViewHelper implements CompilableInterface
{

    /**
     *
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('renderLink', 'bool', 'If true the image is wrapped with a link if one is configured in the file reference', false, true);
        $this->registerArgument('maxHeight', 'string', 'maximum height');
        $this->registerArgument('maxWidth', 'string', 'maximum width');
    }

    /**
     * @return string
     */
    public function render()
    {
        return static::renderStatic(
            $this->arguments,
            $this->buildRenderChildrenClosure(),
            $this->renderingContext
        );
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return string
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        time();
    }

}
