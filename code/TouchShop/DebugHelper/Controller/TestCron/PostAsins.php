<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/22/18
 * Time: 6:49 PM
 */

namespace TouchShop\DebugHelper\Controller\TestCron;


use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

class PostAsins extends Action
{
    const URL = '/debug/testCron/postAsins';

    private $postAsins;

    public function __construct(
        \TouchShop\ReviewTool\Cron\PostAsins $postAsins,
        Context $context
    )
    {
        $this->postAsins = $postAsins;
        parent::__construct($context);
    }


    public function execute()
    {
        $this->postAsins->execute();
    }
}