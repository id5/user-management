<?php

namespace webvimark\modules\UserManagement\controllers;

use webvimark\components\AdminDefaultController;
use Yii;
use webvimark\modules\UserManagement\models\User;
use webvimark\modules\UserManagement\models\search\UserSearch;
use yii\web\NotFoundHttpException;
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
		$model = new User(['scenario'=>'newInternalUser']);

		if ( $model->load(Yii::$app->request->post()) && $model->save() )
		{
			return $this->redirect(['view',	'id' => $model->id]);
		}

		return $this->renderIsAjax('create', compact('model'));
	}

	public function actionUpdate($id)
	{	
		$model = $this->findModel($id);
		
		if(!$model->isNewRecord){
			$model->scenario = 'updateUser';
		}

		if ( $model->load(Yii::$app->request->post()) AND $model->save())
		{	
			$redirect = $this->getRedirectPage('update', $model);

			return $redirect === false ? '' : $this->redirect($redirect);
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
			Yii::$app->session->setFlash('success',Yii::t('back', 'Password changed'));
			return $this->redirect(['view',	'id' => $model->id]);
		}

		if (Yii::$app->request->isPost)
			Yii::$app->session->setFlash('error',Yii::t('back', 'Failed to change password'));

		
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
