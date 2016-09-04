<?php
namespace tmukherjee13\aclplus\components;

use tmukherjee13\aclplus\models\Menu as MenuModel;
use Yii;
use yii\base\Component;

class Menu extends Component
{

    /**
     * Get menu by condition or return all menu
     * @param  Array|null $where
     * @return backend\modules\menu\models\Menu object
     * @author  Tarun Mukherjee (https://github.com/tmukherjee13)
     */

    public static function getMenu(array $where = null)
    {

        $menu = MenuModel::find();
            // ->joinWith('acls')
            // ->where(['user_id' => Yii::$app->user->id]);

        if ($where !== null) {
            $menu->andWhere($where);
        }

        return $menu->all();
    }

    /**
     * Returns the menu hierarchy
     * @return Array
     * @author  Tarun Mukherjee (https://github.com/tmukherjee13)
     */

    public static function getMenuHierarchy()
    {
        $menuItems = ['root' => []];
        $_menus    = self::getMenu();
        foreach ($_menus as $key => $_menu) {

            if ($_menu->parent == 0) {
                array_push($menuItems['root'], $_menu);
            } else {

                if (empty($menuItems[$_menu->parent])) {
                    $menuItems[$_menu->parent] = [];
                }

                array_push($menuItems[$_menu->parent], $_menu);
            }

            return $menuItems;

        }
    }

    /**
     * Prepares the menu to be rendered
     *
     * @method buildMenu
     * @return string
     * @author Tarun Mukherjee (https://github.com/tmukherjee13)
     */

    public static function buildMenu()
    {
        $parent_nodes = [];
        $parents      = (new \yii\db\Query())
            ->select(['p.id'])
            ->from('{{%menu}} p')
            ->join('INNER JOIN', '{{%menu}} c', 'p.id = c.parent')
            ->all();

        foreach ($parents as $key => $_parent) {
            array_push($parent_nodes, $_parent['id']);
        }

        $menuTree = self::getMenu(['parent' => null]);
        // $menuHtml = self::_buildMenu(); // modify to allow for unlimited nested menus
        $menuHtml = '<ul class="sidebar-menu">';

        $menuHtml .= '<li class="header">MAIN NAVIGATION</li>';

        foreach ($menuTree as $key => $_menu):
            $hasChild = in_array($_menu->id, $parent_nodes);
            $url      = Yii::$app->urlManager->createAbsoluteUrl($_menu->route);
            $menuHtml .= '<li class="' . (($_menu->route == Yii::$app->getRequest()->getPathInfo()) ? 'active' : '') . (($hasChild) ? 'treeview' : '') . '">';
            $menuHtml .= '<a href="' . ((!empty($_menu->route) && $_menu->route !== '#') ? $url : 'javascript:void(0);') . '">';
            $menuHtml .= '<i class="fa ' . $_menu->icon . '"></i> <span>' . Yii::t('app', $_menu->name) . '</span>';

            if ($hasChild) {
                $menuHtml .= '<i class="fa fa-angle-left pull-right"></i>';
            }

            $menuHtml .= '</a>';

            if ($hasChild) {

                $menuTree1 = MenuModel::find()->where(['parent' => $_menu->id])->orderby('order')->all();
                $menuTree1 = self::getMenu(['parent' => $_menu->id]);
                $menuHtml .= '<ul class="treeview-menu">';
                foreach ($menuTree1 as $key => $_menu):
                    $url1 = Yii::$app->urlManager->createAbsoluteUrl($_menu->route);
                    $menuHtml .= '<li class="' . (($_menu->route == Yii::$app->getRequest()->getPathInfo()) ? 'active' : '') . '">';
                    $menuHtml .= '<a href="' . $url1 . '">';
                    $menuHtml .= '<i class="fa ' . $_menu->icon  . '"></i> <span>' . Yii::t('app', $_menu->name) . '</span>';
                    $menuHtml .= '</a>';
                    $menuHtml .= '</li>';
                endforeach;
                $menuHtml .= '</ul>';
            }

            $menuHtml .= '</li>';
        endforeach;

        $menuHtml .= '</ul>';

        return $menuHtml;

    }

   /* public static function buildMenu()
    {
        $parent_nodes = [];
        $parents      = (new \yii\db\Query())
            ->select(['p.id'])
            ->from('{{%menu}} p')
            ->join('INNER JOIN', '{{%menu}} c', 'p.id = c.parent')
            ->all();

        foreach ($parents as $key => $_parent) {
            array_push($parent_nodes, $_parent['id']);
        }

        $menuTree = self::getMenu(['parent' => null]);
        // $menuHtml = self::_buildMenu(); // modify to allow for unlimited nested menus
        $menuHtml = '<ul class="sidebar-menu">';

        $menuHtml .= '<li class="header">MAIN NAVIGATION</li>';

        foreach ($menuTree as $key => $_menu):
            $hasChild = in_array($_menu->id, $parent_nodes);
            $url      = Yii::$app->urlManager->createAbsoluteUrl($_menu->url_key);
            $menuHtml .= '<li class="' . (($_menu->url_key == Yii::$app->getRequest()->getPathInfo()) ? 'active' : '') . (($hasChild) ? 'treeview' : '') . '">';
            $menuHtml .= '<a href="' . ((!empty($_menu->url_key) && $_menu->url_key !== '#') ? $url : 'javascript:void(0);') . '">';
            $menuHtml .= '<i class="fa ' . $_menu->icon . '"></i> <span>' . Yii::t('app', $_menu->name) . '</span>';

            if ($hasChild) {
                $menuHtml .= '<i class="fa fa-angle-left pull-right"></i>';
            }

            $menuHtml .= '</a>';

            if ($hasChild) {

                $menuTree1 = MenuModel::find()->where(['parent' => $_menu->id])->orderby('sort_order')->all();
                $menuTree1 = self::getMenu(['parent' => $_menu->id]);
                $menuHtml .= '<ul class="treeview-menu">';
                foreach ($menuTree1 as $key => $_menu):
                    $url1 = Yii::$app->urlManager->createAbsoluteUrl($_menu->url_key);
                    $menuHtml .= '<li class="' . (($_menu->url_key == Yii::$app->getRequest()->getPathInfo()) ? 'active' : '') . '">';
                    $menuHtml .= '<a href="' . $url1 . '">';
                    $menuHtml .= '<i class="fa ' . $_menu->icon . '"></i> <span>' . Yii::t('app', $_menu->name) . '</span>';
                    $menuHtml .= '</a>';
                    $menuHtml .= '</li>';
                endforeach;
                $menuHtml .= '</ul>';
            }

            $menuHtml .= '</li>';
        endforeach;

        $menuHtml .= '</ul>';

        return $menuHtml;

    }*/

    public static function _buildMenu($parent = 0)
    {

        $tree = MenuModel::find()->where(['parent' => $parent])->orderby('sort_order')->all();
        $html = '';

        foreach ($tree as $key => $menu) {
            if ($menu->parent != 0) {
                $html .= self::_buildMenu($menu->parent);
            }

        }

        return $html;
    }

}
