
<?php if (Yii::$app->session->hasFlash('success')): ?>

    <div class="col-md-12">
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?= Yii::$app->session->getFlash('success') ?>
    </div>
    </div>

<?php endif; ?>

<?php if (Yii::$app->session->hasFlash('error')): ?>

 <div class="alert alert-danger alert-dismissable">
     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> 
     <?= Yii::$app->session->getFlash('error') ?> 
 </div>

<?php endif; ?>