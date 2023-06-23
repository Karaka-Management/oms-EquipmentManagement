<?php
/**
 * Jingga
 *
 * PHP Version 8.1
 *
 * @package   Modules\EquipmentManagement\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\EquipmentManagement\Models;

use phpOMS\Stdlib\Base\Enum;

/**
 * Equipment status enum.
 *
 * @package Modules\EquipmentManagement\Models
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
abstract class EquipmentStatus extends Enum
{
    public const ACTIVE = 1;

    public const INACTIVE = 2;

    public const DAMAGED = 3;

    public const OUT_OF_ORDER = 4;

    public const MAINTENANCE = 5;
}
