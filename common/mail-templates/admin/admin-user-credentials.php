<?php
use yii\helpers\Html; 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
            
            <tr>
              <td>
                <table width="600" align="center" bgcolor="#ffffff">
         
                  <tr>
                    <td>
                      <table width="566" align="center" bgcolor="#ffffff" style="padding: 35px 42px;">
                    
                        <tr>
                          <td style="font-size: 16px; font-weight: bold;">Hi <?= Html::encode($name) ?>,</td>
                        </tr>
                        <tr>
                          <td height="5"></td>
                        </tr>
                        <tr>
                          <td style="font-size: 14px; font-weight: 400; color: #000000; line-height: 22px;"><?= Html::encode($message) ?></td>
                        </tr>
                        <tr>
                          <td height="5"></td>
                        </tr>
                        <tr>
                          <td style="font-size: 14px; font-weight: 400; color: #000000; line-height: 22px;"><b>Username</b> : <?= Html::encode($username)?> </td>
                        </tr>
                        <tr>
                          <td style="font-size: 14px; font-weight: 400; color: #000000; line-height: 22px;"><b>Password</b> : <?= Html::encode($password)?> </td>
                        </tr>
                        <tr><td height="3"></td></tr>
                        <?php 
                        if (!empty($loginUrl)) {
                        ?>
                        <tr>
                          <td style="font-size: 14px; font-weight: 400; color: #000000; line-height: 22px;"><b>Login Url</b> : <?= Html::a($loginUrl, $loginUrl)?>  </td>
                        </tr>
                        <?php } ?>
                        
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td height="10"></td>
                  </tr>
                </table>
              </td>
            </tr>
        
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
