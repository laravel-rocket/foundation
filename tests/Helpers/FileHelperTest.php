<?php
namespace LaravelRocket\Foundation\Tests\Helpers;

use LaravelRocket\Foundation\Tests\TestCase;

class FileHelperTest extends TestCase
{
    /**
     * @return \LaravelRocket\Foundation\Helpers\FileHelperInterface
     */
    protected function getInstance()
    {
        $helper = app()->make(\LaravelRocket\Foundation\Helpers\FileHelperInterface::class);

        return $helper;
    }

    public function testGetInstance()
    {
        $helper = $this->getInstance();
        $this->assertNotNull($helper);
    }

    public function testGetFileIconHTML()
    {
        $helper = $this->getInstance();

        $html = $helper->getFileIconHTML('image/jpeg');
        $this->assertEquals('<i class="far fa-file-image"></i>', $html);

        $html = $helper->getFileIconHTML('image/unknown');
        $this->assertEquals('<i class="far fa-file-image"></i>', $html);

        $html = $helper->getFileIconHTML('application/pdf');
        $this->assertEquals('<i class="far fa-file-pdf"></i>', $html);

        $html = $helper->getFileIconHTML('unknown/unknown');
        $this->assertEquals('<i class="far fa-file"></i>', $html);
    }
}
