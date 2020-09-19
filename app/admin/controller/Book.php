<?php

namespace app\admin\controller;
use app\admin\model\Book as bock;
use app\common\controller\Backend;
use think\Db;
/**
 * 预约审车管理
 *
 * @icon fa fa-book
 */
class Book extends Backend
{
    
    /**
     * Book模型对象
     * @var \app\admin\model\Book
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Book;
        $this->view->assign("categoryList", $this->model->getCategoryList());
        $this->view->assign("statusList", $this->model->getStatusList());
    }

    /**
     * 查看.
     */
    public function index()
    {
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax()) {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }
            [$where, $sort, $order, $offset, $limit] = $this->buildparams();
            $total = $this->model
                ->with(['user'])
                ->where($where)
                ->order($sort, $order)
                ->count();

            $list = $this->model
                ->with(['user'])
                ->where($where)
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();

            $list = $list->toArray();
            $result = ['total' => $total, 'rows' => $list];

            return json($result);
        }

        return $this->view->fetch();
    }
    
    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */
    
    public function order($ids){
        $bock = $this->model->with(['user'])->where('id',$ids)->find();
        $this->view->assign('bock',$bock);  
        return $this->view->fetch("ordex");
    }

}
