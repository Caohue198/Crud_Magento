<?php
namespace AHT\Crud\Block;


class Edit extends \Magento\Framework\View\Element\Template
{
    protected $_pageFactory;
    protected $_coreRegistry;
    protected $_postLoader;


    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Magento\Framework\Registry $coreRegistry,
        \AHT\Crud\Model\PostFactory $postLoader,
        array $data = []

    )
    {
        $this->_pageFactory = $pageFactory;
        $this->_coreRegistry = $coreRegistry;
        $this->_postLoader = $postLoader;
        return parent::__construct($context,$data);
    }

    public function execute()
    {
        return $this->_pageFactory->create();
    }

    public function getEditRecord()
    {
        $post = $this->_postLoader->create();
        $id = $this->_coreRegistry->registry('post_id');
        $result = $post->load($id);
        return $result;
        
    }
}