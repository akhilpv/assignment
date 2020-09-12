<?php
use yii\helpers\Html; 

$arrPackageInfo = array();
if(isset($params['packageDetails'])){
  $arrPackageInfo = json_decode($params['packageDetails'], true);
}

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head> 
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <style type="text/css"     >
      body {
        font-family: sans-serif;
        margin: 0;
        padding: 0;
        overflow-x: hidden;
        font-size: 14px;
        /* color: #8f8f8f; */
        color: #000000;
      }
        /* a {
          font-size: 14px;
          font-weight: bold;
          color: #ef4a4e;
          text-decoration: none;
        } */
    </style>
  </head>
  <body  style="background-color: #cccccc">    
    <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">     
      <tr>            
        <td align="center" height="15" valign="top">&nbsp;
        </td>
      </tr>    
      <tr>            
        <td align="center" valign="top">                
          <table border="0" cellpadding="0" cellspacing="0" width="650"  style="background-color: #ffffff">
            
                              
            <tr>                        
            <?=Yii::$app->controller->renderpartial('@common/mail-templates/_header')?>                
            </tr>
         
            <!-- Mail Content start-->
            <table width="600" align="center" bgcolor="#ffffff">
              <tr>
                <td style="font-size: 22px; text-align: center;"><b><?= @$params['emailTitle'] ?></b></td>
              </tr>
              <tr><td height="10"></td></tr>
              <tr>
                <td style="font-size: 14px; text-align: left;">Hi,</td>
              </tr>
              <tr><td height="4"></td></tr>
              <tr>
                <td style="font-size: 14px; text-align: left; line-height: 20px; color: #424242;"><?= @$params['content'] ?></td>
              </tr>
              <tr><td height="10"></td></tr>           
              <tr><td height="10"></td></tr>

              <tr>
                <td>
                  <table width="600" align="center" bgcolor="#ffffff">                
                    <tr>
                      <td>
                        <table style="width: 100%;" cellpadding="0" cellspacing="0">
                          <tr>
                            <td colspan="4" style="line-height: 22px;">
                              <b>
                                Date : <?= @$params['orderDate']; ?> <br />
                                Valid Till : <?= @$params['validTill']; ?>
                              </b>
                            </td>
                          </tr>
                          <tr>
                            <td colspan="4" height="10"></td>
                          </tr>
                          <tr>
                            <td style="padding: 4px 0;" colspan="2">Customer: <?= @$params['customer']; ?></td>
                            <td align="right" style="padding: 4px 0;" colspan="2">Order ID : #<?= @$params['orderId']; ?></td>
                          </tr>
                          <tr>
                            <td style="padding: 4px 0;" colspan="2">Email: <?= @$params['email']; ?></td>
                            <td align="right" style="padding: 4px 0;" colspan="2">Transaction ID: <?= @$params['transactionId']; ?></td>
                          </tr>
                          <tr>
                            <td style="padding: 4px 0;" colspan="2">Package: <?= @$arrPackageInfo['package_name']; ?></td>
                            <td align="right" style="padding: 4px 0;" colspan="2">Payment Type: <?= @$params['paymentType']; ?></td>
                          </tr>
                          <tr>
                            <td colspan="4" height="20"></td>
                          </tr>

                          <?php if(!empty($arrPackageInfo)){ ?>
                            <tr>
                              <th align="left" style="padding: 10px 10px; background: #f2f2f2;">Sl No</th>
                              <th align="left" style="padding: 10px 10px; background: #f2f2f2;">Publisher</th>
                              <th align="left" style="padding: 10px 10px; background: #f2f2f2;">Publications</th>
                              <th align="left" style="padding: 10px 10px; background: #f2f2f2;">Subtotal</th>
                            </tr>
                          <?php } ?>

                          </thead>
                          <tbody>
                          
                          <?php if(!empty($arrPackageInfo)){ 
                            $cnt = 1;
                            if(!empty($arrPackageInfo['sel_publications'])){
                              foreach($arrPackageInfo['sel_publications'] as $data){
                                ?><tr>
                                  <td style="padding: 10px 10px;"><?= $cnt++; ?></td>
                                  <td style="padding: 10px 10px;"><?= $data['publisher']; ?></td>
                                  <td style="padding: 10px 10px;"><?= $data['title']; ?></td>
                                  <td style="padding: 10px 10px;"><?= $data['amount']; ?></td>
                                </tr><?php 
                              } 
                            }

                            ?><tr><td height="10"></td></tr> 
                            <?php if(count($arrPackageInfo['sel_publications']) > 1){ ?>
                            <tr>
                              <td style="padding: 5px 10px;" colspan="3"><b>Subtotal:</b></td>
                              <td style="padding: 5px 10px;"><b><?= @number_format(($arrPackageInfo['total_amount']), 3, ".", "") + 0 ?></b></td>
                            </tr>
                            <?php } ?>
                            <tr>
                              <td style="padding: 5px 10px;" colspan="3"><b>Discount (<?=$arrPackageInfo['discount_percent']?>%)</b></td>
                              <td style="padding: 5px 10px;"><b><?= @number_format(($arrPackageInfo['discount']), 3, ".", "") + 0 ?></b></td>
                            </tr>
                            <tr>
                              <td style="padding: 5px 10px;" colspan="3"><b>Total:</b></td>
                              <td style="padding: 5px 10px;"><b><?= @number_format(($arrPackageInfo['total_after_discount']), 3, ".", "") + 0 ?></b></td>
                            </tr>
                          <?php } ?>
                          </tbody>
                      </table>
                      </td>
                    </tr>
                    <tr>
                      <td height="10"></td>
                    </tr>
                  </table>
                </td>
              </tr>
              <!-- Mail Content end -->
            </table>
            <tr>
              <?=Yii::$app->controller->renderpartial('@common/mail-templates/_footer')?>
            </tr>
                </table>
              </td>
            </tr>

            <tr>
              <td height="10"></td>
            </tr>
            <tr>
              <td align="center" style="color: #434343; font-size: 13px;">This message is generated automatically, please do not reply to this.</td>
            </tr>
            <tr>
              <td height="10"></td>
            </tr>
            <tr>                        
              <td align="center" valign="middle">                                            
               
              </td>                    
            </tr>               
            <tr><td height="10"></td></tr>
          </table>
        </td>
      </tr>
      <tr>            
        <td align="center" height="15" valign="top">&nbsp;
        </td>
      </tr>   
    </table>            
  </body>
</html>
