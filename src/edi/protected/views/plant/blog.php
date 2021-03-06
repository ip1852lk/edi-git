<?php
/* @var $this PlantController
 * @var $model Plant
 */

$plantCreate = Yii::app()->user->checkAccess('Plant.Create');
// Title
$this->title = Yii::t('app', Yii::t('app', Yii::app()->params['plantDisplayLabel2']));
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['workspaceLabel']) => array(Yii::app()->params['workspaceUrl']),
    Yii::t('app', Yii::t('app', Yii::app()->params['plantDisplayLabel2'])),
);
// Menus
$this->menu = array(
    array(
        'class' => 'booster.widgets.TbButton',
        'buttonType' => TbButton::BUTTON_LINK,
        'context' => 'success',
        'icon' => 'fa fa-plus-square fa-lg',
        'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Create') . '</span>',
        'url' => array('create'),
        'encodeLabel' => false,
        'htmlOptions' => array('class' => 'navbar-btn btn-sm',),
        'visible' => $plantCreate,
    ),
);
// UIs
$this->widget('booster.widgets.TbListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '//plant/_blog',
    'template' => '{pager} {summary} {sorter} {items} {pager}',
    'emptyText' => Yii::t('app', 'There are no active items to display.'),
    'ajaxUpdate' => false,
    'pager' => array(
        'class' => 'booster.widgets.TbPager',
        'displayFirstAndLast' => true,
        'alignment' => TbPager::ALIGNMENT_CENTER,
        'maxButtonCount' => Yii::app()->params['pagerMaxButtonCount'],
        'prevPageLabel' => '&lt;',
        'nextPageLabel' => '&gt;',
        'firstPageLabel' => '&lt;&lt;',
        'lastPageLabel' => '&gt;&gt;',
     ),
));

