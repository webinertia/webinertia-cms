<?php

declare(strict_types=1);

namespace Application\Controller;

use Laminas\View\Model\JsonModel;
use Webinertia\Mvc\Controller\AbstractApiController;
use Webinertia\Mvc\Controller\AdminControllerInterface;
use Webinertia\Uploader\UploaderEvent;

final class UploadApiController extends AbstractApiController implements AdminControllerInterface
{
    public function create(mixed $data): JsonModel
    {
        try {
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
        } catch (\Throwable $th) {
            //throw $th;
        }
        return new JsonModel([]);
    }

    public function delete(mixed $id)
    {

    }
}
