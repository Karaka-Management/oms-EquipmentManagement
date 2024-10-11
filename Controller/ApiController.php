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

use Modules\EquipmentManagement\Models\Equipment;
use Modules\EquipmentManagement\Models\EquipmentMapper;
use Modules\EquipmentManagement\Models\EquipmentStatus;
use Modules\EquipmentManagement\Models\PermissionCategory;
use Modules\Media\Models\NullCollection;
use Modules\Media\Models\PathSettings;
use phpOMS\Account\PermissionType;
use phpOMS\Localization\NullBaseStringL11nType;
use phpOMS\Message\Http\RequestStatusCode;
use phpOMS\Message\NotificationLevel;
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
final class ApiController extends Controller
{
    /**
     * Api method to create a equipment
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
    public function apiEquipmentCreate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        if (!empty($val = $this->validateEquipmentCreate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidCreateResponse($request, $response, $val);

            return;
        }

        /** @var Equipment $equipment */
        $equipment = $this->createEquipmentFromRequest($request);
        $this->createModel($request->header->account, $equipment, EquipmentMapper::class, 'equipment', $request->getOrigin());

        if (!empty($request->files)
            || !empty($request->getDataJson('media'))
        ) {
            $this->createEquipmentMedia($equipment, $request);
        }

        $this->createStandardCreateResponse($request, $response, $equipment);
    }

    /**
     * Method to create equipment from request.
     *
     * @param RequestAbstract $request Request
     *
     * @return Equipment Returns the created equipment from the request
     *
     * @since 1.0.0
     */
    public function createEquipmentFromRequest(RequestAbstract $request) : Equipment
    {
        $equipment           = new Equipment();
        $equipment->name     = $request->getDataString('name') ?? '';
        $equipment->info     = $request->getDataString('info') ?? '';
        $equipment->code     = $request->getDataString('code') ?? '';
        $equipment->location = $request->getDataString('location') ?? '';
        $equipment->type     = new NullBaseStringL11nType((int) ($request->getDataInt('type') ?? 0));
        $equipment->status   = EquipmentStatus::tryFromValue($request->getDataInt('status')) ?? EquipmentStatus::INACTIVE;
        $equipment->unit     = $request->getDataInt('unit') ?? $this->app->unitId;

        return $equipment;
    }

    /**
     * Create media files for equipment
     *
     * @param Equipment       $equipment Equipment
     * @param RequestAbstract $request   Request incl. media do upload
     *
     * @return void
     *
     * @since 1.0.0
     */
    private function createEquipmentMedia(Equipment $equipment, RequestAbstract $request) : void
    {
        $path = $this->createEquipmentDir($equipment);

        if (!empty($request->files)) {
            $this->app->moduleManager->get('Media', 'Api')->uploadFiles(
                names: [],
                fileNames: [],
                files: $request->files,
                account: $request->header->account,
                basePath: __DIR__ . '/../../../Modules/Media/Files' . $path,
                virtualPath: $path,
                pathSettings: PathSettings::FILE_PATH,
                rel: $equipment->id,
                mapper: EquipmentMapper::class,
                field: 'files'
            );
        }

        if (!empty($media = $request->getDataJson('media'))) {
            $this->app->moduleManager->get('Media', 'Api')->addMediaToCollectionAndModel(
                $request->header->account,
                $media,
                $equipment->id,
                EquipmentMapper::class,
                'files',
                $path
            );
        }
    }

    /**
     * Validate equipment create request
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool> Returns the validation array of the request
     *
     * @since 1.0.0
     */
    private function validateEquipmentCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['name'] = !$request->hasData('name'))
            || ($val['type'] = !$request->hasData('type'))
        ) {
            return $val;
        }

        return [];
    }

    /**
     * Api method to create a bill
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
    public function apiMediaAddToEquipment(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        if (!empty($val = $this->validateMediaAddToEquipment($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidAddResponse($request, $response, $val);

            return;
        }

        /** @var \Modules\EquipmentManagement\Models\Equipment $equipment */
        $equipment = EquipmentMapper::get()->where('id', (int) $request->getData('equipment'))->execute();
        $path      = $this->createEquipmentDir($equipment);

        $uploaded = new NullCollection();
        if (!empty($request->files)) {
            $uploaded = $this->app->moduleManager->get('Media', 'Api')->uploadFiles(
                names: [],
                fileNames: [],
                files: $request->files,
                account: $request->header->account,
                basePath: __DIR__ . '/../../../Modules/Media/Files' . $path,
                virtualPath: $path,
                pathSettings: PathSettings::FILE_PATH,
                hasAccountRelation: false,
                readContent: $request->getDataBool('parse_content') ?? false,
                tag: $request->getDataInt('tag'),
                rel: $equipment->id,
                mapper: EquipmentMapper::class,
                field: 'files'
            );
        }

        if (!empty($media = $request->getDataJson('media'))) {
            $this->app->moduleManager->get('Media', 'Api')->addMediaToCollectionAndModel(
                $request->header->account,
                $media,
                $equipment->id,
                EquipmentMapper::class,
                'files',
                $path
            );
        }

        $this->fillJsonResponse($request, $response, NotificationLevel::OK, '', $this->app->l11nManager->getText($response->header->l11n->language, '0', '0', 'SuccessfulAdd'), [
            'upload' => $uploaded->sources,
            'media'  => $media,
        ]);
    }

    /**
     * Create media directory path
     *
     * @param Equipment $equipment Equipment
     *
     * @return string
     *
     * @since 1.0.0
     */
    private function createEquipmentDir(Equipment $equipment) : string
    {
        return '/Modules/EquipmentManagement/Equipment/'
            . $this->app->unitId . '/'
            . $equipment->id;
    }

    /**
     * Method to validate bill creation from request
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @since 1.0.0
     */
    private function validateMediaAddToEquipment(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['media'] = (!$request->hasData('media') && empty($request->files)))
            || ($val['equipment'] = !$request->hasData('equipment'))
        ) {
            return $val;
        }

        return [];
    }

    /**
     * Api method to create notes
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
    public function apiNoteCreate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        if (!empty($val = $this->validateNoteCreate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidCreateResponse($request, $response, $val);

            return;
        }

        $request->setData('virtualpath', '/Modules/EquipmentManagement/Equipment/' . $request->getData('ref'), true);
        $this->app->moduleManager->get('Editor', 'Api')->apiEditorCreate($request, $response, $data);

        if ($response->header->status !== RequestStatusCode::R_200) {
            return;
        }

        $responseData = $response->getDataArray($request->uri->__toString());
        if (!\is_array($responseData)) {
            return;
        }

        $model = $responseData['response'];
        $this->createModelRelation($request->header->account, (int) $request->getData('ref'), $model->id, EquipmentMapper::class, 'notes', '', $request->getOrigin());
    }

    /**
     * Validate note create request
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @since 1.0.0
     */
    private function validateNoteCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['ref'] = !$request->hasData('ref'))
        ) {
            return $val;
        }

        return [];
    }

    /**
     * Api method to update Equipment
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
    public function apiEquipmentFind(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
    }

    /**
     * Api method to update Equipment
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
    public function apiEquipmentUpdate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        if (!empty($val = $this->validateEquipmentUpdate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidUpdateResponse($request, $response, $val);

            return;
        }

        /** @var \Modules\EquipmentManagement\Models\Equipment $old */
        $old = EquipmentMapper::get()->where('id', (int) $request->getData('id'))->execute();
        $new = $this->updateEquipmentFromRequest($request, clone $old);

        $this->updateModel($request->header->account, $old, $new, EquipmentMapper::class, 'equipment', $request->getOrigin());
        $this->createStandardUpdateResponse($request, $response, $new);
    }

    /**
     * Method to update Equipment from request.
     *
     * @param RequestAbstract $request Request
     * @param Equipment       $new     Model to modify
     *
     * @return Equipment
     *
     * @todo Implement API update function
     *
     * @since 1.0.0
     */
    public function updateEquipmentFromRequest(RequestAbstract $request, Equipment $new) : Equipment
    {
        $new->name   = $request->getDataString('name') ?? $new->name;
        $new->info   = $request->getDataString('info') ?? $new->info;
        $new->type   = $request->hasData('type') ? new NullBaseStringL11nType((int) ($request->getDataInt('type') ?? 0)) : $new->type;
        $new->status = EquipmentStatus::tryFromValue($request->getDataInt('status')) ?? $new->status;
        $new->unit   = $request->getDataInt('unit') ?? $this->app->unitId;

        return $new;
    }

    /**
     * Validate Equipment update request
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @todo Implement API validation function
     *
     * @since 1.0.0
     */
    private function validateEquipmentUpdate(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['id'] = !$request->hasData('id'))) {
            return $val;
        }

        return [];
    }

    /**
     * Api method to delete Equipment
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
    public function apiEquipmentDelete(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        if (!empty($val = $this->validateEquipmentDelete($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidDeleteResponse($request, $response, $val);

            return;
        }

        /** @var \Modules\EquipmentManagement\Models\Equipment $equipment */
        $equipment = EquipmentMapper::get()->where('id', (int) $request->getData('id'))->execute();
        $this->deleteModel($request->header->account, $equipment, EquipmentMapper::class, 'equipment', $request->getOrigin());
        $this->createStandardDeleteResponse($request, $response, $equipment);
    }

    /**
     * Validate Equipment delete request
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @since 1.0.0
     */
    private function validateEquipmentDelete(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['id'] = !$request->hasData('id'))) {
            return $val;
        }

        return [];
    }

    /**
     * Api method to update Note
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
    public function apiNoteUpdate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        $accountId = $request->header->account;
        if (!$this->app->accountManager->get($accountId)->hasPermission(
            PermissionType::MODIFY, $this->app->unitId, $this->app->appId, self::NAME, PermissionCategory::EQUIPMENT_NOTE, $request->getDataInt('id'))
        ) {
            $this->fillJsonResponse($request, $response, NotificationLevel::HIDDEN, '', '', []);
            $response->header->status = RequestStatusCode::R_403;

            return;
        }

        $this->app->moduleManager->get('Editor', 'Api')->apiEditorUpdate($request, $response, $data);
    }

    /**
     * Api method to delete Note
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
    public function apiNoteDelete(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        $accountId = $request->header->account;
        if (!$this->app->accountManager->get($accountId)->hasPermission(
            PermissionType::DELETE, $this->app->unitId, $this->app->appId, self::NAME, PermissionCategory::EQUIPMENT_NOTE, $request->getDataInt('id'))
        ) {
            $this->fillJsonResponse($request, $response, NotificationLevel::HIDDEN, '', '', []);
            $response->header->status = RequestStatusCode::R_403;

            return;
        }

        $this->app->moduleManager->get('Editor', 'Api')->apiEditorDelete($request, $response, $data);
    }
}
