<?php

class PostController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */

    public function accessRules()
    {
        return array(
            array('allow',  // allow all users to perform 'index' and 'view' actions
                'actions'=>array('index','view'),
                'users'=>array('@'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('create','update','delete','ajax'),
                'users'=>array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'=>array('admin'),
                'users'=>array('admin'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
    public function actionView()
    {
        $post=$this->loadModel();
        $this->render('view',array(
            'model'=>$post,
        ));
    }

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Post;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Post']))
		{
			$model->attributes=$_POST['Post'];
                $model->document=CUploadedFile::getInstance($model,'document');
            if($model->save())
            {
                $model->document->saveAs(Yii::app()->basePath.'/upload/'.$model->id.'_'.mb_convert_encoding($model->document,  "CP-1251", "UTF-8" ));
                $this->redirect(array('view','id'=>$model->id));
            }
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
        if(($model->author_id===Yii::app()->user->id) OR ("3"==Yii::app()->user->id))
        {
            if(isset($_POST['Post']))
            {
                $model->attributes=$_POST['Post'];
                    $model->document=CUploadedFile::getInstance($model,'document');
                if($model->save())
                    $model->document->saveAs(Yii::app()->basePath.'/upload/'.$model->id.'_'.mb_convert_encoding($model->document,  "CP-1251", "UTF-8" ));
                    $this->redirect(array('view','id'=>$model->id));
                $this->refresh();

            }
        }
        else
            throw new CHttpException(404,'Ошибка доступа. Обновлять Вы можете только свои документы!');

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
   // public $author_id;

	public function actionDelete($id)
	{
        $model=$this->loadModel();

        if(($model->author_id===Yii::app()->user->id) OR ("3"==Yii::app()->user->id))
        {
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
		else
            throw new CHttpException(404,'Ошибка доступа. Удалять Вы можете только свои документы!');
	}

	/**
	 * Lists all models.
	 */
    //(status='.Post::STATUS_DISCUSSED.' OR status='.Post::STATUS_FAMILIARIZING.') AND

    public function actionAjax()
    {
        if (Yii::app()->request->isAjaxRequest)

        {
            if (isset($_GET['id']) and ctype_digit($_GET['id']) and $_GET['id']!=0) {
                $dop_filter = 'AND status = '.$_GET['id'];
            } else {
                $dop_filter = '';
            }
            $criteria=new CDbCriteria(array(
                'condition'=>'(dostup = \''.Yii::app()->user->id.'\'
OR dostup LIKE \''.Yii::app()->user->id.',%\'
OR dostup LIKE \'%,'.Yii::app()->user->id.',%\'
OR dostup LIKE \'%,'.Yii::app()->user->id.'\')
'.$dop_filter,
                'order'=>'update_time DESC',
            ));

            $dataProvider=new CActiveDataProvider('Post', array(
                'pagination'=>array(
                    'pageSize'=>5,
                ),
                'criteria'=>$criteria,
            ));

             $this->widget('zii.widgets.CListView', array(
            'dataProvider'=>$dataProvider,
            'itemView'=>'_view',
            'template'=>"{items}\n{pager}",
        ));

        }
    }


    public function actionIndex()
    {
        $criteria=new CDbCriteria(array(
            'condition'=>'(dostup = \''.Yii::app()->user->id.'\'
OR dostup LIKE \''.Yii::app()->user->id.',%\'
OR dostup LIKE \'%,'.Yii::app()->user->id.',%\'
OR dostup LIKE \'%,'.Yii::app()->user->id.'\')
',
            'order'=>'update_time DESC',
        ));

        $dataProvider=new CActiveDataProvider('Post', array(
            'pagination'=>array(
                'pageSize'=>5,
            ),
            'criteria'=>$criteria,
        ));

        $this->render('index', array ('dataProvider'=> $dataProvider));
    }

	public function actionAdmin()
	{
        $model=new Post('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Post']))
			$model->attributes=$_GET['Post'];

        $this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Post the loaded model
	 * @throws CHttpException
	 */
    private $_model;

    public function loadModel()
    {
        if($this->_model===null)
        {
            if(isset($_GET['id']))
            {
                if(Yii::app()->user->isGuest)
                    throw new CHttpException(404,'Необходима авторизация.');
                else
                    $condition=' (dostup = \''.Yii::app()->user->id.'\'
OR dostup LIKE \''.Yii::app()->user->id.',%\'
OR dostup LIKE \'%,'.Yii::app()->user->id.',%\'
OR dostup LIKE \'%,'.Yii::app()->user->id.'\')';
                $this->_model=Post::model()->findByPk($_GET['id'], $condition);
            }
            if($this->_model===null)
                throw new CHttpException(404,'Запрашиваемая страница не существует.');
        }
        return $this->_model;
    }

	/**
	 * Performs the AJAX validation.
	 * @param Post $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='post-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
/*
    public function actionGetFile($fileName = NULL) {
        if ($fileName !== NULL) {
            // некоторая логика по обработке пути из url в путь до файла на сервере
            $currentFile ='Z:/home/newapp/www/docob/protected/upload/'.$this->id;

            if (is_file($currentFile)) {
                header("Content-Type: application/octet-stream");
                header("Accept-Ranges: bytes");
                header("Content-Length: " . filesize($currentFile));
                header("Content-Disposition: attachment; filename=" .$this->document);
                readfile($currentFile);
            };
        } else {
            $this->redirect('куда переправляем юзера в случае ошибки');
        };
    }
*/
}
