<?php

namespace tmukherjee13\aclplus\models;

use Yii;

use backend\modules\acl\models\Acl;

/**
 * This is the model class for table "{{%menu}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $route
 * @property integer $parent
 * @property integer $order
 * @property integer $status
 * @property string $icon
 *
 * @property Acl[] $acls
 * @property SiteMenu[] $siteMenus
 * @property Site[] $sites
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%menu}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['parent', 'order', 'status'], 'integer'],
            [['name', 'route'], 'string', 'max' => 45],
            [['icon','data'], 'string', 'max' => 255],
            [['data'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'route' => Yii::t('app', 'Route'),
            'parent' => Yii::t('app', 'Parent'),
            'order' => Yii::t('app', 'Sort Order'),
            'status' => Yii::t('app', 'Status'),
            'icon' => Yii::t('app', 'Icon'),
            'data' => Yii::t('app', 'Data'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAcls()
    {
        return $this->hasMany(Acl::className(), ['menu_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSiteMenus()
    {
        return $this->hasMany(SiteMenu::className(), ['menu_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSites()
    {
        return $this->hasMany(Site::className(), ['id' => 'site_id'])->viaTable('{{%site_menu}}', ['menu_id' => 'id']);
    }
}
