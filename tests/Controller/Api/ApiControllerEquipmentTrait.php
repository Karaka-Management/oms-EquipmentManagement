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

use Modules\EquipmentManagement\Models\EquipmentTypeMapper;
use phpOMS\Message\Http\HttpRequest;
use phpOMS\Message\Http\HttpResponse;
use phpOMS\Utils\RnG\Text;

trait ApiControllerEquipmentTrait
{
    /**
     * @covers \Modules\EquipmentManagement\Controller\ApiController
     */
    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testApiEquipmentCreate() : void
    {
        $equipmentType      = EquipmentTypeMapper::getAll()->executeGetArray();
        $equipmentTypeCount = \count($equipmentType);

        $response = new HttpResponse();
        $request  = new HttpRequest();

        $LOREM       = \array_slice(Text::LOREM_IPSUM, 0, 25);
        $LOREM_COUNT = \count($LOREM) - 1;

        $request->header->account = 1;
        $request->setData('name', \ucfirst(Text::LOREM_IPSUM[\mt_rand(0, $LOREM_COUNT - 1)]));
        $request->setData('type', \mt_rand(1, $equipmentTypeCount));
        $request->setData('status', 1);

        $this->module->apiEquipmentCreate($request, $response);
        self::assertGreaterThan(0, $response->getDataArray('')['response']->id);
    }
}
