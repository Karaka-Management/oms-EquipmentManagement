<?php
/**
 * Jingga
 *
 * PHP Version 8.1
 *
 * @package   Modules\EquipmentManagement\Models\Attribute
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\EquipmentManagement\Models\Attribute;

use Modules\Attribute\Models\Attribute;
use phpOMS\DataStorage\Database\Mapper\DataMapperFactory;

/**
 * Fleet mapper class.
 *
 * @package Modules\EquipmentManagement\Models\Attribute
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 *
 * @template T of Attribute
 * @extends DataMapperFactory<T>
 */
final class EquipmentAttributeMapper extends DataMapperFactory
{
    /**
     * Columns.
     *
     * @var array<string, array{name:string, type:string, internal:string, autocomplete?:bool, readonly?:bool, writeonly?:bool, annotations?:array}>
     * @since 1.0.0
     */
    public const COLUMNS = [
        'equipmgmt_equipment_attr_id'        => ['name' => 'equipmgmt_equipment_attr_id',    'type' => 'int', 'internal' => 'id'],
        'equipmgmt_equipment_attr_equipment' => ['name' => 'equipmgmt_equipment_attr_equipment',  'type' => 'int', 'internal' => 'ref'],
        'equipmgmt_equipment_attr_type'      => ['name' => 'equipmgmt_equipment_attr_type',  'type' => 'int', 'internal' => 'type'],
        'equipmgmt_equipment_attr_value'     => ['name' => 'equipmgmt_equipment_attr_value', 'type' => 'int', 'internal' => 'value'],
    ];

    /**
     * Has one relation.
     *
     * @var array<string, array{mapper:class-string, external:string, by?:string, column?:string, conditional?:bool}>
     * @since 1.0.0
     */
    public const OWNS_ONE = [
        'type' => [
            'mapper'   => EquipmentAttributeTypeMapper::class,
            'external' => 'equipmgmt_equipment_attr_type',
        ],
        'value' => [
            'mapper'   => EquipmentAttributeValueMapper::class,
            'external' => 'equipmgmt_equipment_attr_value',
        ],
    ];

    /**
     * Model to use by the mapper.
     *
     * @var class-string<T>
     * @since 1.0.0
     */
    public const MODEL = Attribute::class;

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    public const TABLE = 'equipmgmt_equipment_attr';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    public const PRIMARYFIELD = 'equipmgmt_equipment_attr_id';
}
