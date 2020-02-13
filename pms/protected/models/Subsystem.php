<?php

/**
 * This is the model class for table "subsystem".
 *
 * The followings are the available columns in table 'subsystem':
 * @property integer $subsystemID
 * @property string $subsysName
 * @property string $url
 * @property string $iconUrl
 */
class Subsystem extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Subsystem the static model class
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
		return 'subsystem';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('subsysName, url', 'required'),
			array('subsysName, url, iconUrl', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('subsystemID, subsysName, url, iconUrl', 'safe', 'on'=>'search'),
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
			'subsystemID' => 'Subsystem',
			'subsysName' => 'Subsystem Name',
			'url' => 'Url',
			'iconUrl' => 'Icon Url',
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

		$criteria->compare('subsystemID',$this->subsystemID);
		$criteria->compare('subsysName',$this->subsysName,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('iconUrl',$this->iconUrl,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
}