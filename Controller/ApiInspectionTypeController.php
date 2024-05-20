<?php

/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\EquipmentManagement
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.2
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\EquipmentManagement\Controller;

use Modules\EquipmentManagement\Models\Inspection;
use Modules\EquipmentManagement\Models\InspectionMapper;
use Modules\EquipmentManagement\Models\InspectionStatus;
use Modules\EquipmentManagement\Models\InspectionTypeL11nMapper;
use Modules\EquipmentManagement\Models\InspectionTypeMapper;
use phpOMS\Localization\BaseStringL11n;
use phpOMS\Localization\BaseStringL11nType;
use phpOMS\Localization\ISO639x1Enum;
use phpOMS\Localization\NullBaseStringL11nType;
use phpOMS\Message\Http\RequestStatusCode;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;

/**
 * EquipmentManagement class.
 *
 * @package Modules\EquipmentManagement
 * @license OMS License 2.2
 * @link    https://jingga.app
 * @since   1.0.0
 */
final class ApiInspectionTypeController extends Controller
{
    /**
     * Api method to create a vehicle
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
    public function apiInspectionCreate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        if (!empty($val = $this->validateInspectionCreate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidCreateResponse($request, $response, $val);

            return;
        }

        /** @var \Modules\FleetManagement\Models\Inspection $inspection */
        $inspection = $this->createInspectionFromRequest($request);
        $this->createModel($request->header->account, $inspection, InspectionMapper::class, 'inspection', $request->getOrigin());
        $this->createStandardCreateResponse($request, $response, $inspection);
    }

    /**
     * Method to create vehicle from request.
     *
     * @param RequestAbstract $request Request
     *
     * @return Inspection Returns the created vehicle from the request
     *
     * @since 1.0.0
     */
    public function createInspectionFromRequest(RequestAbstract $request) : Inspection
    {
        $inspection              = new Inspection();
        $inspection->reference   = (int) $request->getData('ref');
        $inspection->description = $request->getDataString('description') ?? '';
        $inspection->status      = InspectionStatus::tryFromValue($request->getDataInt('status')) ?? InspectionStatus::TODO;
        $inspection->next        = $request->getDataDateTime('next') ?? null;
        $inspection->date        = $request->getDataDateTime('date') ?? null;
        $inspection->interval    = $request->getDataInt('interval') ?? 0;
        $inspection->type        = new NullBaseStringL11nType((int) $request->getData('type'));

        return $inspection;
    }

    /**
     * Validate vehicle create request
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool> Returns the validation array of the request
     *
     * @since 1.0.0
     */
    private function validateInspectionCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['ref'] = !$request->hasData('ref'))) {
            return $val;
        }

        return [];
    }

    /**
     * Api method to create InspectionType
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
    public function apiInspectionTypeCreate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        if (!empty($val = $this->validateInspectionTypeCreate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidCreateResponse($request, $response, $val);

            return;
        }

        $equipmentType = $this->createInspectionTypeFromRequest($request);
        $this->createModel($request->header->account, $equipmentType, InspectionTypeMapper::class, 'equipment_type', $request->getOrigin());
        $this->createStandardCreateResponse($request, $response, $equipmentType);
    }

    /**
     * Method to create InspectionType from request.
     *
     * @param RequestAbstract $request Request
     *
     * @return BaseStringL11nType
     *
     * @since 1.0.0
     */
    private function createInspectionTypeFromRequest(RequestAbstract $request) : BaseStringL11nType
    {
        $equipmentType = new BaseStringL11nType();
        $equipmentType->setL11n(
            $request->getDataString('title') ?? '',
            ISO639x1Enum::tryFromValue($request->getDataString('language')) ?? ISO639x1Enum::_EN
        );
        $equipmentType->title = $request->getDataString('name') ?? '';

        return $equipmentType;
    }

    /**
     * Validate InspectionType create request
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @since 1.0.0
     */
    private function validateInspectionTypeCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['title'] = !$request->hasData('title'))
        ) {
            return $val;
        }

        return [];
    }

    /**
     * Api method to create InspectionType l11n
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
    public function apiInspectionTypeL11nCreate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        if (!empty($val = $this->validateInspectionTypeL11nCreate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidCreateResponse($request, $response, $val);

            return;
        }

        $equipmentTypeL11n = $this->createInspectionTypeL11nFromRequest($request);
        $this->createModel($request->header->account, $equipmentTypeL11n, InspectionTypeL11nMapper::class, 'equipment_type_l11n', $request->getOrigin());
        $this->createStandardCreateResponse($request, $response, $equipmentTypeL11n);
    }

    /**
     * Method to create InspectionType l11n from request.
     *
     * @param RequestAbstract $request Request
     *
     * @return BaseStringL11n
     *
     * @since 1.0.0
     */
    private function createInspectionTypeL11nFromRequest(RequestAbstract $request) : BaseStringL11n
    {
        $equipmentTypeL11n           = new BaseStringL11n();
        $equipmentTypeL11n->ref      = $request->getDataInt('type') ?? 0;
        $equipmentTypeL11n->language = ISO639x1Enum::tryFromValue($request->getDataString('language')) ?? $request->header->l11n->language;
        $equipmentTypeL11n->content  = $request->getDataString('title') ?? '';

        return $equipmentTypeL11n;
    }

    /**
     * Validate InspectionType l11n create request
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @since 1.0.0
     */
    private function validateInspectionTypeL11nCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['title'] = !$request->hasData('title'))
            || ($val['type'] = !$request->hasData('type'))
        ) {
            return $val;
        }

        return [];
    }

    /**
     * Api method to update InspectionType
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
    public function apiInspectionTypeUpdate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        if (!empty($val = $this->validateInspectionTypeUpdate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidUpdateResponse($request, $response, $val);

            return;
        }

        /** @var BaseStringL11nType $old */
        $old = InspectionTypeMapper::get()->where('id', (int) $request->getData('id'));
        $new = $this->updateInspectionTypeFromRequest($request, clone $old);

        $this->updateModel($request->header->account, $old, $new, InspectionTypeMapper::class, 'equipment_type', $request->getOrigin());
        $this->createStandardUpdateResponse($request, $response, $new);
    }

    /**
     * Method to update InspectionType from request.
     *
     * @param RequestAbstract    $request Request
     * @param BaseStringL11nType $new     Model to modify
     *
     * @return BaseStringL11nType
     *
     * @todo Implement API update function
     *
     * @since 1.0.0
     */
    public function updateInspectionTypeFromRequest(RequestAbstract $request, BaseStringL11nType $new) : BaseStringL11nType
    {
        $new->title = $request->getDataString('name') ?? $new->title;

        return $new;
    }

    /**
     * Validate InspectionType update request
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @todo Implement API validation function
     *
     * @since 1.0.0
     */
    private function validateInspectionTypeUpdate(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['id'] = !$request->hasData('id'))) {
            return $val;
        }

        return [];
    }

    /**
     * Api method to delete InspectionType
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
    public function apiInspectionTypeDelete(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        if (!empty($val = $this->validateInspectionTypeDelete($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidDeleteResponse($request, $response, $val);

            return;
        }

        /** @var BaseStringL11nType $equipmentType */
        $equipmentType = InspectionTypeMapper::get()->where('id', (int) $request->getData('id'))->execute();
        $this->deleteModel($request->header->account, $equipmentType, InspectionTypeMapper::class, 'equipment_type', $request->getOrigin());
        $this->createStandardDeleteResponse($request, $response, $equipmentType);
    }

    /**
     * Validate InspectionType delete request
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @since 1.0.0
     */
    private function validateInspectionTypeDelete(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['id'] = !$request->hasData('id'))) {
            return $val;
        }

        return [];
    }

    /**
     * Api method to update InspectionTypeL11n
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
    public function apiInspectionTypeL11nUpdate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        if (!empty($val = $this->validateInspectionTypeL11nUpdate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidUpdateResponse($request, $response, $val);

            return;
        }

        /** @var BaseStringL11n $old */
        $old = InspectionTypeL11nMapper::get()->where('id', (int) $request->getData('id'));
        $new = $this->updateInspectionTypeL11nFromRequest($request, clone $old);

        $this->updateModel($request->header->account, $old, $new, InspectionTypeL11nMapper::class, 'equipment_type_l11n', $request->getOrigin());
        $this->createStandardUpdateResponse($request, $response, $new);
    }

    /**
     * Method to update InspectionTypeL11n from request.
     *
     * @param RequestAbstract $request Request
     * @param BaseStringL11n  $new     Model to modify
     *
     * @return BaseStringL11n
     *
     * @since 1.0.0
     */
    public function updateInspectionTypeL11nFromRequest(RequestAbstract $request, BaseStringL11n $new) : BaseStringL11n
    {
        $new->language = ISO639x1Enum::tryFromValue($request->getDataString('language')) ?? $new->language;
        $new->content  = $request->getDataString('title') ?? $new->content;

        return $new;
    }

    /**
     * Validate InspectionTypeL11n update request
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @since 1.0.0
     */
    private function validateInspectionTypeL11nUpdate(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['id'] = !$request->hasData('id'))) {
            return $val;
        }

        return [];
    }

    /**
     * Api method to delete InspectionTypeL11n
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
    public function apiInspectionTypeL11nDelete(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        if (!empty($val = $this->validateInspectionTypeL11nDelete($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidDeleteResponse($request, $response, $val);

            return;
        }

        /** @var BaseStringL11n $equipmentTypeL11n */
        $equipmentTypeL11n = InspectionTypeL11nMapper::get()->where('id', (int) $request->getData('id'))->execute();
        $this->deleteModel($request->header->account, $equipmentTypeL11n, InspectionTypeL11nMapper::class, 'equipment_type_l11n', $request->getOrigin());
        $this->createStandardDeleteResponse($request, $response, $equipmentTypeL11n);
    }

    /**
     * Validate InspectionTypeL11n delete request
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @since 1.0.0
     */
    private function validateInspectionTypeL11nDelete(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['id'] = !$request->hasData('id'))) {
            return $val;
        }

        return [];
    }
}
