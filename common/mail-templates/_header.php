<?php
use yii\helpers\Url;
if(!isset($fromCron)){
    $url = Url::base(true);
}
else {
    $url = Yii::getAlias('@cronBaseUrl');
}

$imageURL = $url .Yii::getAlias('@imagePath').'/';
?>
    <td align="center" style="border-top: 3px solid #ed1c24 ;">                             
                <img src="<?=$imageURL?>logo.png" ></td>