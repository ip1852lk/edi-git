<?php
/* @var $this CustomerController
 * @var $model Customer
 */

$customerAdmin = Yii::app()->user->checkAccess('Customer.*');
$customerUpdate = Yii::app()->user->checkAccess('Customer.Update');
// UIs
$this->beginWidget('booster.widgets.TbPanel', array(
    'context' => 'info',
    'headerIcon' => 'fa fa-lg fa-users',
    'title' => $customerUpdate ? TbHtml::link(UHtml::markSearch($data, "cu1_code"), array("update", "id" => $data->id)) : $data->cu1_code,
));
$this->widget('booster.widgets.TbDetailView', array(
    'data' => $data,
    'attributes' => array(
        array(
            'name' => 'cu1_logo',
            'type' => 'image',
            'value' => isset($data->cu1_logo) && strlen($data->cu1_logo) > 0 ? $data->cu1_logo : Yii::app()->params['customerDefaultLogo'],
        ),
        array(
            'name' => 'cu1_code',
            'type' => 'raw',
            'value' => $customerUpdate ? TbHtml::link(UHtml::markSearch($data, "cu1_code"), array("update", "id" => $data->id)) : $data->cu1_code,
        ),
        'cu1_name',
        array(
            'name' => 'cu1_type',
            'value' => Customer::itemAlias("customerTypes", $data->cu1_type),
        ),
        'cu1_phone',
        'cu1_fax',
        array(
            'name' => 'cu1_url',
            'type' => 'url',
        ),
        array(
            'name' => 'mprofile_search',
            'value' => ($data->mprofile == null || $data->mprofile->first_name == null ? "" : $data->mprofile->first_name . " " . $data->mprofile->last_name),
            'visible' => $customerAdmin,
        ),
        array(
            'name' => 'modified_on',
            'value' => ($data->modified_on == "" || $data->modified_on == "0000-00-00 00:00:00" ? "" : Yii::app()->dateFormatter->formatDateTime($data->modified_on, "medium", "short")),
            'visible' => $customerAdmin,
        ),
    ),
));
$this->endWidget();
