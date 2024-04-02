<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\EquipmentManagement
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\EquipmentManagement\Controller;

use Modules\EquipmentManagement\Models\Attribute\EquipmentAttributeTypeL11nMapper;
use Modules\EquipmentManagement\Models\Attribute\EquipmentAttributeTypeMapper;
use Modules\EquipmentManagement\Models\Attribute\EquipmentAttributeValueL11nMapper;
use Modules\EquipmentManagement\Models\Attribute\EquipmentAttributeValueMapper;
use Modules\EquipmentManagement\Models\EquipmentMapper;
use Modules\EquipmentManagement\Models\EquipmentTypeMapper;
use Modules\EquipmentManagement\Models\InspectionMapper;
use Modules\EquipmentManagement\Models\InspectionTypeMapper;
use Modules\Media\Models\MediaMapper;
use Modules\Media\Models\MediaTypeMapper;
use Modules\Organization\Models\UnitMapper;
use phpOMS\Contract\RenderableInterface;
use phpOMS\DataStorage\Database\Query\Builder;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;
use phpOMS\Views\View;

/**
 * EquipmentManagement class.
 *
 * @package Modules\EquipmentManagement
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 * @codeCoverageIgnore
 */
final class BackendController extends Controller
{
    /**
     * Routing end-point for application behavior.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return RenderableInterface Returns a renderable object
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewEquipmentManagementAttributeTypeList(RequestAbstract $request, ResponseAbstract $response, array $data = []) : RenderableInterface
    {
        $view              = new \Modules\Attribute\Theme\Backend\Components\AttributeTypeListView($this->app->l11nManager, $request, $response);
        $view->data['nav'] = $this->app->moduleManager->get('Navigation')->createNavigationMid(1008405001, $request, $response);

        $view->attributes = EquipmentAttributeTypeMapper::getAll()
            ->with('l11n')
            ->where('l11n/language', $response->header->l11n->language)
            ->executeGetArray();

        $view->path = 'equipment';

        return $view;
    }

    /**
     * Routing end-point for application behavior.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return RenderableInterface Returns a renderable object
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewEquipmentManagementEquipmentList(RequestAbstract $request, ResponseAbstract $response, array $data = []) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);

        $view->setTemplate('/Modules/EquipmentManagement/Theme/Backend/equipment-list');
        $view->data['nav'] = $this->app->moduleManager->get('Navigation')->createNavigationMid(1008402001, $request, $response);

        $list = EquipmentMapper::getAll()
            ->with('type')
            ->with('type/l11n')
            ->where('type/l11n/language', $response->header->l11n->language)
            ->sort('id', 'DESC')
            ->executeGetArray();

        $view->data['equipments'] = $list;

        return $view;
    }

    /**
     * Routing end-point for application behavior.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewEquipmentManagementAttributeType(RequestAbstract $request, ResponseAbstract $response, array $data = []) : RenderableInterface
    {
        $view              = new \Modules\Attribute\Theme\Backend\Components\AttributeTypeView($this->app->l11nManager, $request, $response);
        $view->data['nav'] = $this->app->moduleManager->get('Navigation')->createNavigationMid(1008405001, $request, $response);

        $view->attribute = EquipmentAttributeTypeMapper::get()
            ->with('l11n')
            ->with('defaults')
            ->with('defaults/l11n')
            ->where('id', (int) $request->getData('id'))
            ->where('l11n/language', $response->header->l11n->language)
            ->where('defaults/l11n/language', [$response->header->l11n->language, null])
            ->execute();

        $view->l11ns = EquipmentAttributeTypeL11nMapper::getAll()
            ->where('ref', $view->attribute->id)
            ->executeGetArray();

        $view->path = 'fleet/vehicle';

        return $view;
    }

    /**
     * Routing end-point for application behavior.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewEquipmentManagementAttributeValue(RequestAbstract $request, ResponseAbstract $response, array $data = []) : RenderableInterface
    {
        $view              = new \Modules\Attribute\Theme\Backend\Components\AttributeValueView($this->app->l11nManager, $request, $response);
        $view->data['nav'] = $this->app->moduleManager->get('Navigation')->createNavigationMid(1008405001, $request, $response);

        $view->attribute = EquipmentAttributeValueMapper::get()
            ->with('l11n')
            ->where('id', (int) $request->getData('id'))
            ->where('l11n/language', [$response->header->l11n->language, null])
            ->execute();

        $view->l11ns = EquipmentAttributeValueL11nMapper::getAll()
            ->where('ref', $view->attribute->id)
            ->executeGetArray();

        // @todo Also find the ItemAttributeType

        return $view;
    }

    /**
     * Routing end-point for application behavior.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return RenderableInterface Returns a renderable object
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewEquipmentManagementEquipmentCreate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);

        $view->setTemplate('/Modules/EquipmentManagement/Theme/Backend/equipment-view');
        $view->data['nav'] = $this->app->moduleManager->get('Navigation')->createNavigationMid(1008402001, $request, $response);

        $view->data['attributeView']                               = new \Modules\Attribute\Theme\Backend\Components\AttributeView($this->app->l11nManager, $request, $response);
        $view->data['attributeView']->data['default_localization'] = $this->app->l11nServer;

        $view->data['media-upload']    = new \Modules\Media\Theme\Backend\Components\Upload\BaseView($this->app->l11nManager, $request, $response);
        $view->data['equipment-notes'] = new \Modules\Editor\Theme\Backend\Components\Compound\BaseView($this->app->l11nManager, $request, $response);

        return $view;
    }

    /**
     * Routing end-point for application behavior.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return RenderableInterface Returns a renderable object
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewEquipmentManagementEquipmentView(RequestAbstract $request, ResponseAbstract $response, array $data = []) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);

        $view->setTemplate('/Modules/EquipmentManagement/Theme/Backend/equipment-view');
        $view->data['nav'] = $this->app->moduleManager->get('Navigation')->createNavigationMid(1008402001, $request, $response);

        // @todo This langauge filtering doesn't work. But it was working with the old mappers. Maybe there is a bug in the where() definition. Need to inspect the actual query.
        $equipment = EquipmentMapper::get()
            ->with('attributes')
            ->with('attributes/type')
            ->with('attributes/value')
            ->with('attributes/type/l11n')
            //->with('attributes/value/l11n')
            ->with('files')
            ->with('files/types')
            ->with('type')
            ->with('type/l11n')
            ->with('fuelType')
            ->with('fuelType/l11n')
            ->where('id', (int) $request->getData('id'))
            ->where('type/l11n/language', $response->header->l11n->language)
            ->where('fuelType/l11n/language', $response->header->l11n->language)
            ->where('attributes/type/l11n/language', $response->header->l11n->language)
            //->where('attributes/value/l11n/language', $response->header->l11n->language)
            ->execute();

        $view->data['equipment'] = $equipment;

        $inspections = InspectionMapper::getAll()
            ->with('type')
            ->with('type/l11n')
            ->where('reference', $equipment->id)
            ->where('type/l11n/language', $response->header->l11n->language)
            ->executeGetArray();

        $view->data['inspections'] = $inspections;

        // @feature Create a new read mapper function that returns relation models instead of its own model
        //      https://github.com/Karaka-Management/phpOMS/issues/320
        $query   = new Builder($this->app->dbPool->get());
        $results = $query->selectAs(EquipmentMapper::HAS_MANY['files']['external'], 'file')
            ->from(EquipmentMapper::TABLE)
            ->leftJoin(EquipmentMapper::HAS_MANY['files']['table'])
                ->on(EquipmentMapper::HAS_MANY['files']['table'] . '.' . EquipmentMapper::HAS_MANY['files']['self'], '=', EquipmentMapper::TABLE . '.' . EquipmentMapper::PRIMARYFIELD)
            ->leftJoin(MediaMapper::TABLE)
                ->on(EquipmentMapper::HAS_MANY['files']['table'] . '.' . EquipmentMapper::HAS_MANY['files']['external'], '=', MediaMapper::TABLE . '.' . MediaMapper::PRIMARYFIELD)
             ->leftJoin(MediaMapper::HAS_MANY['types']['table'])
                ->on(MediaMapper::TABLE . '.' . MediaMapper::PRIMARYFIELD, '=', MediaMapper::HAS_MANY['types']['table'] . '.' . MediaMapper::HAS_MANY['types']['self'])
            ->leftJoin(MediaTypeMapper::TABLE)
                ->on(MediaMapper::HAS_MANY['types']['table'] . '.' . MediaMapper::HAS_MANY['types']['external'], '=', MediaTypeMapper::TABLE . '.' . MediaTypeMapper::PRIMARYFIELD)
            ->where(EquipmentMapper::HAS_MANY['files']['self'], '=', $equipment->id)
            ->where(MediaTypeMapper::TABLE . '.' . MediaTypeMapper::getColumnByMember('name'), '=', 'equipment_profile_image');

        $equipmentImage = MediaMapper::get()
            ->with('types')
            ->where('id', $results)
            ->limit(1)
            ->execute();

        $view->data['equipmentImage'] = $equipmentImage;

        $equipmentTypes = EquipmentTypeMapper::getAll()
            ->with('l11n')
            ->where('l11n/language', $response->header->l11n->language)
            ->executeGetArray();

        $view->data['types'] = $equipmentTypes;

        $units = UnitMapper::getAll()
            ->executeGetArray();

        $view->data['units'] = $units;

        $view->data['attributeView']                               = new \Modules\Attribute\Theme\Backend\Components\AttributeView($this->app->l11nManager, $request, $response);
        $view->data['attributeView']->data['default_localization'] = $this->app->l11nServer;

        $view->data['media-upload']    = new \Modules\Media\Theme\Backend\Components\Upload\BaseView($this->app->l11nManager, $request, $response);
        $view->data['equipment-notes'] = new \Modules\Editor\Theme\Backend\Components\Compound\BaseView($this->app->l11nManager, $request, $response);

        return $view;
    }

    /**
     * Routing end-point for application behavior.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return RenderableInterface Returns a renderable object
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewEquipmentManagementInspectionList(RequestAbstract $request, ResponseAbstract $response, array $data = []) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);

        $view->setTemplate('/Modules/EquipmentManagement/Theme/Backend/inspection-list');
        $view->data['nav'] = $this->app->moduleManager->get('Navigation')->createNavigationMid(1008404001, $request, $response);

        $view->data['inspections'] = InspectionMapper::getAll()
            ->sort('id', 'DESC')
            ->executeGetArray();

        return $view;
    }

    /**
     * Routing end-point for application behavior.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return RenderableInterface Returns a renderable object
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewEquipmentManagementInspectionTypeList(RequestAbstract $request, ResponseAbstract $response, array $data = []) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);

        $view->setTemplate('/Modules/EquipmentManagement/Theme/Backend/inspection-type-list');
        $view->data['nav'] = $this->app->moduleManager->get('Navigation')->createNavigationMid(1008401001, $request, $response);

        $list = InspectionTypeMapper::getAll()
            ->sort('id', 'DESC')
            ->executeGetArray();

        $view->data['inspections'] = $list;

        return $view;
    }
}
