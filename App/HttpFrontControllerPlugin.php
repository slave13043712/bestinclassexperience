<?php
/**
 * @author Alexander Akimov
 * @license MIT
 */
namespace Fun\BestInClassExperience\App;

use Magento\Framework\App\FrontController;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\Raw;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\BlockFactory;

/**
 * Plugin for \Magento\Framework\App\FrontController class.
 *
 * Provides best in class experience 24/7
 */
class HttpFrontControllerPlugin
{
    /**
     * @var ResultFactory
     */
    private $resultFactory;

    /**
     * @var BlockFactory
     */
    private $blockFactory;

    /**
     * HttpFrontendControllerPlugin constructor.
     */
    public function __construct(
        ResultFactory $resultFactory,
        BlockFactory $blockFactory
    ) {
        $this->resultFactory = $resultFactory;
        $this->blockFactory = $blockFactory;
    }

    /**
     * Intercept all incoming requests and provide best in class experience instead.
     *
     * @param FrontController $subject
     * @param \Closure $proceed
     * @param RequestInterface $request
     * @return ResultInterface
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function aroundDispatch(
        FrontController $subject,
        \Closure $proceed,
        RequestInterface $request
    ) {
        // @todo handle different request methods (PUT, POST , GET etc)
        /** @var Template $block */
        $block = $this->blockFactory->createBlock(Template::class);
        $block->setTemplate('Fun_BestInClassExperience::default.phtml');
        /** @var Raw $result */
        $result = $this->resultFactory->create(ResultFactory::TYPE_RAW);
        $result->setStatusHeader(200);
        $result->setHeader('Cache-Control', 'public');
        $result->setHeader('Content-Type', 'text/html; charset=utf-8');
        $result->setContents($block->toHtml());

        return $result;
    }
}

