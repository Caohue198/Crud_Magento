<?php


namespace AHT\Crud\Controller\Index;

use Magento\Framework\App\Action\Action;

class Delete extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;
    protected $_request;
    protected $_coreRegistry;

    /**
     * @var \AHT\Crud\Model\PostFactory
     */
    private $_postLoader;
    /**
     * @var \Magento\Framework\App\Cache\TypeListInterface
     */
    private $_cacheTypeList;
    /**
     * @var \Magento\Framework\App\Cache\Frontend\Pool
     */
    private $_cacheFrontendPool;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\Registry $coreRegistry,

        \AHT\Crud\Model\PostFactory $postLoader,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Magento\Framework\App\Cache\Frontend\Pool $cacheFrontendPool

    )
    {
        $this->_pageFactory = $pageFactory;
        $this->_request = $request;
        $this->_coreRegistry = $coreRegistry;
        $this->_postLoader = $postLoader;

        $this->_cacheTypeList = $cacheTypeList;
        $this->_cacheFrontendPool = $cacheFrontendPool;
        return parent::__construct($context);
    }

    public function execute()
    {
        $id = $this->_request->getParam('id');
        $post = $this->_postLoader->create();
        $result = $post->setId($id);
        $result->delete();

        $resultRedirect = $this->resultRedirectFactory->create();

        $types = ['config', 'layout', 'block_html', 'collections', 'reflection', 'db_ddl', 'compiled_config', 'eav', 'config_integration', 'config_integration_api', 'full_page', 'translate', 'config_webservice', 'vertex'];
        foreach ($types as $type) {
            $this->_cacheTypeList->cleanType($type);
        }
        foreach ($this->_cacheFrontendPool as $cacheFrontend) {
            $cacheFrontend->getBackend()->clean();
        }
        return $resultRedirect->setUrl('/mage/crud/index/index');
    }
}