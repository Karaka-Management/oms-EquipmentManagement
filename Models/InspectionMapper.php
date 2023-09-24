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

use phpOMS\DataStorage\Database\Mapper\DataMapperFactory;

/**
 *  mapper class.
 *
 * @package Modules\EquipmentManagement\Models
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 *
 * @template T of Inspection
 * @extends DataMapperFactory<T>
 */
final class InspectionMapper extends DataMapperFactory
{
    /**
     * Columns.
     *
     * @var array<string, array{name:string, type:string, internal:string, autocomplete?:bool, readonly?:bool, writeonly?:bool, annotations?:array}>
     * @since 1.0.0
     */
    public const COLUMNS = [
        'equipmgmt_equipment_inspection_id'          => ['name' => 'equipmgmt_equipment_inspection_id',    'type' => 'int',    'internal' => 'id'],
        'equipmgmt_equipment_inspection_equipment'     => ['name' => 'equipmgmt_equipment_inspection_equipment', 'type' => 'int', 'internal' => 'reference'],
        'equipmgmt_equipment_inspection_description' => ['name' => 'equipmgmt_equipment_inspection_description', 'type' => 'string', 'internal' => 'description'],
        'equipmgmt_equipment_inspection_status'      => ['name' => 'equipmgmt_equipment_inspection_status',  'type' => 'int',    'internal' => 'status'],
        'equipmgmt_equipment_inspection_interval'    => ['name' => 'equipmgmt_equipment_inspection_interval',  'type' => 'int', 'internal' => 'interval'],
        'equipmgmt_equipment_inspection_next'        => ['name' => 'equipmgmt_equipment_inspection_next',  'type' => 'DateTime', 'internal' => 'next'],
        'equipmgmt_equipment_inspection_date'        => ['name' => 'equipmgmt_equipment_inspection_date',  'type' => 'DateTime', 'internal' => 'date'],
        'equipmgmt_equipment_inspection_type'        => ['name' => 'equipmgmt_equipment_inspection_type',  'type' => 'int', 'internal' => 'type'],
    ];

    /**
     * Has one relation.
     *
     * @var array<string, array{mapper:class-string, external:string, by?:string, column?:string, conditional?:bool}>
     * @since 1.0.0
     */
    public const OWNS_ONE = [
        'type' => [
            'mapper'   => InspectionTypeMapper::class,
            'external' => 'equipmgmt_equipment_type',
        ],
    ];

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    public const TABLE = 'equipmgmt_equipment_inspection';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    public const PRIMARYFIELD = 'equipmgmt_equipment_inspection_id';

    /**
     * Model to use by the mapper.
     *
     * @var class-string<T>
     * @since 1.0.0
     */
    public const MODEL = Inspection::class;
}
