<?php
/**
 * Jingga
 *
 * PHP Version 8.1
 *
 * @package   tests
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\EquipmentManagement\tests\Models;

use Modules\EquipmentManagement\Models\NullEquipment;

/**
 * @internal
 */
final class NullEquipmentTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @covers Modules\EquipmentManagement\Models\NullEquipment
     * @group framework
     */
    public function testNull() : void
    {
        self::assertInstanceOf('\Modules\EquipmentManagement\Models\Equipment', new NullEquipment());
    }

    /**
     * @covers Modules\EquipmentManagement\Models\NullEquipment
     * @group framework
     */
    public function testId() : void
    {
        $null = new NullEquipment(2);
        self::assertEquals(2, $null->id);
    }

    /**
     * @covers Modules\EquipmentManagement\Models\NullEquipment
     * @group module
     */
    public function testJsonSerialize() : void
    {
        $null = new NullEquipment(2);
        self::assertEquals(['id' => 2], $null);
    }
}
