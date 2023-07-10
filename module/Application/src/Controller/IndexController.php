<?php

declare(strict_types=1);

namespace Application\Controller;

use Laminas\View\Model\ViewModel;
use Webinertia\Log\LogEvent;
use Webinertia\Mvc\Controller\AbstractAppController;

class IndexController extends AbstractAppController
{
    public function indexAction()
    {
        $view = new ViewModel();
        $session = $this->getSessionContainer();
        $extra = ['firstName' => 'Joey', 'lastName' => 'Smith'];
        //$this->getEventManager()->trigger(LogEvent::EMERGENCY, 'Test Message', $extra);
        return $view;
    }
}
