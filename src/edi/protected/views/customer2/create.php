<?php 
/* @var $this Customer2Controller
 * @var $model Customer2
 * @var $customer Customer
 * @var $location Location
 * @var $region Region
 * @var $company Company
 * @var $contracts array
 */

// Title
$this->title = Yii::t('app', 'Sub-Customer');
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['workspaceLabel']) => array(Yii::app()->params['workspaceUrl']),
    Yii::t('app', 'Sub-Customers') => array('index'),
    Yii::t('app', 'Create'),
);
// Menus
if (isset($dependency) && isset($parentId)) {
    $this->menu = array_merge($this->menu, array(
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_LINK,
            'context' => 'warning',
            'icon' => 'fa fa-lg fa-angle-double-left',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Back') . '</span>',
            'url' => array(
                $dependency,
                'id' => (int)$parentId,
                'tabIndex' => isset($dependencyTabIndex)?$dependencyTabIndex:1,
                'tabDropdownIndex' => isset($dependencyTabDropdownIndex)?$dependencyTabDropdownIndex:0,
            ),
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'navbar-btn btn-sm',),
        ),
    ));
}
$this->menu = array_merge($this->menu, array(
    array(
        'class' => 'booster.widgets.TbButton',
        'buttonType' => TbButton::BUTTON_BUTTON,
        'context' => 'primary',
        'icon' => 'fa fa-save fa-lg',
        'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Save') . '</span>',
        'url' => '#',
        'encodeLabel' => false,
        'htmlOptions' => array('id' => 'customer2-create-save-btn', 'class' => 'navbar-btn btn-sm',),
    ),
));
// JavaScript files for dependency and relation
$cs = Yii::app()->clientScript;
$assetsScriptUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('zii.widgets.assets'));
$cs->registerScriptFile($assetsScriptUrl .'/gridview/jquery.yiigridview.js',CClientScript::POS_END);
$cs->registerScriptFile($this->assetsBase . '/js/relation.js');
$cs->registerCoreScript('bbq');
$booster = Yii::app()->booster;
$booster->registerPackage('bootbox');
$booster->registerPackage('datepicker');
$booster->registerAssetJs('jquery.stickytableheaders' . (!YII_DEBUG ? '.min' : '') . '.js');
// UIs
echo $this->renderPartial('//customer2/_form', array(
    'model' => $model,
    'customer' => $customer,
    'location' => $location,
    'region' => $region,
    'company' => $company,
    'contracts' => $contracts,
    'dependency' => (isset($dependency)?$dependency:null), 
    'dependencyTabIndex' => (isset($dependencyTabIndex)?$dependencyTabIndex:null), 
    'dependencyTabDropdownIndex' => (isset($dependencyTabDropdownIndex)?$dependencyTabDropdownIndex:null), 
    'parentPk' => (isset($parentPk)?$parentPk:null), 
    'parentId' => (isset($parentId)?$parentId:null), 
));
// Save Control
$cs->registerScript(__CLASS__ . 'customer2_form_save', '
    $("#customer2-create-save-btn").click(function(){
        $("#customer2-form-save-btn").trigger("click")
    });
');

