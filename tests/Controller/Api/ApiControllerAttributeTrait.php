<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   tests
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\EquipmentManagement\tests\Controller\Api;

use phpOMS\Localization\ISO3166TwoEnum;
use phpOMS\Localization\ISO639x1Enum;
use phpOMS\Message\Http\HttpRequest;
use phpOMS\Message\Http\HttpResponse;
use phpOMS\Message\Http\RequestStatusCode;

trait ApiControllerAttributeTrait
{
    /**
     * @covers \Modules\EquipmentManagement\Controller\ApiEquipmentAttributeController
     */
    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testApiEquipmentAttributeTypeCreate() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest();

        $request->header->account = 1;
        $request->setData('name', 'test_attribute');
        $request->setData('title', 'EN:1');
        $request->setData('language', ISO639x1Enum::_EN);

        $this->attrModule->apiEquipmentAttributeTypeCreate($request, $response);
        self::assertGreaterThan(0, $response->getDataArray('')['response']->id);
    }

    /**
     * @covers \Modules\EquipmentManagement\Controller\ApiEquipmentAttributeController
     */
    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testApiEquipmentAttributeTypeL11nCreate() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest();

        $request->header->account = 1;
        $request->setData('title', 'DE:2');
        $request->setData('type', '1');
        $request->setData('language', ISO639x1Enum::_DE);

        $this->attrModule->apiEquipmentAttributeTypeL11nCreate($request, $response);
        self::assertGreaterThan(0, $response->getDataArray('')['response']->id);
    }

    /**
     * @covers \Modules\EquipmentManagement\Controller\ApiEquipmentAttributeController
     */
    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testApiEquipmentAttributeValueIntCreate() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest();

        $request->header->account = 1;
        $request->setData('default', '1');
        $request->setData('type', '1');
        $request->setData('value', '1');
        $request->setData('language', ISO639x1Enum::_DE);
        $request->setData('country', ISO3166TwoEnum::_DEU);

        $this->attrModule->apiEquipmentAttributeValueCreate($request, $response);
        self::assertGreaterThan(0, $response->getDataArray('')['response']->id);
    }

    /**
     * @covers \Modules\EquipmentManagement\Controller\ApiEquipmentAttributeController
     */
    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testApiEquipmentAttributeValueStrCreate() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest();

        $request->header->account = 1;
        $request->setData('type', '1');
        $request->setData('value', '1');
        $request->setData('language', ISO639x1Enum::_DE);
        $request->setData('country', ISO3166TwoEnum::_DEU);

        $this->attrModule->apiEquipmentAttributeValueCreate($request, $response);
        self::assertGreaterThan(0, $response->getDataArray('')['response']->id);
    }

    /**
     * @covers \Modules\EquipmentManagement\Controller\ApiEquipmentAttributeController
     */
    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testApiEquipmentAttributeValueFloatCreate() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest();

        $request->header->account = 1;
        $request->setData('type', '1');
        $request->setData('value', '1.1');
        $request->setData('language', ISO639x1Enum::_DE);
        $request->setData('country', ISO3166TwoEnum::_DEU);

        $this->attrModule->apiEquipmentAttributeValueCreate($request, $response);
        self::assertGreaterThan(0, $response->getDataArray('')['response']->id);
    }

    /**
     * @covers \Modules\EquipmentManagement\Controller\ApiEquipmentAttributeController
     */
    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testApiEquipmentAttributeValueDatCreate() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest();

        $request->header->account = 1;
        $request->setData('type', '1');
        $request->setData('value', '2020-08-02');
        $request->setData('language', ISO639x1Enum::_DE);
        $request->setData('country', ISO3166TwoEnum::_DEU);

        $this->attrModule->apiEquipmentAttributeValueCreate($request, $response);
        self::assertGreaterThan(0, $response->getDataArray('')['response']->id);
    }

    /**
     * @covers \Modules\EquipmentManagement\Controller\ApiEquipmentAttributeController
     */
    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testApiEquipmentAttributeCreate() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest();

        $request->header->account = 1;
        $request->setData('ref', '1');
        $request->setData('value', '1');
        $request->setData('type', '1');

        $this->attrModule->apiEquipmentAttributeCreate($request, $response);
        self::assertGreaterThan(0, $response->getDataArray('')['response']->id);
    }

    /**
     * @covers \Modules\EquipmentManagement\Controller\ApiEquipmentAttributeController
     */
    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testApiEquipmentAttributeValueCreateInvalidData() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest();

        $request->header->account = 1;
        $request->setData('invalid', '1');

        $this->attrModule->apiEquipmentAttributeValueCreate($request, $response);
        self::assertEquals(RequestStatusCode::R_400, $response->header->status);
    }

    /**
     * @covers \Modules\EquipmentManagement\Controller\ApiEquipmentAttributeController
     */
    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testApiEquipmentAttributeTypeCreateInvalidData() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest();

        $request->header->account = 1;
        $request->setData('invalid', '1');

        $this->attrModule->apiEquipmentAttributeTypeCreate($request, $response);
        self::assertEquals(RequestStatusCode::R_400, $response->header->status);
    }

    /**
     * @covers \Modules\EquipmentManagement\Controller\ApiEquipmentAttributeController
     */
    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testApiEquipmentAttributeTypeL11nCreateInvalidData() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest();

        $request->header->account = 1;
        $request->setData('invalid', '1');

        $this->attrModule->apiEquipmentAttributeTypeL11nCreate($request, $response);
        self::assertEquals(RequestStatusCode::R_400, $response->header->status);
    }

    /**
     * @covers \Modules\EquipmentManagement\Controller\ApiEquipmentAttributeController
     */
    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testApiEquipmentAttributeCreateInvalidData() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest();

        $request->header->account = 1;
        $request->setData('invalid', '1');

        $this->attrModule->apiEquipmentAttributeCreate($request, $response);
        self::assertEquals(RequestStatusCode::R_400, $response->header->status);
    }
}
