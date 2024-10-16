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

use phpOMS\Uri\UriFactory;

/** @var \phpOMS\Views\View $this */
$equipments = $this->data['equipments'] ?? [];

echo $this->data['nav']->render(); ?>
<div class="row">
    <div class="col-xs-12">
        <section class="portlet">
            <div class="portlet-head"><?= $this->getHtml('Equipments'); ?><i class="g-icon download btn end-xs">download</i></div>
            <div class="slider">
            <table id="iEquipmentList" class="default sticky">
                <thead>
                <tr>
                    <td>
                    <td><?= $this->getHtml('ID', '0', '0'); ?>
                        <label for="iEquipmentList-sort-1">
                            <input type="radio" name="iEquipmentList-sort" id="iEquipmentList-sort-1">
                            <i class="sort-asc g-icon">expand_less</i>
                        </label>
                        <label for="iEquipmentList-sort-2">
                            <input type="radio" name="iEquipmentList-sort" id="iEquipmentList-sort-2">
                            <i class="sort-desc g-icon">expand_more</i>
                        </label>
                        <label>
                            <i class="filter g-icon">filter_alt</i>
                        </label>
                    <td><?= $this->getHtml('Status'); ?>
                        <label for="iEquipmentList-sort-3">
                            <input type="radio" name="iEquipmentList-sort" id="iEquipmentList-sort-3">
                            <i class="sort-asc g-icon">expand_less</i>
                        </label>
                        <label for="iEquipmentList-sort-4">
                            <input type="radio" name="iEquipmentList-sort" id="iEquipmentList-sort-4">
                            <i class="sort-desc g-icon">expand_more</i>
                        </label>
                        <label>
                            <i class="filter g-icon">filter_alt</i>
                        </label>
                    <td class="wf-100"><?= $this->getHtml('Name'); ?>
                        <label for="iEquipmentList-sort-5">
                            <input type="radio" name="iEquipmentList-sort" id="iEquipmentList-sort-5">
                            <i class="sort-asc g-icon">expand_less</i>
                        </label>
                        <label for="iEquipmentList-sort-6">
                            <input type="radio" name="iEquipmentList-sort" id="iEquipmentList-sort-6">
                            <i class="sort-desc g-icon">expand_more</i>
                        </label>
                        <label>
                            <i class="filter g-icon">filter_alt</i>
                        </label>
                    <td><?= $this->getHtml('Type'); ?>
                        <label for="iEquipmentList-sort-7">
                            <input type="radio" name="iEquipmentList-sort" id="iEquipmentList-sort-7">
                            <i class="sort-asc g-icon">expand_less</i>
                        </label>
                        <label for="iEquipmentList-sort-8">
                            <input type="radio" name="iEquipmentList-sort" id="iEquipmentList-sort-8">
                            <i class="sort-desc g-icon">expand_more</i>
                        </label>
                        <label>
                            <i class="filter g-icon">filter_alt</i>
                        </label>
                <tbody>
                <?php
                    $count = 0;
                    foreach ($equipments as $key => $value) :
                        ++$count;
                        $url = UriFactory::build('{/base}/equipment/equipment/view?{?}&id=' . $value->id);
                ?>
                <tr data-href="<?= $url; ?>">
                    <td>
                    <td data-label="<?= $this->getHtml('ID', '0', '0'); ?>"><a href="<?= $url; ?>"><?= $value->id; ?></a>
                    <td data-label="<?= $this->getHtml('Status'); ?>"><a href="<?= $url; ?>"><?= $this->getHtml(':status' . $value->status); ?></a>
                    <td data-label="<?= $this->getHtml('Name'); ?>"><a href="<?= $url; ?>"><?= $this->printHtml($value->name); ?></a>
                    <td data-label="<?= $this->getHtml('Type'); ?>"><a href="<?= $url; ?>"><?= $this->printHtml($value->type->getL11n()); ?></a>
                <?php endforeach; ?>
                <?php if ($count === 0) : ?>
                    <tr><td colspan="8" class="empty"><?= $this->getHtml('Empty', '0', '0'); ?>
                <?php endif; ?>
            </table>
            </div>
        </section>
    </div>
</div>
