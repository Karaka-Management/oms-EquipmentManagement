<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   tests
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.2
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\EquipmentManagement\tests\Models;

use Modules\EquipmentManagement\Models\NullEquipment;

/**
 * @internal
 */
#[\PHPUnit\Framework\Attributes\CoversClass(\Modules\EquipmentManagement\Models\NullEquipment::class)]
final class NullEquipmentTest extends \PHPUnit\Framework\TestCase
{
    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testNull() : void
    {
        self::assertInstanceOf('\Modules\EquipmentManagement\Models\Equipment', new NullEquipment());
    }

    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testId() : void
    {
        $null = new NullEquipment(2);
        self::assertEquals(2, $null->id);
    }

    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testJsonSerialize() : void
    {
        $null = new NullEquipment(2);
        self::assertEquals(['id' => 2], $null->jsonSerialize());
    }
}
