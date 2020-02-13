<?php

/**
 * This is the model class for table "degree_program".
 *
 * The followings are the available columns in table 'degree_program':
 * @property integer $id
 * @property string $degreeName
 * @property string $shortName
 * @property integer $duration
 */
class Degree extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Degree the static model class
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
		return 'degree_program';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('degreeName, shortName, duration', 'required'),
			array('duration', 'numerical', 'integerOnly'=>true),
			array('degreeName', 'length', 'max'=>255),
			array('shortName', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, degreeName, shortName, duration', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'degreeName' => 'Degree Name',
			'shortName' => 'Short Name',
			'duration' => 'Duration',
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
		$criteria->compare('degreeName',$this->degreeName,true);
		$criteria->compare('shortName',$this->shortName,true);
		$criteria->compare('duration',$this->duration);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}