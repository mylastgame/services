<?php

/**
 * This is the model class for table "car_mod".
 *
 * The followings are the available columns in table 'car_mod':
 * @property integer $id
 * @property integer $model_id
 * @property string $name
 *
 * The followings are the available model relations:
 * @property CarMaintenance[] $carMaintenances
 * @property CarModel $model
 */
class CarMod extends CActiveRecord
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
   public $model_id;
   
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CarMod the static model class
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
		return 'car_mod';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('model_id, name', 'required'),
			array('model_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, model_id, name', 'safe', 'on'=>'search'),
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
			'CarMaintenance' => array(self::HAS_MANY, 'CarMaintenance', 'mod_id'),
         'CarMaintenance1' => array(self::HAS_ONE, 'CarMaintenance1', 'mod_id'),
			'CarModel' => array(self::BELONGS_TO, 'CarModel', 'model_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'model_id' => 'Model',
			'name' => 'Name',
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
		$criteria->compare('model_id',$this->model_id);
		$criteria->compare('name',$this->name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}