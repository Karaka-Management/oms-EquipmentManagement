<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\EquipmentManagement\Models\Attribute
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.2
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\EquipmentManagement\Models\Attribute;

use Modules\Attribute\Models\AttributeValue;
use phpOMS\DataStorage\Database\Mapper\DataMapperFactory;

/**
 * Equipment mapper class.
 *
 * @package Modules\EquipmentManagement\Models\Attribute
 * @license OMS License 2.2
 * @link    https://jingga.app
 * @since   1.0.0
 *
 * @template T of AttributeValue
 * @extends DataMapperFactory<T>
 */
final class EquipmentAttributeValueMapper extends DataMapperFactory
{
    /**
     * Columns.
     *
     * @var array<string, array{name:string, type:string, internal:string, autocomplete?:bool, readonly?:bool, writeonly?:bool, annotations?:array}>
     * @since 1.0.0
     */
    public const COLUMNS = [
        'equipmgmt_attr_value_id'       => ['name' => 'equipmgmt_attr_value_id',       'type' => 'int',      'internal' => 'id'],
        'equipmgmt_attr_value_default'  => ['name' => 'equipmgmt_attr_value_default',  'type' => 'bool',     'internal' => 'isDefault'],
        'equipmgmt_attr_value_valueStr' => ['name' => 'equipmgmt_attr_value_valueStr', 'type' => 'string',   'internal' => 'valueStr'],
        'equipmgmt_attr_value_valueInt' => ['name' => 'equipmgmt_attr_value_valueInt', 'type' => 'int',      'internal' => 'valueInt'],
        'equipmgmt_attr_value_valueDec' => ['name' => 'equipmgmt_attr_value_valueDec', 'type' => 'float',    'internal' => 'valueDec'],
        'equipmgmt_attr_value_valueDat' => ['name' => 'equipmgmt_attr_value_valueDat', 'type' => 'DateTime', 'internal' => 'valueDat'],
        'equipmgmt_attr_value_unit'     => ['name' => 'equipmgmt_attr_value_unit', 'type' => 'string', 'internal' => 'unit'],
        'equipmgmt_attr_value_deptype'  => ['name' => 'equipmgmt_attr_value_deptype', 'type' => 'int', 'internal' => 'dependingAttributeType'],
        'equipmgmt_attr_value_depvalue' => ['name' => 'equipmgmt_attr_value_depvalue', 'type' => 'int', 'internal' => 'dependingAttributeValue'],
    ];

    /**
     * Has many relation.
     *
     * @var array<string, array{mapper:class-string, table:string, self?:?string, external?:?string, column?:string}>
     * @since 1.0.0
     */
    public const HAS_MANY = [
        'l11n' => [
            'mapper'   => EquipmentAttributeValueL11nMapper::class,
            'table'    => 'equipmgmt_attr_value_l11n',
            'self'     => 'equipmgmt_attr_value_l11n_value',
            'column'   => 'content',
            'external' => null,
        ],
    ];

    /**
     * Model to use by the mapper.
     *
     * @var class-string<T>
     * @since 1.0.0
     */
    public const MODEL = AttributeValue::class;

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    public const TABLE = 'equipmgmt_attr_value';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    public const PRIMARYFIELD = 'equipmgmt_attr_value_id';
}
