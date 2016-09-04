<?php

namespace tmukherjee13\aclplus\controllers;

use backend\modules\acl\models\Acl;
// use common\modules\user\models\User;
use tmukherjee13\aclplus\models\UserSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * AclController implements the CRUD actions for Acl model.
 */
class AclController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Acl models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel  = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Acl model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

        // if (($model = Acl::findOne(['user_id' => $id])) !== null) {
        // } else {
        //     $menus = $this->prepareMenus();
        // }

        $menus = $this->prepareMenus($id);
        return $this->render('view', [
            'menus' => $menus,
        ]);

    }

    /**
     * Assigns user to menus.
     * @param integer $id
     * @return mixed
     */
    public function actionAssign($id)
    {

        $menus      = Yii::$app->getRequest()->post('menus', []);
        $insertData = [];
        foreach ($menus as $key => $menu) {
            $insertData[] = [$id, $menu, 1];
        }

        Yii::$app->db->createCommand()
            ->batchInsert(Acl::tableName(), ['user_id', 'menu_id', 'status'],
                $insertData)
            ->execute();

        $model                           = new Acl();
        Yii::$app->getResponse()->format = 'json';
        return $this->prepareMenus($id);

    }

    /**
     * Assigns user to menus.
     * @param integer $id
     * @return mixed
     */
    public function actionRemove($id)
    {

        $menus      = Yii::$app->getRequest()->post('menus', []);
        $insertData = [];
        // foreach ($menus as $key => $menu) {
        //     $insertData[] = [$id, $menu, 1];
        // }

        Acl::deleteAll(['and', 'user_id = :user_id', ['in', 'menu_id', $menus]], [
            ':user_id' => $id,
        ]);

        // Acl::deleteAll('user_id = :user_id AND menu_id IN (:menu_id)', [':user_id' => $id, ':menu_id' => ['8','9','10']]);

        Yii::$app->getResponse()->format = 'json';
        return $this->prepareMenus($id);

    }

    /**
     * Finds the Acl model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Acl the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Acl::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function prepareMenus($id = null)
    {
        $exists   = [];
        $assigned = [];
        $allMenu  = Menu::find()->all();

        if ($id !== null) {

            $allAssigned = Acl::findAll(['user_id' => $id]);
            foreach ($allAssigned as $_assigned) {
                $exists[] = $_assigned->menu_id;
            }
        }

        $available = ArrayHelper::map($allMenu, 'id', 'name');

        foreach ($available as $key => $name) {
            if (in_array($key, $exists)) {
                unset($available[$key]);
                $assigned[$key] = $name;
            }
        }

        $menus = [
            'avaliable' => $available,
            'assigned'  => $assigned,
        ];
        return $menus;
    }
}
