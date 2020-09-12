 <?php
 use yii\helpers\Url;
 use yii\widgets\Menu;
 ?>
 <!-- Left side column. contains the logo and sidebar -->
 <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
          <!-- sidebar menu: : style can be found in sidebar.less -->
<?php 



echo Menu::widget([
      'items'=>[
        [LABEL => '<i class="fa fa-dashboard"></i><span>Dashboard</span>', 'url' => ['site/index']],
        [LABEL => '<i class="fa fa-dashboard"></i><span>New Ticket</span>', 'url' => ['site/new-ticket']],
        [LABEL => '<i class="fa fa-dashboard"></i><span>Tickets</span>', 'url' => ['site/list-tickets']],
    ],

      

      'options' => [
        'class' => 'sidebar-menu',
        'data-widget' => 'tree',
      ],
    'submenuTemplate' => "\n<ul class='treeview-menu'>\n{items}\n</ul>\n",
      'activateItems' => true,
      'activateParents' => true,
      'activeCssClass' => ATTR_ACTIVE,
      'encodeLabels' => false,
      'labelTemplate' =>'{label}',
    'linkTemplate' => '<a href="{url}">{label}</a>'
]);

?>

        </section>
    <!-- /.sidebar -->
  </aside>
