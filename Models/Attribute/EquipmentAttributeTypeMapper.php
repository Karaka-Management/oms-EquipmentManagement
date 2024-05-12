<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\EquipmentManagement\Models\Attribute
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\EquipmentManagement\Models\Attribute;

use Modules\Attribute\Models\AttributeType;
use phpOMS\DataStorage\Database\Mapper\DataMapperFactory;

/**
 * Equipment mapper class.
 *
 * @package Modules\EquipmentManagement\Models\Attribute
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 *
 * @template T of AttributeType
 * @extends DataMapperFactory<T>
 */
final class EquipmentAttributeTypeMapper extends DataMapperFactory
{
    /**
     * Columns.
     *
     * @var array<string, array{name:string, type:string, internal:string, autocomplete?:bool, readonly?:bool, writeonly?:bool, annotations?:array}>
     * @since 1.0.0
     */
    public const COLUMNS = [
        'equipmgmt_attr_type_id'         => ['name' => 'equipmgmt_attr_type_id',       'type' => 'int',    'internal' => 'id'],
        'equipmgmt_attr_type_name'       => ['name' => 'equipmgmt_attr_type_name',     'type' => 'string', 'internal' => 'name', 'autocomplete' => true],
        'equipmgmt_attr_type_datatype'   => ['name' => 'equipmgmt_attr_type_datatype',   'type' => 'int',    'internal' => 'datatype'],
        'equipmgmt_attr_type_fields'     => ['name' => 'equipmgmt_attr_type_fields',   'type' => 'int',    'internal' => 'fields'],
        'equipmgmt_attr_type_custom'     => ['name' => 'equipmgmt_attr_type_custom',   'type' => 'bool',   'internal' => 'custom'],
        'equipmgmt_attr_type_repeatable' => ['name' => 'equipmgmt_attr_type_repeatable',   'type' => 'bool',   'internal' => 'isRepeatable'],
        'equipmgmt_attr_type_internal'   => ['name' => 'equipmgmt_attr_type_internal',   'type' => 'bool',   'internal' => 'isInternal'],
        'equipmgmt_attr_type_pattern'    => ['name' => 'equipmgmt_attr_type_pattern',  'type' => 'string', 'internal' => 'validationPattern'],
        'equipmgmt_attr_type_required'   => ['name' => 'equipmgmt_attr_type_required', 'type' => 'bool',   'internal' => 'isRequired'],
    ];

    /**
     * Has many relation.
     *
     * @var array<string, array{mapper:class-string, table:string, self?:?string, external?:?string, column?:string}>
     * @since 1.0.0
     */
    public const HAS_MANY = [
        'l11n' => [
            'mapper'   => EquipmentAttributeTypeL11nMapper::class,
            'table'    => 'equipmgmt_attr_type_l11n',
            'self'     => 'equipmgmt_attr_type_l11n_type',
            'column'   => 'content',
            'external' => null,
        ],
        'defaults' => [
            'mapper'   => EquipmentAttributeValueMapper::class,
            'table'    => 'equipmgmt_equipment_attr_default',
            'self'     => 'equipmgmt_equipment_attr_default_type',
            'external' => 'equipmgmt_equipment_attr_default_value',
        ],
    ];

    /**
     * Model to use by the mapper.
     *
     * @var class-string<T>
     * @since 1.0.0
     */
    public const MODEL = AttributeType::class;

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    public const TABLE = 'equipmgmt_attr_type';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    public const PRIMARYFIELD = 'equipmgmt_attr_type_id';
}
