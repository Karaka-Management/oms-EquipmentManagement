<?php
/**
 * Jingga
 *
 * PHP Version 8.1
 *
 * @package   Modules
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

use Modules\EquipmentManagement\Controller\Controller;
use Modules\EquipmentManagement\Models\PermissionCategory;
use phpOMS\Account\PermissionType;
use phpOMS\Router\RouteVerb;

return [
    '^.*/equipment/equipment/find.*$' => [
        [
            'dest'       => '\Modules\EquipmentManagement\Controller\ApiEquipmentController:apiEquipmentFind',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => Controller::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::EQUIPMENT,
            ],
        ],
    ],

    '^.*/equipment/equipment/attribute.*$' => [
        [
            'dest'       => '\Modules\EquipmentManagement\Controller\ApiEquipmentAttributeController:apiEquipmentAttributeCreate',
            'verb'       => RouteVerb::PUT,
            'permission' => [
                'module' => Controller::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::EQUIPMENT,
            ],
        ],
        [
            'dest'       => '\Modules\EquipmentManagement\Controller\ApiEquipmentAttributeController:apiEquipmentAttributeUpdate',
            'verb'       => RouteVerb::SET,
            'permission' => [
                'module' => Controller::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::EQUIPMENT,
            ],
        ],
    ],

    '^.*/equipment/equipment/note.*$' => [
        [
            'dest'       => '\Modules\EquipmentManagement\Controller\ApiEquipmentAttributeController:apiNoteCreate',
            'verb'       => RouteVerb::PUT,
            'permission' => [
                'module' => Controller::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::EQUIPMENT,
            ],
        ],
        [
            'dest'       => '\Modules\EquipmentManagement\Controller\ApiEquipmentAttributeController:apiNoteEdit',
            'verb'       => RouteVerb::SET,
            'permission' => [
                'module' => Controller::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::EQUIPMENT,
            ],
        ],
    ],
];
