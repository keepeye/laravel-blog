<?php
class Menu extends BaseModel {
    protected $guarded = ['id'];

    public static function navLinks()
    {
        $list = array();

        foreach (self::all()->toArray() as $menu) {
            $menu['children'] = array();

            if ($menu['name'] != '' and $menu['url'] == '') {
                $menu['url'] = URL::route($menu['name']);
            }

            $list[$menu['id']] = $menu;
        }

        $list[0] = array('children'=>array());

        foreach ($list as $k => &$menu) {
            if ($k == 0) {
                continue;
            }

            if ($menu['name'] != '' and !Sentry::getUser()->hasAccess($menu['name'])) {
                unset($list[$k]);
                continue;
            }

            $list[$menu['pid']]['children'][$menu['id']] = &$menu;
        }

        return $list[0]['children'];
    }


    public static function getList()
    {
        $list = self::all()->toArray();
        if (!empty($list)) {
            $tree = App::make('ListTreeUtil',[$list,array('parentKey'=>'pid')]);
            return $tree->getOffspring(0);
        } else {
            return [];
        }
    }

    /**
     * 生成表单中父分类下拉
     */
    public static function selectOptions($id=0)
    {
        $list = self::all()->toArray();
        if (!empty($list)) {
            $tree = App::make('ListTreeUtil',[$list,'options'=>array('parentKey'=>'pid')]);
            if ($id == 0) {
                return $tree->getOffspring(0);
            } else {
                return $tree->getOffspring(0,$id);
            }

        } else {
            return [];
        }
    }

    /**
     * 批量删除
     * @param array|int $ids
     * @return int|void
     */
    public static function destroy($ids)
    {
        if (empty($ids)) {
            return true;
        }
        //找出所有分类及其子分类id
        $list = self::all();
        if (empty($list)) {
            return true;
        }
        $tree = App::make('ListTreeUtil',[$list,'options'=>array('parentKey'=>'pid')]);

        //检测每个id是否合法并找出他们的所有后代id
        $resolveIds = array();
        foreach ($ids as $id) {
            if (in_array($id,$resolveIds) or !$tree->has($id)) {
                continue;
            }
            $resolveIds[] = $id;
            $resolveIds = array_merge($resolveIds,$tree->getOffspringIds($id));
        }

        if (empty($resolveIds)) {
            return true;
        }

        //批量删除
        return self::whereIn('id',$resolveIds)->delete();
    }
}