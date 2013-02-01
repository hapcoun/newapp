<?php

/**
 * This is the model class for table "tbl_post".
 *
 * The followings are the available columns in table 'tbl_post':
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $tags
 * @property integer $status
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $author_id
 *
 * The followings are the available model relations:
 * @property User $author
 */
class Post extends CActiveRecord
{
    const STATUS_DRAFT=1;
    const STATUS_DISCUSSED=2;
    const STATUS_FAMILIARIZING=3;
    const STATUS_ARCHIVED=4;

    public $document;
    public $dostup;

    public function afterFind() {
        $this->dostup=explode(',',$this->dostup);
    }
    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Post the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_post';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
    public function rules()
    {
        return array(
            array('title, content, status', 'required'),
            array('title', 'length', 'max'=>128),
            array('status', 'in', 'range'=>array(1,2,3,4)),
            array('dostup', 'required'),

            array('document','file','types'=>'doc,docx,xls,xlsx,odt,txt,pdf',
                'allowEmpty'=>false),

            array('title, status', 'safe', 'on'=>'search'),
        );
    }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'author' => array(self::BELONGS_TO, 'User', 'author_id'),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'content' => 'Content',
			'status' => 'Status',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'author_id' => 'Author',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('update_time',$this->update_time);
		$criteria->compare('author_id',$this->author_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getUrl()
    {
        return Yii::app()->createUrl('post/view', array(
            'id'=>$this->id,
            'title'=>$this->title,
        ));
    }

    protected function beforeSave()
    {
        if(parent::beforeSave())
        {
            if($this->isNewRecord)// && ($document=CUploadedFile::getInstance($this,'document')))
            {
                $this->dostup=Yii::app()->user->id.','.implode(',', $this->dostup);
                $this->create_time=$this->update_time=time();
                $this->author_id=Yii::app()->user->id;
                //$this->document=$document;
                //$this->document->saveAs(Yii::app()->basePath.'/upload/'.$this->create_time.'_'.mb_convert_encoding($this->document, "CP-1251", "UTF-8"));
            }
            else
            {
                $this->dostup=Yii::app()->user->id.','.implode(',', $this->dostup);
                $this->update_time=time();
                //$this->deleteDocument();
                //$this->document=$document;
                //$this->document->saveAs(Yii::app()->basePath.'/upload/'.$this->create_time.'_'.mb_convert_encoding($this->document,  "CP-1251", "UTF-8" ));
            }
            return true;
        }
        else
            return false;
    }

    protected function beforeDelete(){
        if(!parent::beforeDelete())
            return false;
        $this->deleteDocument();
        return true;
    }

    public function deleteDocument(){
        $documentPath=Yii::app()->basePath.'/upload/'.$this->id.'_'.mb_convert_encoding($this->document,  "CP-1251", "UTF-8" );
        if(is_file($documentPath))
            unlink($documentPath);
    }

}