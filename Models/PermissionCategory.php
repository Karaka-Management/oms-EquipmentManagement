<?php
/**
 * Jingga
 *
 * PHP Version 8.2
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
 * Permission category enum.
 *
 * @package Modules\EquipmentManagement\Models
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
abstract class PermissionCategory extends Enum
{
    public const EQUIPMENT = 1;

    public const EQUIPMENT_TYPE = 3;

    public const EQUIPMENT_INSPECTION_TYPE = 4;

    public const EQUIPMENT_INSPECTION = 5;

    public const EQUIPMENT_ATTRIBUTE_TYPE = 6;

    public const EQUIPMENT_NOTE = 7;
}
