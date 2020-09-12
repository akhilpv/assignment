<?php
use yii\widgets\Breadcrumbs;
?>
<section class="content-header">
  <h1>
 <?=isset($this->params['head']) ? $this->params['head'] : '';?>
  </h1>
  <?= Breadcrumbs::widget([
      'homeLink' => [ 
         'label' =>  '<i class="fa fa-dashboard"></i>Home',
         'url' => Yii::$app->homeUrl,
      ],
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            'encodeLabels' => false,
        ]) ?>
</section>