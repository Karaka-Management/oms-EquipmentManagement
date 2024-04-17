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

use phpOMS\Localization\BaseStringL11nType;

/**
 * Equipment class.
 *
 * @package Modules\EquipmentManagement\Models
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
class Equipment implements \JsonSerializable
{
    public int $id = 0;

    public string $name = '';

    public string $code = '';

    public int $status = EquipmentStatus::ACTIVE;

    public BaseStringL11nType $type;

    public string $info = '';

    public array $inspections = [];

    public int $unit = 0;

    public ?int $responsible = null;

    public \DateTimeImmutable $createdAt;

    /**
     * Constructor.
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable('now');
        $this->type      = new BaseStringL11nType();
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
    use \Modules\Editor\Models\EditorDocListTrait;
    use \Modules\Attribute\Models\AttributeHolderTrait;
}
