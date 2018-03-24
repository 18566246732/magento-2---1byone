<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/23/18
 * Time: 1:35 AM
 */

namespace TouchShop\DebugHelper\Controller\TestCron;


use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use TouchShop\ReviewTool\Cron\SyncReviews;

class GetReviews extends Action
{
    const URL = 'debug/testCron/getReviews';
    private $syncReviews;

    public function __construct(
        SyncReviews $syncReviews,
        Context $context
    )
    {
        $this->syncReviews = $syncReviews;
        parent::__construct($context);
    }

    public function execute()
    {
        $this->syncReviews->execute();
    }
}