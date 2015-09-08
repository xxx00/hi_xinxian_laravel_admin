<?php

namespace App\Http\Controllers\Card;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\AdminController;

use App\Http\Requests\Card\OperatorRequest; //请求层
use App\Repositories\Card\OperatorRepository;  //模型仓库层

use App\Model\Card\Market;

class OperatorController extends AdminController
{

    protected $operator;

    public function __construct(OperatorRepository $operator)
    {
        parent::__construct();
        $this->operator = $operator;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $models = $this->operator->index();
        $data['operators'] = $models;

        return view('card.operator.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $data['markets'] = Market::all();
        return view('card.operator.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(OperatorRequest $request)
    {
        $postData = $request->all();  //获取请求过来的数据
        $user = $request->user();

        $model = $this->operator->store($postData,$user->id);  //使用仓库方法存储
        if ($model->id) {  //添加成功
            return redirect()->route('card.operator.index')->with('message', '成功提交！');
        } else {  //添加失败
            return redirect()->back()->withInput($request->input())->with('fail', '数据库操作返回异常！');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $model = $this->operator->edit($id);
        $data['data'] = $model;
        $data['markets'] = Market::all();
        return view('card.operator.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(OperatorRequest $request, $id)
    {
        $postData = $request->all();  //获取请求过来的数据
        $this->operator->update($id,$postData);  //使用仓库方法存储
        return redirect()->route('card.operator.index')->with('message', '修改成功！');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
