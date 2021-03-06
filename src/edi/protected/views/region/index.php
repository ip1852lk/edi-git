<?php
/* @var $this RegionController
 * @var $model Region
 */

$cs = Yii::app()->clientScript;
$regionAdmin = Yii::app()->user->checkAccess('Region.*');
$regionCreate = Yii::app()->user->checkAccess('Region.Create');
$regionExport = Yii::app()->user->checkAccess('Region.Export');
// Title
$this->title = Yii::t('app', 'Regions');
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['workspaceLabel']) => array(Yii::app()->params['workspaceUrl']),
    Yii::t('app', 'Regions'),
);
// Menus
if ($regionCreate || $regionExport) {
    $this->menu = array_merge($this->menu, array(
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_LINK,
            'context' => 'success',
            'icon' => 'fa fa-plus-square fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Create') . '</span>',
            'url' => array('create'),
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'navbar-btn btn-sm',),
            'visible' => $regionCreate,
        ),
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'info',
            'icon' => 'fa fa-file-excel-o fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Export') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'region-export-btn navbar-btn btn-sm'),
            'visible' => $regionExport,
        ),
    ));
}
if ($regionAdmin) {
    $this->menu = array_merge($this->menu, array(
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'warning',
            'icon' => 'fa fa-filter fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Advanced Search') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'region-search-btn navbar-btn btn-sm'),
            'visible' => $regionAdmin,
        ),
    ));
}
if ($regionExport) {
    $cs->registerScript(__CLASS__ . 'region_export', "
        $('.region-export-btn').click(function(event) {
            $.fn.yiiGridView.update('region-grid', {
                data: $(this).serialize()+'&export=true',
                success: function(data) {
                if (data.status === '200') {
                    window.location.href = data.body;
                } else {
                    bootbox.dialog({
                            title: '".Yii::t('app', 'EXPORT ERROR')."',
                            message: '<span class=\"label label-danger\">ERROR '+data.status+'</span> '+data.body,
                            buttons: {
                        'close':{label:'".Yii::t('app', 'Close')."', className:'btn-default', },
                            }
                        });
                    }
                },
                error: function(XHR) {
                bootbox.dialog({
                        title: '".Yii::t('app', 'EXPORT ERROR')."',
                        message: '<span class=\"label label-danger\">".Yii::t('app', 'NETWORK ERROR')."</span> ".Yii::t('app', 'Please refresh this page and try again shortly.')."',
                        buttons: {
                    'close':{label:'".Yii::t('app', 'Close')."', className:'btn-default', },
                        }
                    });
                }
            });
            return false;
        });
    ");
}
if ($regionAdmin) {
    $cs->registerScript(__CLASS__ . 'region_search', "
        $('.region-search-btn, .region-search-close-btn').click(function(event) {
            if ($('.region-search-container').is(':visible')) {
                $('html, body').animate({ scrollTop: 0 }, 100);
                $('.region-search-container').slideUp('slow');
            } else {
                $('.region-search-container').slideDown('slow');
            }
            return false;
        });
        $('.region-search-form').submit(function(){
            $('#region-grid').yiiGridView('update', {
                data: $(this).serialize()
            });
            return false;
        });
    ");
    $this->renderPartial('//region/_search', array(
        'model' => $model,
    ));
}
// UIs
echo $this->renderPartial('//region/_grid', array(
    'model' => $model,
));

