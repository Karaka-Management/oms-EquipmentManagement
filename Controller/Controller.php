<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\EquipmentManagement
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\EquipmentManagement\Controller;

use phpOMS\Module\ModuleAbstract;

/**
 * EquipmentManagement class.
 *
 * @package Modules\EquipmentManagement
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
class Controller extends ModuleAbstract
{
    /**
     * Module path.
     *
     * @var string
     * @since 1.0.0
     */
    public const PATH = __DIR__ . '/../';

    /**
     * Module version.
     *
     * @var string
     * @since 1.0.0
     */
    public const VERSION = '1.0.0';

    /**
     * Module name.
     *
     * @var string
     * @since 1.0.0
     */
    public const NAME = 'EquipmentManagement';

    /**
     * Module id.
     *
     * @var int
     * @since 1.0.0
     */
    public const ID = 1008400000;

    /**
     * Providing.
     *
     * @var string[]
     * @since 1.0.0
     */
    public static array $providing = [];

    /**
     * Dependencies.
     *
     * @var string[]
     * @since 1.0.0
     */
    public static array $dependencies = [];
}
