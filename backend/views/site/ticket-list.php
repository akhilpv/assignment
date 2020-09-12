<?php
use yii\helpers\Url;
use yii\widgets\LinkPager; 
use  yii\web\View; 
use yii\bootstrap\ActiveForm;
$this->title = 'Tickets';
Yii::$app->view->params['head'] = 'Tickets';
$this->params['breadcrumbs'][] =  'Tickets';

$clear_url = Url::to(["site/list-tickets"])
?>
<section class="content">
          <div class="row">    
<div class="col-md-12">
        <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Tickets </h3>
        </div>
        
        <div class="col-sm-12">
            <br>
            </div>
        
       
<!-- Alert Message -->
<?=Yii::$app->controller->renderpartial('@app/views/layouts/_alert_message')?>
<!-- //Alert Message -->
        <!-- /.box-header -->
        <div class="box-body">
            <table class="table table-bordered table-hover">
            <tbody>
            <tr>
                <th style="width: 10px">#</th>
                <th>Ticket Number</th>
                <th>Category</th>
                <th>Department </th>
                <th>Subject</th>
                <th>Status</th>
            </tr>
<?php
if(!empty($response)){
    $count = 0;	
    foreach ($response['data'] as $data=>$val) {
    ?>	
      <tr>
      <td><?=++$count?></td>
      <td><?=$val['ticketNumber']?></td>
      <td><?=$val['category']?></td>
      <td><?=$val['department']['name']?></td>
      <td><?=$val['subject']?></td>
      <td><?=$val['status']?></td>
      </tr> 
<?php
    }
}else{ ?>	
        
        <tr>
            <td colspan="6" class="text-center">Sorry! No record found.</td>
        </tr>	
            
<?php
} ?>	
            </tbody></table>
            </div>
        </div>
<!-- /.box-body -->
<!-- Pagination Start -->
    <!-- //Pagination End -->
</div>
        </div>
        <!-- /.box -->
        
        <!-- /.box -->
</section>
