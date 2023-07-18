<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Form\UploadForm;
use Laminas\View\Model\ViewModel;
use Webinertia\Db\Exception\RecordNotFound;
use Webinertia\Log\LogEvent;
use Webinertia\Mvc\Controller\AbstractAppController;
use Webinertia\Mvc\Controller\AdminControllerInterface;
use Webinertia\Mvc\FormManagerAwareInterface;
use Webinertia\Mvc\FormManagerAwareTrait;
use Webinertia\Uploader\UploaderEvent;

final class AdminUploadController extends AbstractAppController implements AdminControllerInterface, FormManagerAwareInterface
{
    use FormManagerAwareTrait;

    public function managerAction()
    {
        $view = new ViewModel();
        /** @var UploadForm $form */
        $form = $this->formManager->get(UploadForm::class);
        $form->setAttribute('', '/admin/upload');
        if ($this->request->isPost()) {
            $form->setData(array_merge($this->request->getPost()->toArray(), $this->request->getFiles()->toArray()));
            if ($form->isValid()) {
                $data = $form->getData();
                $response = $this->getEventManager()->triggerEvent(
                    new UploaderEvent(
                        UploaderEvent::EVENT_UPLOAD,
                        null,
                        [
                            'userId' => 1,
                            'privilege' => 'view',
                            'role' => 'member',
                            'target' => 'app',
                            'targetFileName' => 'appImage'
                        ]
                    )
                );
                $result = $response->last();
            }
        } else {
            $params = $this->params()->fromQuery();
            if (isset($params['id']) || isset($params['uuid']) || isset($params['fileName'])) {
                try {
                    $response = $this->getEventManager()->triggerEvent(
                        new UploaderEvent(
                            UploaderEvent::EVENT_DELETE,
                            null,
                            $params
                        )
                    );
                    $result = $response->last();
                } catch (RecordNotFound $e) {
                    /**
                     * This works as expected. sets response code to 452 Record Not Found for client
                     * Allows page to load as normal
                     */
                    $this->response->setStatusCode(452);
                }
            }
        }

        $view->setVariable('form', $form);
        return $view;
    }
}
