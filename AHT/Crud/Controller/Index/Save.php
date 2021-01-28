<?php

namespace AHT\Crud\Controller\Index;

use \Magento\Framework\App\Action\Action;
use \Magento\Framework\App\Action\Context;
use AHT\Crud\Model\Post;

class Save extends Action
{
    /**
     * @var Post
     */
    private $post;
    /**
     * @var \AHT\Crud\Model\ResourceModel\Post
     */
    private $postResourceModel;
    /**
     * @var Context
     */
    private $context;

    /**
     * Save constructor.
     * @param Context $context
     * @param Post $post
     * @param \AHT\Crud\Model\ResourceModel\Post $postResourceModel
     */

    private $_cacheTypeList;
	private $_cacheFrontendPool;

    public function __construct(
        Context $context,
        Post $post,
        \AHT\Crud\Model\ResourceModel\Post $postResourceModel,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
		\Magento\Framework\App\Cache\Frontend\Pool $cacheFrontendPool
    )
    {
        parent::__construct($context);
        $this->post = $post;
        $this->postResourceModel = $postResourceModel;
        $this->context = $context;
        $this->_cacheTypeList     = $cacheTypeList;
		$this->_cacheFrontendPool = $cacheFrontendPool;
    }

    public function execute()
        {

            $params = $this->_request->getParams();
            //var_dump($params);
            $model = $this->post->setData($params);
            if (isset($_POST['post_id']))
            {
                $this->post->setId($_POST['post_id']) ;
            }

            $this->postResourceModel->save($model);


            $types = ['config', 'layout', 'block_html', 'collections', 'reflection', 'db_ddl', 'compiled_config', 'eav', 'config_integration', 'config_integration_api', 'full_page', 'translate', 'config_webservice', 'vertex'];
            foreach ($types as $type) {
                $this->_cacheTypeList->cleanType($type);
            }
            foreach ($this->_cacheFrontendPool as $cacheFrontend) {
                $cacheFrontend->getBackend()->clean();
            }

            $resultRedirect = $this->resultRedirectFactory->create();

            return $resultRedirect->setUrl('/mage/crud/index/index');
        }
}