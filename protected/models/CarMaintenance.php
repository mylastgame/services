<?php

/**
 * This is the model class for table "car_maintenance".
 *
 * The followings are the available columns in table 'car_maintenance':
 * @property integer $id
 * @property integer $mark_id
 * @property integer $model_id
 * @property integer $mod_id
 * @property string $order
 * @property integer $part_id
 * @property integer $amount
 * @property integer $distance
 * @property string $comment
 *
 * The followings are the available model relations:
 * @property CarMod $mod
 * @property CarMark $mark
 * @property CarModel $model
 * @property CarPart $part
 */
class CarMaintenance extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CarMaintenance the static model class
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
		return 'car_maintenance';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mark_id, model_id, mod_id, order, part_id, amount', 'required'),
			array('mark_id, model_id, mod_id, part_id, amount, distance', 'numerical', 'integerOnly'=>true),
			array('maintenance_order', 'length', 'max'=>3),
			array('comment', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, mark_id, model_id, mod_id, maintenance_order, part_id, amount, distance, comment', 'safe', 'on'=>'search'),
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
			'CarPart' => array(self::BELONGS_TO, 'CarPart', 'part_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'mark_id' => 'Mark',
			'model_id' => 'Model',
			'mod_id' => 'Mod',
			'maintenance_order' => 'MaintenanceOrder',
			'part_id' => 'Part',
			'amount' => 'Amount',
			'distance' => 'Distance',
			'comment' => 'Comment',
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
		$criteria->compare('mark_id',$this->mark_id);
		$criteria->compare('model_id',$this->model_id);
		$criteria->compare('mod_id',$this->mod_id);
		$criteria->compare('maintenance_order',$this->maintenance_order,true);
		$criteria->compare('part_id',$this->part_id);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('distance',$this->distance);
		$criteria->compare('comment',$this->comment,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}