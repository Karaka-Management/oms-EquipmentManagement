<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.2
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

use Modules\EquipmentManagement\Controller\Controller;
use Modules\EquipmentManagement\Models\PermissionCategory;
use phpOMS\Account\PermissionType;
use phpOMS\Router\RouteVerb;

return [
    '^.*/equipment/find(\?.*$|$)' => [
        [
            'dest'       => '\Modules\EquipmentManagement\Controller\ApiController:apiEquipmentFind',
            'verb'       => RouteVerb::GET,
            'csrf'       => true,
            'active'     => true,
            'permission' => [
                'module' => Controller::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::EQUIPMENT,
            ],
        ],
    ],

    '^.*/equipment/attribute(\?.*$|$)' => [
        [
            'dest'       => '\Modules\EquipmentManagement\Controller\ApiEquipmentAttributeController:apiEquipmentAttributeCreate',
            'verb'       => RouteVerb::PUT,
            'csrf'       => true,
            'active'     => true,
            'permission' => [
                'module' => Controller::NAME,
                'type'   => PermissionType::CREATE,
                'state'  => PermissionCategory::EQUIPMENT,
            ],
        ],
        [
            'dest'       => '\Modules\EquipmentManagement\Controller\ApiEquipmentAttributeController:apiEquipmentAttributeUpdate',
            'verb'       => RouteVerb::SET,
            'csrf'       => true,
            'active'     => true,
            'permission' => [
                'module' => Controller::NAME,
                'type'   => PermissionType::MODIFY,
                'state'  => PermissionCategory::EQUIPMENT,
            ],
        ],
    ],

    '^.*/equipment/note(\?.*$|$)' => [
        [
            'dest'       => '\Modules\EquipmentManagement\Controller\ApiController:apiNoteCreate',
            'verb'       => RouteVerb::PUT,
            'csrf'       => true,
            'active'     => true,
            'permission' => [
                'module' => Controller::NAME,
                'type'   => PermissionType::CREATE,
                'state'  => PermissionCategory::EQUIPMENT_NOTE,
            ],
        ],
        [
            'dest'       => '\Modules\EquipmentManagement\Controller\ApiController:apiNoteUpdate',
            'verb'       => RouteVerb::SET,
            'csrf'       => true,
            'active'     => true,
            'permission' => [
                'module' => Controller::NAME,
                'type'   => PermissionType::MODIFY,
                'state'  => PermissionCategory::EQUIPMENT_NOTE,
            ],
        ],
    ],
];
