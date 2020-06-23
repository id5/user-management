<?php
use yii\helpers\Html;
use yii\helpers\BaseUrl;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>" />
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>

    <?php
        $resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/user-management/auth/password-recovery-receive', 'token' => $user->confirmation_token]);
    ?>

    <div style="background-color:#ffffff; width: 600px; margin:0px auto;">
		<table cellpadding="0" cellspacing="0" width="100%">
			<tbody>			
				<tr>
					<td>
						<table cellpadding="0" cellspacing="0" width="100%" style="margin-bottom:5px">
							<tbody>
								<tr>
									<td style="text-align: center;">
										<?= Html::img(BaseUrl::to(\Yii::$app->urlManager->baseUrl.'/imgs/logo_atual.png',true),['style'=>'display:block;']); ?>
									</td>
								</tr>
							</tbody>
						</table>	

						<table cellpadding="0" cellspacing="0" width="100%" style="border:solid 1px #ED1C24;">
							<tbody>
								<tr>
									<td style="padding:10px 20px; font-family: arial;">
										<?php $this->beginBody() ?>
										
                                        <p>Olá <b><?= Html::encode($user->username) ?></b>,</p> 
        
                                        <p>Você solicitou a atualização da sua senha de acesso ao WEBSAD.</p> 
                                        
                                        <p>Acesse o link abaixo para concluir: </p>

                                        <?= Html::a('Atualizar Senha', $resetLink) ?>

                                        <br/><br/>

										<?php $this->endBody() ?>
									</td>
								</tr>					
							</tbody>
						</table>

						<table cellpadding="0" cellspacing="0" width="100%">
							<tbody>
								<tr>
									<td style="padding:5px 0; font-family: arial; text-align: center; font-size: 12px;">
										<p>Este é um serviço de E-mail automático e não é necessário respondê-lo.</p>
										<p><strong>© <?= date("Y"); ?> Sococo S.A</strong></p>	
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>