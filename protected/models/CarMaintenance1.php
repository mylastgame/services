<?php

/**
 * This is the model class for table "car_maintenance1".
 *
 * The followings are the available columns in table 'car_maintenance1':
 * @property string $id
 * @property integer $maintenance_interval
 * @property integer $number
 * @property integer $mark_id
 * @property integer $model_id
 * @property integer $mod_id
 */
class CarMaintenance1 extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CarMaintenance1 the static model class
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
		return 'car_maintenance1';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('maintenance_interval, number, mark_id, model_id, mod_id', 'numerical', 'integerOnly'=>true),
         array('maintenance_interval, number', 'numerical', 'max'=>30),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, maintenance_interval, number, mark_id, model_id, mod_id', 'safe', 'on'=>'search'),
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
			'CarMod' => array(self::BELONGS_TO, 'CarMod', 'mod_id'),
			'CarMark' => array(self::BELONGS_TO, 'CarMark', 'mark_id'),
			'CarModel' => array(self::BELONGS_TO, 'CarModel', 'model_id'),
			'MaintenancePart' => array(self::HAS_MANY, 'MaintenancePart', 'maintenance_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'maintenance_interval' => 'Интервал ТО',
			'number' => 'Количество ТО',
			'mark_id' => 'Mark',
			'model_id' => 'Model',
			'mod_id' => 'Mod',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('maintenance_interval',$this->maintenance_interval);
		$criteria->compare('number',$this->number);
		$criteria->compare('mark_id',$this->mark_id);
		$criteria->compare('model_id',$this->model_id);
		$criteria->compare('mod_id',$this->mod_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}