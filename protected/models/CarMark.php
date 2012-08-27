<?php

/**
 * This is the model class for table "car_mark".
 *
 * The followings are the available columns in table 'car_mark':
 * @property integer $id
 * @property string $name
 * @property integer $image_id
 * @property bool $car_brand
 * @property bool $part_brand
 *
 * The followings are the available model relations:
 * @property CarMaintenance[] $carMaintenances
 * @property CarModel[] $carModels
 */
class CarMark extends CActiveRecord
{   
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CarMark the static model class
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
		return 'car_mark';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required', 'message'=>'{attribute}: введите название марки'),
			array('name', 'length', 'max'=>20, 'message'=>'{attribute} не можеты быть длиннее символов'),
         array('name', 'match', 'pattern'=>'/^[A-z ]+$/', 'message'=>'{attribute} не соответствует формату'),
         array('image_id', 'numerical', 'integerOnly'=>true, 'message'=>'{attribute} не соответствует формату'),
         array('car_brand, part_brand', 'boolean', 'message'=>'{attribute} не соответствует формату'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, image_id, name', 'safe', 'on'=>'search'),
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
			'carMaintenance' => array(self::HAS_MANY, 'CarMaintenance', 'mark_id'),
			'carModel' => array(self::HAS_MANY, 'CarModel', 'mark_id'),
         'Image'=>array(self::BELONGS_TO, 'Image', 'image_id'),
         'CarPart' => array(self::HAS_MANY, 'CarPart', 'brand_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Марка',
         'image_id' => 'Image ID',
         'car_brand' => 'Производитель автомобилей',
         'part_brand' => 'Производитель запчастей'
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
		$criteria->compare('name',$this->name,true);
      $criteria->compare('image_id',$this->image_id,true);
      $criteria->compare('car_brand',$this->car_brand);
      $criteria->compare('part_brand',$this->part_brand);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
   
   public function scopes(){
      return array(
          'carBrand'=>array(
              'condition'=>'car_brand = true'
          ),
          'partBrand'=>array(
              'condition'=>'part_brand = 1'
          )
      );
   }
}