<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\EquipmentManagement\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\EquipmentManagement\Models;

use Modules\Admin\Models\Account;
use phpOMS\Localization\BaseStringL11nType;

/**
 * Inspection class.
 *
 * @package Modules\Attribute\Models
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
class Inspection implements \JsonSerializable
{
    public int $id = 0;

    public string $description = '';

    public BaseStringL11nType $type;

    public int $status = InspectionStatus::TODO;

    // Automatically get's filled from the previous inspection if available
    // Alternatively define default interval from inspection type?
    public ?\DateTime $next = null;

    public ?\DateTime $date = null;

    /**
     * Inspection duration in hours
     */
    public int $duration = 0;

    /**
     * Inspection interval in months
     *
     * @var int
     * @since 1.0.0
     */
    public int $interval = 0;

    public int $reference = 0;

    public ?Account $responsible = null;

    /**
     * Constructor
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        $this->type = new BaseStringL11nType();
    }

    /**
     * {@inheritdoc}
     */
    public function toArray() : array
    {
        return [
            'id' => $this->id,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize() : mixed
    {
        return $this->toArray();
    }

    use \Modules\Media\Models\MediaListTrait;
}
