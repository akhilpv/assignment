<?php
use yii\helpers\Url;
if(!isset($fromCron)){
    $url = Url::base(true);
}
else {
    $url = Yii::getAlias('@cronBaseUrl');
}
$imageURL = $url . Yii::getAlias('@imagePath').'/';
?>
    <td>
    <table width="100%" bgcolor="#035ead">
        <tr>
        <td style="padding: 10px 0 10px 25px; color: #ffffff;"> <br />
        </td>
        <td align="right" style="padding: 0 25px 0 0">
            <!-- <a href="https://www.facebook.com"><img src="<?php //$imageURL?>fb.png" alt="" /></a>
            <a href="https://twitter.com" style="margin: 0 0 0 5px;"><img src="<?php //$imageURL?>twitter.png" alt="" /></a>
            <a href="https://www.instagram.com" style="margin: 0 0 0 5px;"><img src="<?php //$imageURL?>instagram.png" alt="" /></a> -->
        </td>
