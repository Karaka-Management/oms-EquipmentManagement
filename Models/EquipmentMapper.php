<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\EquipmentManagement\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.2
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\EquipmentManagement\Models;

use Modules\Editor\Models\EditorDocMapper;
use Modules\EquipmentManagement\Models\Attribute\EquipmentAttributeMapper;
use Modules\Media\Models\MediaMapper;
use phpOMS\DataStorage\Database\Mapper\DataMapperFactory;

/**
 * Equipment mapper class.
 *
 * @package Modules\EquipmentManagement\Models
 * @license OMS License 2.2
 * @link    https://jingga.app
 * @since   1.0.0
 *
 * @template T of Equipment
 * @extends DataMapperFactory<T>
 */
final class EquipmentMapper extends DataMapperFactory
{
    /**
     * Columns.
     *
     * @var array<string, array{name:string, type:string, internal:string, autocomplete?:bool, readonly?:bool, writeonly?:bool, annotations?:array}>
     * @since 1.0.0
     */
    public const COLUMNS = [
        'equipmgmt_equipment_id'          => ['name' => 'equipmgmt_equipment_id',         'type' => 'int',      'internal' => 'id'],
        'equipmgmt_equipment_name'        => ['name' => 'equipmgmt_equipment_name',      'type' => 'string',   'internal' => 'name'],
        'equipmgmt_equipment_code'        => ['name' => 'equipmgmt_equipment_code',      'type' => 'string',   'internal' => 'code'],
        'equipmgmt_equipment_location'    => ['name' => 'equipmgmt_equipment_location',      'type' => 'string',   'internal' => 'location'],
        'equipmgmt_equipment_status'      => ['name' => 'equipmgmt_equipment_status',      'type' => 'int',   'internal' => 'status'],
        'equipmgmt_equipment_info'        => ['name' => 'equipmgmt_equipment_info',      'type' => 'string',   'internal' => 'info'],
        'equipmgmt_equipment_unit'        => ['name' => 'equipmgmt_equipment_unit',      'type' => 'int',   'internal' => 'unit'],
        'equipmgmt_equipment_type'        => ['name' => 'equipmgmt_equipment_type',      'type' => 'int',   'internal' => 'type'],
        'equipmgmt_equipment_responsible' => ['name' => 'equipmgmt_equipment_responsible',      'type' => 'int',   'internal' => 'responsible'],
        'equipmgmt_equipment_created_at'  => ['name' => 'equipmgmt_equipment_created_at', 'type' => 'DateTimeImmutable', 'internal' => 'createdAt', 'readonly' => true],
    ];

    /**
     * Has many relation.
     *
     * @var array<string, array{mapper:class-string, table:string, self?:?string, external?:?string, column?:string}>
     * @since 1.0.0
     */
    public const HAS_MANY = [
        'files' => [
            'mapper'   => MediaMapper::class,
            'table'    => 'equipmgmt_equipment_media',
            'external' => 'equipmgmt_equipment_media_media',
            'self'     => 'equipmgmt_equipment_media_equipment',
        ],
        'attributes' => [
            'mapper'   => EquipmentAttributeMapper::class,
            'table'    => 'equipmgmt_equipment_attr',
            'self'     => 'equipmgmt_equipment_attr_equipment',
            'external' => null,
        ],
        'notes' => [
            'mapper'   => EditorDocMapper::class,       /* mapper of the related object */
            'table'    => 'equipmgmt_equipment_note',         /* table of the related object, null if no relation table is used (many->1) */
            'external' => 'equipmgmt_equipment_note_doc',
            'self'     => 'equipmgmt_equipment_note_equipment',
        ],
    ];

    /**
     * Has one relation.
     *
     * @var array<string, array{mapper:class-string, external:string, by?:string, column?:string, conditional?:bool}>
     * @since 1.0.0
     */
    public const OWNS_ONE = [
        'type' => [
            'mapper'   => EquipmentTypeMapper::class,
            'external' => 'equipmgmt_equipment_type',
        ],
    ];

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    public const TABLE = 'equipmgmt_equipment';

    /**
     * Created at.
     *
     * @var string
     * @since 1.0.0
     */
    public const CREATED_AT = 'equipmgmt_equipment_created_at';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    public const PRIMARYFIELD = 'equipmgmt_equipment_id';
}
