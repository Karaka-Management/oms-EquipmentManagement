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

use Modules\EquipmentManagement\Controller\BackendController;
use Modules\EquipmentManagement\Models\PermissionCategory;
use phpOMS\Account\PermissionType;
use phpOMS\Router\RouteVerb;

return [
    '^.*/equipment/attribute/type/list(\?.*$|$)' => [
        [
            'dest'       => '\Modules\EquipmentManagement\Controller\BackendController:viewEquipmentManagementAttributeTypeList',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::EQUIPMENT,
            ],
        ],
    ],
    '^.*/equipment/attribute/type(\?.*$|$)' => [
        [
            'dest'       => '\Modules\EquipmentManagement\Controller\BackendController:viewEquipmentManagementAttributeType',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::EQUIPMENT,
            ],
        ],
    ],

    '^.*/equipment/list(\?.*$|$)' => [
        [
            'dest'       => '\Modules\EquipmentManagement\Controller\BackendController:viewEquipmentManagementEquipmentList',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::EQUIPMENT,
            ],
        ],
    ],
    '^.*/equipment/create(\?.*$|$)' => [
        [
            'dest'       => '\Modules\EquipmentManagement\Controller\BackendController:viewEquipmentManagementEquipmentCreate',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::CREATE,
                'state'  => PermissionCategory::EQUIPMENT,
            ],
        ],
    ],
    '^.*/equipment/view(\?.*$|$)' => [
        [
            'dest'       => '\Modules\EquipmentManagement\Controller\BackendController:viewEquipmentManagementEquipmentView',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::EQUIPMENT,
            ],
        ],
    ],

    '^.*/equipment/inspection/list(\?.*$|$)' => [
        [
            'dest'       => '\Modules\EquipmentManagement\Controller\BackendController:viewEquipmentManagementEquipmentList',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::EQUIPMENT,
            ],
        ],
    ],
    '^.*/equipment/inspection/create(\?.*$|$)' => [
        [
            'dest'       => '\Modules\EquipmentManagement\Controller\BackendController:viewEquipmentManagementEquipmentCreate',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::CREATE,
                'state'  => PermissionCategory::EQUIPMENT,
            ],
        ],
    ],
    '^.*/equipment/inspection/view(\?.*$|$)' => [
        [
            'dest'       => '\Modules\EquipmentManagement\Controller\BackendController:viewEquipmentManagementEquipmentView',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::EQUIPMENT,
            ],
        ],
    ],
];
