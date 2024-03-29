<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\ClientManagement
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

use Modules\EquipmentManagement\Models\EquipmentStatus;
use Modules\EquipmentManagement\Models\NullEquipment;
use Modules\Media\Models\NullMedia;
use phpOMS\Uri\UriFactory;

$countryCodes    = \phpOMS\Localization\ISO3166TwoEnum::getConstants();
$countries       = \phpOMS\Localization\ISO3166NameEnum::getConstants();
$equipmentStatus = EquipmentStatus::getConstants();

/**
 * @var \Modules\EquipmentManagement\Models\Equipment $equipment
 */
$equipment      = $this->data['equipment'] ?? new NullEquipment();
$equipmentImage = $this->data['equipmentImage'] ?? new NullMedia();
$equipmentTypes = $this->data['types'] ?? [];

$isNew = $equipment->id === 0;

/**
 * @var \phpOMS\Views\View $this
 */
echo $this->data['nav']->render();
?>
<div class="tabview tab-2">
    <div class="box">
        <ul class="tab-links">
            <li><label for="c-tab-1"><?= $this->getHtml('Profile'); ?></label>
            <li><label for="c-tab-2"><?= $this->getHtml('Attributes'); ?></label>
            <li><label for="c-tab-3"><?= $this->getHtml('Files'); ?></label>
            <li><label for="c-tab-4"><?= $this->getHtml('Notes'); ?></label>
            <li><label for="c-tab-5"><?= $this->getHtml('Inspections'); ?></label>
            <li><label for="c-tab-8"><?= $this->getHtml('Costs'); ?></label>
        </ul>
    </div>
    <div class="tab-content">
        <input type="radio" id="c-tab-1" name="tabular-2"<?= $this->request->uri->fragment === 'c-tab-1' ? ' checked' : ''; ?>>
        <div class="tab">
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <section class="portlet">
                        <div class="portlet-head"><?= $this->getHtml('Profile'); ?></div>
                        <div class="portlet-body">
                            <div class="form-group">
                                <label for="iEquipmentProfileName"><?= $this->getHtml('Name'); ?></label>
                                <input type="text" id="iEquipmentProfileName" name="name" value="<?= $this->printHtml($equipment->name); ?>">
                            </div>

                            <div class="form-group">
                                <label for="iEquipmentStatus"><?= $this->getHtml('Status'); ?></label>
                                <select id="iEquipmentStatus" name="equipment_status">
                                    <?php foreach ($equipmentStatus as $status) : ?>
                                        <option value="<?= $status; ?>"<?= $status === $equipment->status ? ' selected' : ''; ?>><?= $this->getHtml(':status' . $status); ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="iEquipmentEnd"><?= $this->getHtml('Type'); ?></label>
                                <select id="iEquipmentEnd" name="equipment_type">
                                    <?php foreach ($equipmentTypes as $type) : ?>
                                        <option value="<?= $type->id; ?>"<?= $equipment->type->id === $type->id ? ' selected' : ''; ?>><?= $this->printHtml($type->getL11n()); ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="iEquipmentMake"><?= $this->getHtml('Make'); ?></label>
                                <input type="text" id="iEquipmentMake" name="make" value="<?= $this->printHtml($equipment->getAttribute('maker')->value->getValue()); ?>">
                            </div>

                            <div class="form-group">
                                <label for="iEquipmentModel"><?= $this->getHtml('Model'); ?></label>
                                <input type="text" id="iEquipmentModel" name="equipment_model" value="<?= $this->printHtml($equipment->getAttribute('equipment_model')->value->getValue()); ?>">
                            </div>

                            <div class="form-group">
                                <label for="iEquipmentStart"><?= $this->getHtml('Start'); ?></label>
                                <input type="datetime-local" id="iEquipmentStart" name="ownership_start" value="<?= $equipment->getAttribute('ownership_start')->value->getValue()?->format('Y-m-d\TH:i') ?? $equipment->createdAt->format('Y-m-d\TH:i'); ?>">
                            </div>

                            <div class="form-group">
                                <label for="iEquipmentEnd"><?= $this->getHtml('End'); ?></label>
                                <input type="datetime-local" id="iEquipmentEnd" name="ownership_end" value="<?= $equipment->getAttribute('ownership_end')->value->getValue()?->format('Y-m-d\TH:i'); ?>">
                            </div>

                            <div class="form-group">
                                <label for="iEquipmentPrice"><?= $this->getHtml('PurchasePrice'); ?></label>
                                <input type="number" step="any" id="iEquipmentPrice" name="purchase_price" value="<?= $this->printHtml($equipment->getAttribute('purchase_price')->value->getValue()); ?>">
                            </div>

                            <div class="form-group">
                                <label for="iEquipmentPrice"><?= $this->getHtml('LeasingFee'); ?></label>
                                <input type="number" step="any" id="iEquipmentPrice" name="leasing_fee" value="<?= $this->printHtml($equipment->getAttribute('leasing_fee')->value->getValue()); ?>">
                            </div>
                        </div>
                        <div class="portlet-foot">
                            <?php if ($equipment->id === 0) : ?>
                                <input id="iCreateSubmit" type="Submit" value="<?= $this->getHtml('Create', '0', '0'); ?>">
                            <?php else : ?>
                                <input id="iSaveSubmit" type="Submit" value="<?= $this->getHtml('Save', '0', '0'); ?>">
                            <?php endif; ?>
                        </div>
                    </section>
                </div>

                <div class="col-xs-12 col-md-6">
                    <section class="portlet">
                        <div class="portlet-body">
                            <img width="100%" src="<?= $equipmentImage->id === 0
                                ? 'Web/Backend/img/logo_grey.png'
                                : UriFactory::build($equipmentImage->getPath()); ?>"></a>
                        </div>
                    </section>
                </div>
            </div>
        </div>

        <input type="radio" id="c-tab-2" name="tabular-2"<?= $this->request->uri->fragment === 'c-tab-2' ? ' checked' : ''; ?>>
        <div class="tab">
            <div class="row">
                <?= $this->data['attributeView']->render(
                    $equipment->attributes,
                    $this->data['attributeTypes'] ?? [],
                    $this->data['units'] ?? [],
                    '{/api}fleet/equipment/attribute?csrf={$CSRF}',
                    $equipment->id
                    );
                ?>
            </div>
        </div>

        <input type="radio" id="c-tab-3" name="tabular-2"<?= $this->request->uri->fragment === 'c-tab-3' ? ' checked' : ''; ?>>
        <div class="tab col-simple">
            <?= $this->data['media-upload']->render('equipment-file', 'files', '', $equipment->files); ?>
        </div>

        <input type="radio" id="c-tab-4" name="tabular-2"<?= $this->request->uri->fragment === 'c-tab-4' ? ' checked' : ''; ?>>
        <div class="tab">
            <?= $this->data['equipment-notes']->render('equipment-notes', '', $equipment->notes); ?>
        </div>

        <input type="radio" id="c-tab-5" name="tabular-2"<?= $this->request->uri->fragment === 'c-tab-5' ? ' checked' : ''; ?>>
        <div class="tab">
            <div class="row">
                <a class="button" href="<?= UriFactory::build('{/base}/fleet/inspection/create?equipment=' . $equipment->id); ?>"><?= $this->getHtml('Create', '0', '0'); ?></a>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <section class="portlet">
                        <div class="portlet-head"><?= $this->getHtml('Upcoming'); ?></div>
                        <table id="upcomingInspections" class="default sticky">
                            <thead>
                                <tr>
                                    <td><?= $this->getHtml('Date'); ?>
                                    <td class="wf-100"><?= $this->getHtml('Type'); ?>
                                    <td><?= $this->getHtml('Responsible'); ?>
                            <tbody>
                            <?php foreach (($this->data['inspections'] ?? []) as $inspection) :
                                // @todo handle old inspections in the past? maybe use a status?!
                                if ($inspection->next === null) {
                                    continue;
                                }
                            ?>
                                <tr>
                                    <td><?= $inspection->next->format('Y-m-d H:i'); ?>
                                    <td><?= $this->printHtml($inspection->type->getL11n()); ?>
                                    <td>
                            <?php endforeach; ?>
                        </table>
                    </section>
                </div>

                <div class="col-xs-12 col-md-6">
                    <section class="portlet">
                        <div class="portlet-head"><?= $this->getHtml('History'); ?></div>
                        <table id="historicInspections" class="default sticky">
                            <thead>
                                <tr>
                                    <td><?= $this->getHtml('Date'); ?>
                                    <td class="wf-100"><?= $this->getHtml('Type'); ?>
                                    <td><?= $this->getHtml('Responsible'); ?>
                            <tbody>
                            <?php foreach (($this->data['inspections'] ?? []) as $inspection) : ?>
                                <tr>
                                    <td><?= $inspection->date->format('Y-m-d H:i'); ?>
                                    <td><?= $this->printHtml($inspection->type->getL11n()); ?>
                                    <td>
                            <?php endforeach; ?>
                        </table>
                    </section>
                </div>
            </div>
        </div>

        <input type="radio" id="c-tab-8" name="tabular-2"<?= $this->request->uri->fragment === 'c-tab-8' ? ' checked' : ''; ?>>
        <div class="tab">
            <div class="row">
                <div class="col-xs-12 col-md-6">
                </div>
            </div>
        </div>
    </div>
</div>