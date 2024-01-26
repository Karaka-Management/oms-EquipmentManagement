<?php
/**
 * Jingga
 *
 * PHP Version 8.1
 *
 * @package   Modules\EquipmentManagement
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\EquipmentManagement\Controller;

use Modules\Attribute\Models\Attribute;
use Modules\Attribute\Models\AttributeType;
use Modules\Attribute\Models\AttributeValue;
use Modules\EquipmentManagement\Models\Attribute\EquipmentAttributeMapper;
use Modules\EquipmentManagement\Models\Attribute\EquipmentAttributeTypeL11nMapper;
use Modules\EquipmentManagement\Models\Attribute\EquipmentAttributeTypeMapper;
use Modules\EquipmentManagement\Models\Attribute\EquipmentAttributeValueL11nMapper;
use Modules\EquipmentManagement\Models\Attribute\EquipmentAttributeValueMapper;
use phpOMS\Localization\BaseStringL11n;
use phpOMS\Message\Http\RequestStatusCode;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;

/**
 * EquipmentManagement class.
 *
 * @package Modules\EquipmentManagement
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
final class ApiEquipmentAttributeController extends Controller
{
    use \Modules\Attribute\Controller\ApiAttributeTraitController;

    /**
     * Api method to create item attribute
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiEquipmentAttributeCreate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        if (!empty($val = $this->validateAttributeCreate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidCreateResponse($request, $response, $val);

            return;
        }

        $type = EquipmentAttributeTypeMapper::get()
            ->with('defaults')
            ->where('id', (int) $request->getData('type'))
            ->execute();

        if (!$type->repeatable) {
            $attr = EquipmentAttributeMapper::count()
                ->with('type')
                ->where('type/id', $type->id)
                ->where('ref', (int) $request->getData('ref'))
                ->execute();

            if ($attr > 0) {
                $response->header->status = RequestStatusCode::R_409;
                $this->createInvalidCreateResponse($request, $response, $val);

                return;
            }
        }

        $attribute = $this->createAttributeFromRequest($request, $type);
        $this->createModel($request->header->account, $attribute, EquipmentAttributeMapper::class, 'attribute', $request->getOrigin());
        $this->createStandardCreateResponse($request, $response, $attribute);
    }

    /**
     * Api method to create equipment attribute l11n
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiEquipmentAttributeTypeL11nCreate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        if (!empty($val = $this->validateAttributeTypeL11nCreate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidCreateResponse($request, $response, $val);

            return;
        }

        $attrL11n = $this->createAttributeTypeL11nFromRequest($request);
        $this->createModel($request->header->account, $attrL11n, EquipmentAttributeTypeL11nMapper::class, 'attr_type_l11n', $request->getOrigin());
        $this->createStandardCreateResponse($request, $response, $attrL11n);
    }

    /**
     * Api method to create equipment attribute type
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiEquipmentAttributeTypeCreate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        if (!empty($val = $this->validateAttributeTypeCreate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidCreateResponse($request, $response, $val);

            return;
        }

        $attrType = $this->createAttributeTypeFromRequest($request);
        $this->createModel($request->header->account, $attrType, EquipmentAttributeTypeMapper::class, 'attr_type', $request->getOrigin());
        $this->createStandardCreateResponse($request, $response, $attrType);
    }

    /**
     * Api method to create equipment attribute value
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiEquipmentAttributeValueCreate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        if (!empty($val = $this->validateAttributeValueCreate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidCreateResponse($request, $response, $val);

            return;
        }

        /** @var \Modules\Attribute\Models\AttributeType $type */
        $type = EquipmentAttributeTypeMapper::get()
            ->where('id', $request->getDataInt('type') ?? 0)
            ->execute();

        if ($type->isInternal) {
            $response->header->status = RequestStatusCode::R_403;
            $this->createInvalidCreateResponse($request, $response, $val);

            return;
        }

        $attrValue = $this->createAttributeValueFromRequest($request, $type);
        $this->createModel($request->header->account, $attrValue, EquipmentAttributeValueMapper::class, 'attr_value', $request->getOrigin());

        if ($attrValue->isDefault) {
            $this->createModelRelation(
                $request->header->account,
                $type->id,
                $attrValue->id,
                EquipmentAttributeTypeMapper::class, 'defaults', '', $request->getOrigin()
            );
        }

        $this->createStandardCreateResponse($request, $response, $attrValue);
    }

    /**
     * Api method to create equipment attribute l11n
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiEquipmentAttributeValueL11nCreate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        if (!empty($val = $this->validateAttributeValueL11nCreate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidCreateResponse($request, $response, $val);

            return;
        }

        $attrL11n = $this->createAttributeValueL11nFromRequest($request);
        $this->createModel($request->header->account, $attrL11n, EquipmentAttributeValueL11nMapper::class, 'attr_value_l11n', $request->getOrigin());
        $this->createStandardCreateResponse($request, $response, $attrL11n);
    }

    /**
     * Api method to update EquipmentAttribute
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiEquipmentAttributeUpdate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        if (!empty($val = $this->validateAttributeUpdate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidUpdateResponse($request, $response, $val);

            return;
        }

        /** @var Attribute $old */
        $old = EquipmentAttributeMapper::get()
            ->with('type')
            ->with('type/defaults')
            ->with('value')
            ->where('id', (int) $request->getData('id'))
            ->execute();

        $new = $this->updateAttributeFromRequest($request, clone $old);

        if ($new->id === 0) {
            // Set response header to invalid request because of invalid data
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidUpdateResponse($request, $response, $new);

            return;
        }

        $this->updateModel($request->header->account, $old, $new, EquipmentAttributeMapper::class, 'equipment_attribute', $request->getOrigin());

        if ($new->value->getValue() !== $old->value->getValue()
            && $new->type->custom
        ) {
            $this->updateModel($request->header->account, $old->value, $new->value, EquipmentAttributeValueMapper::class, 'attribute_value', $request->getOrigin());
        }

        $this->createStandardUpdateResponse($request, $response, $new);
    }

    /**
     * Api method to delete EquipmentAttribute
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiEquipmentAttributeDelete(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        if (!empty($val = $this->validateAttributeDelete($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidDeleteResponse($request, $response, $val);

            return;
        }

        $equipmentAttribute = EquipmentAttributeMapper::get()
            ->with('type')
            ->where('id', (int) $request->getData('id'))
            ->execute();

        if ($equipmentAttribute->type->isRequired) {
            $this->createInvalidDeleteResponse($request, $response, []);

            return;
        }

        $this->deleteModel($request->header->account, $equipmentAttribute, EquipmentAttributeMapper::class, 'equipment_attribute', $request->getOrigin());
        $this->createStandardDeleteResponse($request, $response, $equipmentAttribute);
    }

    /**
     * Api method to update EquipmentAttributeTypeL11n
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiEquipmentAttributeTypeL11nUpdate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        if (!empty($val = $this->validateAttributeTypeL11nUpdate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidUpdateResponse($request, $response, $val);

            return;
        }

        /** @var BaseStringL11n $old */
        $old = EquipmentAttributeTypeL11nMapper::get()->where('id', (int) $request->getData('id'))->execute();
        $new = $this->updateAttributeTypeL11nFromRequest($request, clone $old);

        $this->updateModel($request->header->account, $old, $new, EquipmentAttributeTypeL11nMapper::class, 'equipment_attribute_type_l11n', $request->getOrigin());
        $this->createStandardUpdateResponse($request, $response, $new);
    }

    /**
     * Api method to delete EquipmentAttributeTypeL11n
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiEquipmentAttributeTypeL11nDelete(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        if (!empty($val = $this->validateAttributeTypeL11nDelete($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidDeleteResponse($request, $response, $val);

            return;
        }

        /** @var BaseStringL11n $equipmentAttributeTypeL11n */
        $equipmentAttributeTypeL11n = EquipmentAttributeTypeL11nMapper::get()->where('id', (int) $request->getData('id'))->execute();
        $this->deleteModel($request->header->account, $equipmentAttributeTypeL11n, EquipmentAttributeTypeL11nMapper::class, 'equipment_attribute_type_l11n', $request->getOrigin());
        $this->createStandardDeleteResponse($request, $response, $equipmentAttributeTypeL11n);
    }

    /**
     * Api method to update EquipmentAttributeType
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiEquipmentAttributeTypeUpdate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        if (!empty($val = $this->validateAttributeTypeUpdate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidUpdateResponse($request, $response, $val);

            return;
        }

        /** @var AttributeType $old */
        $old = EquipmentAttributeTypeMapper::get()->with('defaults')->where('id', (int) $request->getData('id'))->execute();
        $new = $this->updateAttributeTypeFromRequest($request, clone $old);

        $this->updateModel($request->header->account, $old, $new, EquipmentAttributeTypeMapper::class, 'equipment_attribute_type', $request->getOrigin());
        $this->createStandardUpdateResponse($request, $response, $new);
    }

    /**
     * Api method to delete EquipmentAttributeType
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @todo Implement API function
     *
     * @since 1.0.0
     */
    public function apiEquipmentAttributeTypeDelete(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        if (!empty($val = $this->validateAttributeTypeDelete($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidDeleteResponse($request, $response, $val);

            return;
        }

        /** @var AttributeType $equipmentAttributeType */
        $equipmentAttributeType = EquipmentAttributeTypeMapper::get()->with('defaults')->where('id', (int) $request->getData('id'))->execute();
        $this->deleteModel($request->header->account, $equipmentAttributeType, EquipmentAttributeTypeMapper::class, 'equipment_attribute_type', $request->getOrigin());
        $this->createStandardDeleteResponse($request, $response, $equipmentAttributeType);
    }

    /**
     * Api method to update EquipmentAttributeValue
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiEquipmentAttributeValueUpdate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        if (!empty($val = $this->validateAttributeValueUpdate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidUpdateResponse($request, $response, $val);

            return;
        }

        /** @var AttributeValue $old */
        $old = EquipmentAttributeValueMapper::get()->where('id', (int) $request->getData('id'))->execute();

        /** @var \Modules\Attribute\Models\Attribute $attr */
        $attr = EquipmentAttributeMapper::get()
            ->with('type')
            ->where('id', $request->getDataInt('attribute') ?? 0)
            ->execute();

        $new = $this->updateAttributeValueFromRequest($request, clone $old, $attr);

        $this->updateModel($request->header->account, $old, $new, EquipmentAttributeValueMapper::class, 'equipment_attribute_value', $request->getOrigin());
        $this->createStandardUpdateResponse($request, $response, $new);
    }

    /**
     * Api method to delete EquipmentAttributeValue
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiEquipmentAttributeValueDelete(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        // @todo I don't think values can be deleted? Only Attributes
        // However, It should be possible to remove UNUSED default values
        // either here or other function?
        // if (!empty($val = $this->validateAttributeValueDelete($request))) {
        //     $response->header->status = RequestStatusCode::R_400;
        //     $this->createInvalidDeleteResponse($request, $response, $val);

        //     return;
        // }

        // /** @var \Modules\EquipmentManagement\Models\EquipmentAttributeValue $equipmentAttributeValue */
        // $equipmentAttributeValue = EquipmentAttributeValueMapper::get()->where('id', (int) $request->getData('id'))->execute();
        // $this->deleteModel($request->header->account, $equipmentAttributeValue, EquipmentAttributeValueMapper::class, 'equipment_attribute_value', $request->getOrigin());
        // $this->createStandardDeleteResponse($request, $response, $equipmentAttributeValue);
    }

    /**
     * Api method to update EquipmentAttributeValueL11n
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiEquipmentAttributeValueL11nUpdate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        if (!empty($val = $this->validateAttributeValueL11nUpdate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidUpdateResponse($request, $response, $val);

            return;
        }

        /** @var BaseStringL11n $old */
        $old = EquipmentAttributeValueL11nMapper::get()->where('id', (int) $request->getData('id'));
        $new = $this->updateAttributeValueL11nFromRequest($request, clone $old);

        $this->updateModel($request->header->account, $old, $new, EquipmentAttributeValueL11nMapper::class, 'equipment_attribute_value_l11n', $request->getOrigin());
        $this->createStandardUpdateResponse($request, $response, $new);
    }

    /**
     * Api method to delete EquipmentAttributeValueL11n
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiEquipmentAttributeValueL11nDelete(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        if (!empty($val = $this->validateAttributeValueL11nDelete($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidDeleteResponse($request, $response, $val);

            return;
        }

        /** @var BaseStringL11n $equipmentAttributeValueL11n */
        $equipmentAttributeValueL11n = EquipmentAttributeValueL11nMapper::get()->where('id', (int) $request->getData('id'))->execute();
        $this->deleteModel($request->header->account, $equipmentAttributeValueL11n, EquipmentAttributeValueL11nMapper::class, 'equipment_attribute_value_l11n', $request->getOrigin());
        $this->createStandardDeleteResponse($request, $response, $equipmentAttributeValueL11n);
    }
}
