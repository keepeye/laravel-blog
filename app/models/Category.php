<?php
use \Illuminate\Database\Eloquent\Collection;

class Category extends BaseModel {

    protected $guarded = array('id','deleted_at','created_at','updated_at');

    public static function boot()
    {
        parent::boot();
        self::observe(new CategoryObserver);
    }

    /**
     * 关联文章模型
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles()
    {
        return $this->hasMany('Article','cid');
    }

    /**
     * 生成树形列表
     * @return array
     */
    public static function getList()
    {
        $list = self::all()->toArray();
        if (!empty($list)) {
            $tree = App::make('ListTreeUtil',[$list]);
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
            $tree = App::make('ListTreeUtil',[$list]);
            if ($id == 0) {
                return $tree->getOffspring(0);
            } else {
                return $tree->getOffspring(0,$id);
            }

        } else {
            return [];
        }
    }


    //验证父分类合法性
    public function validateParent()
    {
        if ($this->parent == 0) {
            return true;
        }

        //创建分类时只验证final字段
        $parent = self::find($this->parent,['id','final']);

        //更新时验证是否后代分类
        if ($this->id != 0 and $list = self::all()->toArray()) {
            $tree = App::make('ListTreeUtil',[$list]);
            if ($tree->isOffspring($this->parent,$this->id)) {
                return false;
            }
        }

        return $parent && $parent->final == 0;
    }

    /**
     * 删除分类，覆盖父类方法
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
        $tree = App::make('ListTreeUtil',[$list]);

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

        //删除文档,不调用destroy是因为它会先查找，再逐个delete
        Article::whereIn('cid',$resolveIds)->delete();

        //删除分类
        return self::whereIn('id',$resolveIds)->delete();
    }

    /**
     * 前台导航
     * @return array
     */
    public static function getNavList()
    {
        return Cache::want('navList',0,function(){
            $list = self::all()->toArray();
            if (!empty($list)) {
                $tree = App::make('ListTreeUtil', [$list]);

                $navList = $tree->getChildren(0);//读取根分类

                foreach ($navList as &$parent) {
                    $parent['offSpring'] = $tree->getOffspring($parent['id']);
                }
            }
            return $navList;
        });

    }

}