<?php

/**
 * This is the model class for table "car_model".
 *
 * The followings are the available columns in table 'car_model':
 * @property integer $id
 * @property integer $mark_id
 * @property string $name
 *
 * The followings are the available model relations:
 * @property CarMaintenance[] $carMaintenances
 * @property CarMod[] $carMods
 * @property CarMark $mark
 */
class CarModel extends CActiveRecord
{
	/**
    * @var integer ID записи
    * @soap
    */
   public $id;
   /**
    * @var string part name
    * @soap
    */
   public $name;
   
   /**
    * @var integer ID записи
    * @soap
    */
   public $mark_id;
   
   /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CarModel the static model class
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
		return 'car_model';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mark_id', 'numerical', 'integerOnly'=>true),
			array('name', 'required', 'message'=>'{attribute}: введите название'),
			array('name', 'length', 'max'=>20, 'message'=>'{attribute} не можеты быть длиннее {max} символов'),
         array('name', 'match', 'pattern'=>'/^[A-z0-9\- ]+$/', 'message'=>'{attribute} не соответствует формату'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, mark_id, name', 'safe', 'on'=>'search'),
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
			'CarMaintenance' => array(self::HAS_MANY, 'CarMaintenance', 'model_id'),
			'CarMod' => array(self::HAS_MANY, 'CarMod', 'model_id'),
			'CarMark' => array(self::BELONGS_TO, 'CarMark', 'mark_id'),
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
			'name' => 'Модель',
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
		$criteria->compare('name',$this->name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}