<?php
namespace tmukherjee13\aclplus\controllers;

use Yii;
use yii\console\Controller;
use common\modules\user\models\User;

class AclController extends Controller
{
    public function actionInit()
    {

        if (!$this->confirm("Are you sure? It will re-create permissions tree.")) {
            return self::EXIT_CODE_NORMAL;
        }

        $auth = Yii::$app->authManager;
        $auth->removeAll();

        // add "createPost" permission
        $viewContent              = $auth->createPermission('viewContent');
        $viewContent->description = 'Can view Contents';
        $auth->add($viewContent);

        // add "createContent" permission
        $createContent              = $auth->createPermission('createContent');
        $createContent->description = 'Can create Contents';
        $auth->add($createContent);

        // add "createPost" permission
        $updateContent              = $auth->createPermission('updateContent');
        $updateContent->description = 'Can update Contents';
        $auth->add($updateContent);

        // add "createContent" permission
        $deleteContent              = $auth->createPermission('deleteContent');
        $deleteContent->description = 'Can delete Contents';
        $auth->add($deleteContent);

        




        // add "moderator" role and give this role the "viewContent" permission
        $moderator              = $auth->createRole('moderator');
        $moderator->description = 'Moderator Role';
        $auth->add($moderator);
        $auth->addChild($moderator, $viewContent);

        // add "admin" role and give this role the "createContent" permission
        // as well as the permissions of the "moderator" role
        $admin              = $auth->createRole('admin');
        $admin->description = 'Super Admin Role';
        $auth->add($admin);
        $auth->addChild($admin, $createContent);
        $auth->addChild($admin, $viewContent);
        $auth->addChild($admin, $updateContent);
        $auth->addChild($admin, $deleteContent);
        $auth->addChild($admin, $moderator);

        // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
        // $auth->assign($admin, 1);
    }

    public function actionAssign($role, $username)
    {
        $user = User::find()->where(['username' => $username])->one();
        if (!$user) {
            throw new InvalidParamException("There is no user \"$username\".");
        }

        $auth = Yii::$app->authManager;
        $role = $auth->getRole($role);
        if (!$role) {
            throw new InvalidParamException("There is no role \"$role\".");
        }

        $auth->assign($role, $user->id);
    }

    public function actionRevoke($role, $username)
    {
        $user = User::find()->where(['username' => $username])->one();
        if (!$user) {
            throw new InvalidParamException("There is no user \"$username\".");
        }

        $auth = Yii::$app->authManager;
        $role = $auth->getRole($role);
        if (!$role) {
            throw new InvalidParamException("There is no role \"$role\".");
        }

        $auth->revoke($role, $user->id);
    }
}
