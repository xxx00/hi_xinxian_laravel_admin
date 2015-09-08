<?php

namespace App\Repositories\Card;


use App\Repositories\BaseRepository;

use App\Model\Card\Market;

/**
 *  MarketRepository
 *
 * @author raoyc<youyadaojia@gmail.com>
 */
class MarketRepository extends BaseRepository
{

    /**
     * The Market instance.
     *
     * @var App\Model\Card\Market
     */
    protected $model;

    /**
     * Create a new MarketRepository instance.
     *
     * @param  App\Model\Card\Market $model
     * @return void
     */
    public function __construct(Market $model)
    {
        $this->model = $model;

    }

    /**
     * 创建或更新内容
     *
     * @param  App\Model\Card\Market $card
     * @param  array $inputs
     * @param  string|int $user_id
     * @return App\Model\Market
     */
    private function saveData($model, $inputs,  $user_id = '1')
    {
        $model->name   = e($inputs['name']);
        $model->address   = e($inputs['address']);
        $model->no   = e($inputs['no']);
        $model->promotion   = e($inputs['promotion']);

        if (array_key_exists('status', $inputs)) {
            $model->status = e($inputs['status']);
        }
        $model->save();
        return $model;
    }


    #********
    #* 资源 REST 相关的接口函数 START
    #********
    /**
     * 内容资源列表数据
     */
    public function index()
    {
        $model = $this->model->all();
        // $cards = City::with('childrenCities')->get();

        return $model;

    }

    /**
     * 存储内容
     *
     * @param  array $inputs
     * @param  string|int $user_id 管理用户id     *
     */
    public function store($inputs,$user_id = '1')
    {
        $model = new $this->model;
        $model = $this->saveData($model, $inputs, $user_id);
        return $model;
    }

    /**
     * 获取编辑的内容
     *
     * @param  int $id
     * @param  string $type 内容模型类型
     * @return Illuminate\Support\Collection
     */
    public function edit($id)
    {
        $model = $this->model->findOrFail($id);
        return $model;
    }

    /**
     * 更新内容
     *
     * @param  int $id
     * @param  array $inputs
     * @param  string $type 内容模型类型
     * @return void
     */
    public function update($id, $inputs)
    {
        $model = $this->model->findOrFail($id);
        $model = $this->saveData($model, $inputs);
    }

    /**
     * 删除内容
     *
     * @param  int $id
     * @param  string $type 内容模型类型
     * @return void
     */
    public function destroy($id)
    {
        $model = $this->model->findOrFail($id);
        $model->delete();
    }
    #********
    #* 资源 REST 相关的接口函数 END
    #********
}
