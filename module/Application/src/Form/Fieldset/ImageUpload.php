<?php

declare(strict_types=1);

namespace Application\Form\Fieldset;

use Laminas\Form\Element\File;
use Laminas\Form\Element\Hidden;
use Laminas\Form\Fieldset;
use Laminas\InputFilter\InputFilterProviderInterface;
use Laminas\Filter\ToInt;
use Laminas\Filter\ToNull;
use Laminas\Validator\File\ImageSize;
use Laminas\Validator\File\IsImage;
use Laminas\Validator\File\FilesSize;

final class ImageUpload extends Fieldset implements InputFilterProviderInterface
{
    public function __construct($name = 'file-data', $options = [])
    {
        parent::__construct($name, $options);
    }

    public function init()
    {
        $options = $this->getOptions();

        $this->add([
            'name' => 'productId',
            'type' => Hidden::class,
        ]);
        $this->add([
            'name' => 'categoryId',
            'type' => Hidden::class,
        ]);
        // createdDate autogen timestamp
        $this->add([
            'name' => 'uploadedTime', // move this to a db listener
            'type' => Hidden::class,
        ]);
        $this->add([
            'name' => 'images',
            'type' => File::class,
            'attributes' => [
                'id'   => 'image-file',
                'multiple' => true,
            ],
        ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'userId' => [
                'required' => false,
                'filters' => [
                    ['name' => ToInt::class],
                ],
            ],
            'productId' => [
                'required' => false,
                'filters' => [
                    ['name' => ToInt::class],
                    ['name' => ToNull::class],
                ],
            ],
            'categoryId' => [
                'required' => false,
                'filters' => [
                    ['name' => ToInt::class],
                    ['name' => ToNull::class],
                ],
            ],
        ];
    }
}
