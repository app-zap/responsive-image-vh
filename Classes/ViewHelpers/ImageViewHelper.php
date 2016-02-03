<?php
namespace AppZap\ResponsiveImageVh\ViewHelpers;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Fluid\Core\ViewHelper\Facets\CompilableInterface;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

class ImageViewHelper extends AbstractViewHelper implements CompilableInterface
{

    /**
     *
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('renderLink', 'bool', 'If true the image is wrapped with a link if one is configured in the file reference', false, true);
        $this->registerArgument('maxHeight', 'int', 'maximum height', false, PHP_INT_MAX);
        $this->registerArgument('maxWidth', 'int', 'maximum width', false, PHP_INT_MAX);
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
        $image = $renderChildrenClosure();
        if (!is_array($image)) {
            return '';
        }
        $url = self::getImageUrl($arguments, $image);
        $imageTag = '<img src="' . $url . '" alt/>';
        return $imageTag;
    }

    /**
     * @param array $arguments
     * @param array $image
     * @return string
     */
    protected static function getImageUrl($arguments, $image)
    {
        if ($arguments['maxWidth'] < $image['width'] || $arguments['maxHeight'] < $image['height']) {
            return self::getContentObject()->cObjGetSingle('IMG_RESOURCE', [
                'file' => $image['url'],
                'file.' => [
                    'maxHeight' => $arguments['maxHeight'],
                    'maxWidth' => $arguments['maxWidth']
                ]
            ]);
        }
        return $image['url'];
    }

    /**
     * @return ContentObjectRenderer
     */
    protected static function getContentObject()
    {
        if (isset($GLOBALS['TSFE']) && $GLOBALS['TSFE']->cObj instanceof ContentObjectRenderer) {
            return $GLOBALS['TSFE']->cObj;
        }
        return GeneralUtility::makeInstance(ContentObjectRenderer::class);
    }

}
