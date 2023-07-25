<?php

namespace webvimark\modules\UserManagement\controllers;

use webvimark\components\AdminDefaultController;
use Yii;
use webvimark\modules\UserManagement\models\User;
use webvimark\modules\UserManagement\models\search\UserSearch;
use yii\web\NotFoundHttpException;
use webvimark\modules\UserManagement\UserManagementModule;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends AdminDefaultController
{
	/**
	 * @var User
	 */
	public $modelClass = 'webvimark\modules\UserManagement\models\User';

	/**
	 * @var UserSearch
	 */
	public $modelSearchClass = 'webvimark\modules\UserManagement\models\search\UserSearch';

	/**
	 * @return mixed|string|\yii\web\Response
	 */
	public function actionCreate()
	{
		$model = new User(['scenario'=>'newUser']);

		if ( $model->load(Yii::$app->request->post()) && $model->save() )
		{
			return $this->redirect(['view',	'id' => $model->id]);
		}

		return $this->renderIsAjax('create', compact('model'));
	}

	public function actionUpdate($id)
	{
		$model = User::findOne($id);
		
		$post = Yii::$app->request->post();
		if($post){
			$model->load($post);
			!empty($post['User']['password']) ? $model->setPassword($post['User']['password']) : '';
			if($model->update()){
				Yii::$app->session->setFlash('success', UserManagementModule::t('back', 'Dados atualizados com sucesso!'));
				return $this->redirect(['update', 'id' => $model->id]);
			}else{
				Yii::$app->session->setFlash('danger', 'Erro ao atualizar dados!');
				return $this->redirect(['update', 'id' => $model->id]);
			}
		}

		return $this->renderIsAjax('update', compact('model'));
	}

	/**
	 * @param int $id User ID
	 *
	 * @throws \yii\web\NotFoundHttpException
	 * @return string
	 */
	public function actionChangePassword($id)
	{
		$model = User::findOne($id);

		if ( !$model )
		{
			throw new NotFoundHttpException('User not found');
		}

		$model->scenario = 'changePassword';

		if ( $model->load(Yii::$app->request->post()) && $model->save() )
		{
			Yii::$app->session->setFlash('success', UserManagementModule::t('back', 'Password changed'));
			return $this->redirect(['view',	'id' => $model->id]);
		}

		if (Yii::$app->request->isPost)
			Yii::$app->session->setFlash('error', UserManagementModule::t('back', 'Failed to change password'));

		
		return $this->renderIsAjax('changePassword', compact('model'));
	}

	public function actionGenerateAccessToken($userId)
    {
        if(User::generateAccessToken($userId)){
            Yii::$app->session->setFlash('success',Yii::t('app', 'Token successfully generated'));
        } else {
            Yii::$app->session->setFlash('error',Yii::t('app', 'Failed to generate Token'));
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

}
