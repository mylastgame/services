<?php

/**
 * This is the model class for table "maintenance_part".
 *
 * The followings are the available columns in table 'maintenance_part':
 * @property integer $id
 * @property integer $maintenance_id
 * @property integer $part_id
 * @property integer $amount
 * @property string $comment
 * @property string $maintenance_order
 */
class MaintenancePart extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MaintenancePart the static model class
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
		return 'maintenance_part';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('maintenance_id, part_id, amount', 'numerical', 'integerOnly'=>true, 'message'=>'{attribute} может быть только числом!'),
			array('maintenance_order', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, maintenance_id, part_id, amount, comment, maintenance_order', 'safe', 'on'=>'search'),
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
         'CarPart' => array(self::BELONGS_TO, 'CarPart', 'part_id'),
         'CarMaintenance1' => array(self::BELONGS_TO, 'CarMaintenance1', 'maintenance_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'maintenance_id' => 'Maintenance',
			'part_id' => 'Part',
			'amount' => 'Количество',
			'comment' => 'Комментарий',
			'maintenance_order' => 'Maintenance Order',
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
		$criteria->compare('maintenance_id',$this->maintenance_id);
		$criteria->compare('part_id',$this->part_id);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('maintenance_order',$this->maintenance_order,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}