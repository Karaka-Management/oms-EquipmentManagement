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

use Modules\Admin\Models\NullAccount;
use Modules\EquipmentManagement\Models\InspectionTypeL11nMapper;
use Modules\EquipmentManagement\Models\InspectionTypeMapper;
use Modules\EquipmentManagement\Models\Equipment;
use Modules\EquipmentManagement\Models\EquipmentMapper;
use Modules\EquipmentManagement\Models\EquipmentStatus;
use Modules\EquipmentManagement\Models\EquipmentTypeL11nMapper;
use Modules\EquipmentManagement\Models\EquipmentTypeMapper;
use Modules\Media\Models\CollectionMapper;
use Modules\Media\Models\MediaMapper;
use Modules\Media\Models\NullMedia;
use Modules\Media\Models\PathSettings;
use Modules\Media\Models\Reference;
use Modules\Media\Models\ReferenceMapper;
use phpOMS\Localization\BaseStringL11n;
use phpOMS\Localization\BaseStringL11nType;
use phpOMS\Localization\ISO639x1Enum;
use phpOMS\Localization\NullBaseStringL11nType;
use phpOMS\Message\Http\RequestStatusCode;
use phpOMS\Message\NotificationLevel;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;
use phpOMS\Model\Message\FormValidation;

/**
 * EquipmentManagement class.
 *
 * @package Modules\EquipmentManagement
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
final class ApiEquipmentController extends Controller
{
    /**
     * Api method to create a equipment
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiEquipmentTypeCreate(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : void
    {
        if (!empty($val = $this->validateEquipmentTypeCreate($request))) {
            $response->data[$request->uri->__toString()] = new FormValidation($val);
            $response->header->status                    = RequestStatusCode::R_400;

            return;
        }

        /** @var BaseStringL11nType $equipment */
        $equipment = $this->createEquipmentTypeFromRequest($request);
        $this->createModel($request->header->account, $equipment, EquipmentTypeMapper::class, 'equipment_type', $request->getOrigin());

        $this->fillJsonResponse(
            $request,
            $response,
            NotificationLevel::OK,
            '',
            $this->app->l11nManager->getText($response->header->l11n->language, '0', '0', 'SucessfulCreate'),
            $equipment
        );
    }

    /**
     * Method to create equipment from request.
     *
     * @param RequestAbstract $request Request
     *
     * @return BaseStringL11nType Returns the created equipment from the request
     *
     * @since 1.0.0
     */
    public function createEquipmentTypeFromRequest(RequestAbstract $request) : BaseStringL11nType
    {
        $type        = new BaseStringL11nType();
        $type->title = $request->getDataString('name') ?? '';
        $type->setL11n($request->getDataString('title') ?? '', $request->getDataString('language') ?? ISO639x1Enum::_EN);

        return $type;
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
    private function validateEquipmentTypeCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['name'] = !$request->hasData('name'))
            || ($val['title'] = !$request->hasData('title'))
        ) {
            return $val;
        }

        return [];
    }

    /**
     * Api method to create equipment attribute l11n
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiEquipmentTypeL11nCreate(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : void
    {
        if (!empty($val = $this->validateEquipmentTypeL11nCreate($request))) {
            $response->data['equipment_type_l11n_create'] = new FormValidation($val);
            $response->header->status                   = RequestStatusCode::R_400;

            return;
        }

        $typeL11n = $this->createEquipmentTypeL11nFromRequest($request);
        $this->createModel($request->header->account, $typeL11n, EquipmentTypeL11nMapper::class, 'equipment_type_l11n', $request->getOrigin());
        $this->fillJsonResponse($request, $response, NotificationLevel::OK, 'Localization', 'Localization successfully created', $typeL11n);
    }

    /**
     * Method to create equipment attribute l11n from request.
     *
     * @param RequestAbstract $request Request
     *
     * @return BaseStringL11n
     *
     * @since 1.0.0
     */
    private function createEquipmentTypeL11nFromRequest(RequestAbstract $request) : BaseStringL11n
    {
        $typeL11n      = new BaseStringL11n();
        $typeL11n->ref = $request->getDataInt('type') ?? 0;
        $typeL11n->setLanguage(
            $request->getDataString('language') ?? $request->header->l11n->language
        );
        $typeL11n->content = $request->getDataString('title') ?? '';

        return $typeL11n;
    }

    /**
     * Validate equipment attribute l11n create request
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @since 1.0.0
     */
    private function validateEquipmentTypeL11nCreate(RequestAbstract $request) : array
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
     * Api method to create a equipment
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiEquipmentCreate(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : void
    {
        if (!empty($val = $this->validateEquipmentCreate($request))) {
            $response->data[$request->uri->__toString()] = new FormValidation($val);
            $response->header->status                    = RequestStatusCode::R_400;

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

        $this->fillJsonResponse(
            $request,
            $response,
            NotificationLevel::OK,
            '',
            $this->app->l11nManager->getText($response->header->l11n->language, '0', '0', 'SucessfulCreate'),
            $equipment
        );
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
        $equipment->type     = new NullBaseStringL11nType((int) ($request->getDataInt('type') ?? 0));
        $equipment->status   = (int) ($request->getDataInt('status') ?? EquipmentStatus::INACTIVE);
        $equipment->unit     = $request->getDataInt('unit') ?? $this->app->unitId;

        return $equipment;
    }

    /**
     * Create media files for equipment
     *
     * @param Equipment         $equipment Equipment
     * @param RequestAbstract $request Request incl. media do upload
     *
     * @return void
     *
     * @since 1.0.0
     */
    private function createEquipmentMedia(Equipment $equipment, RequestAbstract $request) : void
    {
        $path = $this->createEquipmentDir($equipment);

        if (!empty($uploadedFiles = $request->files)) {
            $uploaded = $this->app->moduleManager->get('Media')->uploadFiles(
                names: [],
                fileNames: [],
                files: $uploadedFiles,
                account: $request->header->account,
                basePath: __DIR__ . '/../../../Modules/Media/Files' . $path,
                virtualPath: $path,
                pathSettings: PathSettings::FILE_PATH
            );

            $collection = null;
            foreach ($uploaded as $media) {
                $this->createModelRelation(
                    $request->header->account,
                    $equipment->id,
                    $media->id,
                    EquipmentMapper::class,
                    'files',
                    '',
                    $request->getOrigin()
                );

                if ($collection === null) {
                    /** @var \Modules\Media\Models\Collection $collection */
                    $collection = MediaMapper::getParentCollection($path)->limit(1)->execute();

                    if ($collection->id === 0) {
                        $collection = $this->app->moduleManager->get('Media')->createRecursiveMediaCollection(
                            $path,
                            $request->header->account,
                            __DIR__ . '/../../../Modules/Media/Files' . $path
                        );
                    }
                }

                $this->createModelRelation(
                    $request->header->account,
                    $collection->id,
                    $media->id,
                    CollectionMapper::class,
                    'sources',
                    '',
                    $request->getOrigin()
                );
            }
        }

        if (!empty($mediaFiles = $request->getDataJson('media'))) {
            $collection = null;

            foreach ($mediaFiles as $file) {
                /** @var \Modules\Media\Models\Media $media */
                $media = MediaMapper::get()->where('id', (int) $file)->limit(1)->execute();

                $this->createModelRelation(
                    $request->header->account,
                    $equipment->id,
                    $media->id,
                    EquipmentMapper::class,
                    'files',
                    '',
                    $request->getOrigin()
                );

                $ref            = new Reference();
                $ref->name      = $media->name;
                $ref->source    = new NullMedia($media->id);
                $ref->createdBy = new NullAccount($request->header->account);
                $ref->setVirtualPath($path);

                $this->createModel($request->header->account, $ref, ReferenceMapper::class, 'media_reference', $request->getOrigin());

                if ($collection === null) {
                    /** @var \Modules\Media\Models\Collection $collection */
                    $collection = MediaMapper::getParentCollection($path)->limit(1)->execute();

                    if ($collection->id === 0) {
                        $collection = $this->app->moduleManager->get('Media')->createRecursiveMediaCollection(
                            $path,
                            $request->header->account,
                            __DIR__ . '/../../../Modules/Media/Files' . $path
                        );
                    }
                }

                $this->createModelRelation(
                    $request->header->account,
                    $collection->id,
                    $ref->id,
                    CollectionMapper::class,
                    'sources',
                    '',
                    $request->getOrigin()
                );
            }
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
     * @param mixed            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiMediaAddToEquipment(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : void
    {
        if (!empty($val = $this->validateMediaAddToEquipment($request))) {
            $response->data[$request->uri->__toString()] = new FormValidation($val);
            $response->header->status                    = RequestStatusCode::R_400;

            return;
        }

        /** @var \Modules\EquipmentManagement\Models\Equipment $equipment */
        $equipment = EquipmentMapper::get()->where('id', (int) $request->getData('equipment'))->execute();
        $path    = $this->createEquipmentDir($equipment);

        $uploaded = [];
        if (!empty($uploadedFiles = $request->files)) {
            $uploaded = $this->app->moduleManager->get('Media')->uploadFiles(
                names: [],
                fileNames: [],
                files: $uploadedFiles,
                account: $request->header->account,
                basePath: __DIR__ . '/../../../Modules/Media/Files' . $path,
                virtualPath: $path,
                pathSettings: PathSettings::FILE_PATH,
                hasAccountRelation: false,
                readContent: (bool) ($request->getData('parse_content') ?? false)
            );

            $collection = null;
            foreach ($uploaded as $media) {
                $this->createModelRelation(
                    $request->header->account,
                    $equipment->id,
                    $media->id,
                    EquipmentMapper::class,
                    'files',
                    '',
                    $request->getOrigin()
                );

                if ($request->hasData('type')) {
                    $this->createModelRelation(
                        $request->header->account,
                        $media->id,
                        $request->getDataInt('type'),
                        MediaMapper::class,
                        'types',
                        '',
                        $request->getOrigin()
                    );
                }

                if ($collection === null) {
                    /** @var \Modules\Media\Models\Collection $collection */
                    $collection = MediaMapper::getParentCollection($path)->limit(1)->execute();

                    if ($collection->id === 0) {
                        $collection = $this->app->moduleManager->get('Media')->createRecursiveMediaCollection(
                            $path,
                            $request->header->account,
                            __DIR__ . '/../../../Modules/Media/Files' . $path,
                        );
                    }
                }

                $this->createModelRelation(
                    $request->header->account,
                    $collection->id,
                    $media->id,
                    CollectionMapper::class,
                    'sources',
                    '',
                    $request->getOrigin()
                );
            }
        }

        if (!empty($mediaFiles = $request->getDataJson('media'))) {
            foreach ($mediaFiles as $media) {
                $this->createModelRelation(
                    $request->header->account,
                    $equipment->id,
                    (int) $media,
                    EquipmentMapper::class,
                    'files',
                    '',
                    $request->getOrigin()
                );
            }
        }

        $this->fillJsonResponse($request, $response, NotificationLevel::OK, 'Media', 'Media added to equipment.', [
            'upload' => $uploaded,
            'media'  => $mediaFiles,
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
     * Api method to create a equipment
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiInspectionTypeCreate(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : void
    {
        if (!empty($val = $this->validateInspectionTypeCreate($request))) {
            $response->data[$request->uri->__toString()] = new FormValidation($val);
            $response->header->status                    = RequestStatusCode::R_400;

            return;
        }

        /** @var BaseStringL11nType $inspection */
        $inspection = $this->createInspectionTypeFromRequest($request);
        $this->createModel($request->header->account, $inspection, InspectionTypeMapper::class, 'inspection_type', $request->getOrigin());

        $this->fillJsonResponse(
            $request,
            $response,
            NotificationLevel::OK,
            '',
            $this->app->l11nManager->getText($response->header->l11n->language, '0', '0', 'SucessfulCreate'),
            $inspection
        );
    }

    /**
     * Method to create equipment from request.
     *
     * @param RequestAbstract $request Request
     *
     * @return BaseStringL11nType Returns the created equipment from the request
     *
     * @since 1.0.0
     */
    public function createInspectionTypeFromRequest(RequestAbstract $request) : BaseStringL11nType
    {
        $type        = new BaseStringL11nType();
        $type->title = $request->getDataString('name') ?? '';
        $type->setL11n($request->getDataString('title') ?? '', $request->getDataString('language') ?? ISO639x1Enum::_EN);

        return $type;
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
    private function validateInspectionTypeCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['name'] = !$request->hasData('name'))
            || ($val['title'] = !$request->hasData('title'))
        ) {
            return $val;
        }

        return [];
    }

    /**
     * Api method to create equipment attribute l11n
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiInspectionTypeL11nCreate(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : void
    {
        if (!empty($val = $this->validateInspectionTypeL11nCreate($request))) {
            $response->data['inspection_type_l11n_create'] = new FormValidation($val);
            $response->header->status                      = RequestStatusCode::R_400;

            return;
        }

        $typeL11n = $this->createInspectionTypeL11nFromRequest($request);
        $this->createModel($request->header->account, $typeL11n, InspectionTypeL11nMapper::class, 'inspection_type_l11n', $request->getOrigin());
        $this->fillJsonResponse($request, $response, NotificationLevel::OK, 'Localization', 'Localization successfully created', $typeL11n);
    }

    /**
     * Method to create equipment attribute l11n from request.
     *
     * @param RequestAbstract $request Request
     *
     * @return BaseStringL11n
     *
     * @since 1.0.0
     */
    private function createInspectionTypeL11nFromRequest(RequestAbstract $request) : BaseStringL11n
    {
        $typeL11n      = new BaseStringL11n();
        $typeL11n->ref = $request->getDataInt('type') ?? 0;
        $typeL11n->setLanguage(
            $request->getDataString('language') ?? $request->header->l11n->language
        );
        $typeL11n->content = $request->getDataString('title') ?? '';

        return $typeL11n;
    }

    /**
     * Validate equipment attribute l11n create request
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
     * Api method to create notes
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiNoteCreate(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : void
    {
        if (!empty($val = $this->validateNoteCreate($request))) {
            $response->data['equipment_note_create'] = new FormValidation($val);
            $response->header->status              = RequestStatusCode::R_400;

            return;
        }

        $request->setData('virtualpath', '/Modules/EquipmentManagement/Equipment/' . $request->getData('id'), true);
        $this->app->moduleManager->get('Editor', 'Api')->apiEditorCreate($request, $response, $data);

        if ($response->header->status !== RequestStatusCode::R_200) {
            return;
        }

        $responseData = $response->get($request->uri->__toString());
        if (!\is_array($responseData)) {
            return;
        }

        $model = $responseData['response'];
        $this->createModelRelation($request->header->account, (int) $request->getData('id'), $model->id, EquipmentMapper::class, 'notes', '', $request->getOrigin());
    }

    /**
     * Validate item note create request
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
        if (($val['id'] = !$request->hasData('id'))
        ) {
            return $val;
        }

        return [];
    }

    /**
     * Api method to update note
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiNoteEdit(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : void
    {
        $this->app->moduleManager->get('Editor', 'Api')->apiEditorUpdate($request, $response, $data);

        if ($response->header->status !== RequestStatusCode::R_200) {
            return;
        }

        $responseData = $response->get($request->uri->__toString());
        if (!\is_array($responseData)) {
            return;
        }
    }
}
