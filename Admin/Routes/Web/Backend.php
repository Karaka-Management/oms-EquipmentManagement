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

use Modules\EquipmentManagement\Controller\BackendController;
use Modules\EquipmentManagement\Models\PermissionCategory;
use phpOMS\Account\PermissionType;
use phpOMS\Router\RouteVerb;

return [
    '^/equipment/attribute/type/list(\?.*$|$)' => [
        [
            'dest'       => '\Modules\EquipmentManagement\Controller\BackendController:viewEquipmentManagementAttributeTypeList',
            'verb'       => RouteVerb::GET,
            'active'     => true,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::ATTRIBUTE,
            ],
        ],
    ],
    '^/equipment/attribute/type/view(\?.*$|$)' => [
        [
            'dest'       => '\Modules\EquipmentManagement\Controller\BackendController:viewEquipmentManagementAttributeType',
            'verb'       => RouteVerb::GET,
            'active'     => true,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::ATTRIBUTE,
            ],
        ],
    ],
    '^/equipment/attribute/type/create(\?.*$|$)' => [
        [
            'dest'       => '\Modules\EquipmentManagement\Controller\BackendController:viewEquipmentManagementAttributeTypeCreate',
            'verb'       => RouteVerb::GET,
            'active'     => true,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::CREATE,
                'state'  => PermissionCategory::ATTRIBUTE,
            ],
        ],
    ],
    '^/equipment/attribute/value/view(\?.*$|$)' => [
        [
            'dest'       => '\Modules\EquipmentManagement\Controller\BackendController:viewEquipmentManagementAttributeValue',
            'verb'       => RouteVerb::GET,
            'active'     => true,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::ATTRIBUTE,
            ],
        ],
    ],
    '^/equipment/attribute/value/create(\?.*$|$)' => [
        [
            'dest'       => '\Modules\EquipmentManagement\Controller\BackendController:viewEquipmentManagementAttributeValueCreate',
            'verb'       => RouteVerb::GET,
            'active'     => true,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::CREATE,
                'state'  => PermissionCategory::ATTRIBUTE,
            ],
        ],
    ],

    '^/equipment/list(\?.*$|$)' => [
        [
            'dest'       => '\Modules\EquipmentManagement\Controller\BackendController:viewEquipmentManagementEquipmentList',
            'verb'       => RouteVerb::GET,
            'active'     => true,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::EQUIPMENT,
            ],
        ],
    ],
    '^/equipment/create(\?.*$|$)' => [
        [
            'dest'       => '\Modules\EquipmentManagement\Controller\BackendController:viewEquipmentManagementEquipmentCreate',
            'verb'       => RouteVerb::GET,
            'active'     => true,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::CREATE,
                'state'  => PermissionCategory::EQUIPMENT,
            ],
        ],
    ],
    '^/equipment/view(\?.*$|$)' => [
        [
            'dest'       => '\Modules\EquipmentManagement\Controller\BackendController:viewEquipmentManagementEquipmentView',
            'verb'       => RouteVerb::GET,
            'active'     => true,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::EQUIPMENT,
            ],
        ],
    ],

    '^/equipment/inspection/list(\?.*$|$)' => [
        [
            'dest'       => '\Modules\EquipmentManagement\Controller\BackendController:viewEquipmentManagementInspectionList',
            'verb'       => RouteVerb::GET,
            'active'     => true,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::EQUIPMENT,
            ],
        ],
    ],
    '^/equipment/inspection/type/list(\?.*$|$)' => [
        [
            'dest'       => '\Modules\EquipmentManagement\Controller\BackendController:viewEquipmentManagementInspectionTypeList',
            'verb'       => RouteVerb::GET,
            'active'     => true,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::EQUIPMENT,
            ],
        ],
    ],
    '^/equipment/inspection/create(\?.*$|$)' => [
        [
            'dest'       => '\Modules\EquipmentManagement\Controller\BackendController:viewEquipmentManagementInspectionCreate',
            'verb'       => RouteVerb::GET,
            'active'     => true,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::CREATE,
                'state'  => PermissionCategory::EQUIPMENT,
            ],
        ],
    ],
    '^/equipment/inspection/view(\?.*$|$)' => [
        [
            'dest'       => '\Modules\EquipmentManagement\Controller\BackendController:viewEquipmentManagementInspectionView',
            'verb'       => RouteVerb::GET,
            'active'     => true,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::EQUIPMENT,
            ],
        ],
    ],
];
