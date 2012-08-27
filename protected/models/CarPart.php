<?php

/**
 * This is the model class for table "car_part".
 *
 * The followings are the available columns in table 'car_part':
 * @property integer $id
 * @property string $name
 * @property string $article
 * @property integer $brand_id
 *
 * The followings are the available model relations:
 * @property CarMaintenance[] $carMaintenances
 */
class CarPart extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CarPart the static model class
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
		return 'car_part';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, article', 'required'),
			array('name, article', 'length', 'max'=>255),
         array('name, article', 'match', 'pattern'=>'/^[^\'\"\/]+$/'),
         array('brand_id', 'numerical', 'integerOnly'=>true, 'message'=>'{attribute} не соответствует формату' ),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, article', 'safe', 'on'=>'search'),
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
			'CarMaintenance' => array(self::HAS_MANY, 'CarMaintenance', 'part_id'),
         'CarMaintenance1' => array(self::HAS_MANY, 'CarMaintenance1', 'part_id'),
         'CarMark'=>array(self::BELONGS_TO, 'CarMark', 'brand_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Название',
			'article' => 'Артикул',
         'brand_id'=>'Производитель'
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
		$criteria->compare('article',$this->article,true);
      $criteria->compare('brand_id',$this->brand_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}