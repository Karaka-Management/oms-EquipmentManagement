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
use phpOMS\Localization\BaseStringL11n;

/**
 * Equipment type l11n mapper class.
 *
 * @package Modules\EquipmentManagement\Models
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 *
 * @template T of BaseStringL11n
 * @extends DataMapperFactory<T>
 */
final class EquipmentTypeL11nMapper extends DataMapperFactory
{
    /**
     * Columns.
     *
     * @var array<string, array{name:string, type:string, internal:string, autocomplete?:bool, readonly?:bool, writeonly?:bool, annotations?:array}>
     * @since 1.0.0
     */
    public const COLUMNS = [
        'equipmgmt_equipment_type_l11n_id'    => ['name' => 'equipmgmt_equipment_type_l11n_id',    'type' => 'int',    'internal' => 'id'],
        'equipmgmt_equipment_type_l11n_title' => ['name' => 'equipmgmt_equipment_type_l11n_title', 'type' => 'string', 'internal' => 'content', 'autocomplete' => true],
        'equipmgmt_equipment_type_l11n_type'  => ['name' => 'equipmgmt_equipment_type_l11n_type',  'type' => 'int',    'internal' => 'ref'],
        'equipmgmt_equipment_type_l11n_lang'  => ['name' => 'equipmgmt_equipment_type_l11n_lang',  'type' => 'string',    'internal' => 'language'],
    ];

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    public const TABLE = 'equipmgmt_equipment_type_l11n';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    public const PRIMARYFIELD = 'equipmgmt_equipment_type_l11n_id';

    /**
     * Model to use by the mapper.
     *
     * @var class-string<T>
     * @since 1.0.0
     */
    public const MODEL = BaseStringL11n::class;
}
