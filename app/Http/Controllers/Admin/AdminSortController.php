<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\SortRequest; //请求层
use App\Repositories\SortRepository;  //模型仓库层

class AdminSortController extends AdminController
{
    protected $sort;

    public function __construct(SortRepository $sort)
    {
        parent::__construct();
        $this->sort = $sort;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $sorts = $this->sort->index();
        $data['sorts'] = $sorts;
        return view('admin.sort.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

        return view('admin.sort.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(SortRequest $request)
    {
        $postData = $request->all();  //获取请求过来的数据
        $user = $request->user();
        $sort = $this->sort->store($postData,$user->id);  //使用仓库方法存储
        if ($sort->id) {  //添加成功
            return redirect()->route('admin.sort.index')->with('message', '添加分类成功！');
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


        $sort = $this->sort->edit($id);
        $data['data'] = $sort;
//        dd($data);
        return view('admin.sort.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(SortRequest $request, $id)
    {
        $postData = $request->all();  //获取请求过来的数据
        $this->sort->update($id,$postData);  //使用仓库方法存储
        return redirect()->route('admin.sort.index')->with('message', '修改成功！');
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
