@extends('layout._back')
@section('title') 产品管理 @stop
{{-- 高亮显示 --}}
{{--@section('sidebar_product')active @stop--}}

@section('content-header')
    <h1>
        产品管理
        <small>列表</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> 首页</a></li>
        <li class="active">产品列表</li>
    </ol>
@stop

@section('content')
    <a href="{{ route('admin.product.create') }}" class="btn btn-primary margin-bottom">添加新产品</a>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    @if(Session::has('message'))
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4>  <i class="icon fa fa-check"></i> 提示！</h4>
                            {{ Session::get('message') }}
                        </div>
                    @endif
                </div><!-- /.box-header -->


            <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>最后修改时间</th>
                       {{-- <th>ID</th>--}}
                        <th>分类</th>
                        <th>产品名称</th>
                        <th>产品价格</th>
                        <th>产品图片</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($products as $key => $li)
                    <tr>
                        <td>{{ $li -> updated_at }}</td>
                        {{--<td>{{ $li -> id }}</td>--}}
                        <td>{{ $li -> sort }}</td>
                        <td>{{ $li -> name }}</td>
                        <td class="text-green">{{ $li -> price }} 元</td>
                        <td><a href="{{ $li -> thumb }}">查看图片</a></td>
                        <td> <a href="{{ route('admin.product.index') }}/{{ $li->id }}/edit"><i class="fa fa-fw fa-pencil" title="修改"></i></a>  </td>
                    </tr>
                    @endforeach

                    </tbody>
                    <tfoot>
                    <tr>
                        <th>最后修改时间</th>
                        {{--<th>ID</th>--}}
                        <th>分类</th>
                        <th>产品名称</th>
                        <th>产品价格</th>
                        <th>产品图片</th>
                        <th>操作</th>
                    </tr>
                    </tfoot>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
@stop
@section('footer_js')
    <script type="text/javascript">
        $(function () {

            $('#example1').DataTable({
                "aaSorting": [[ 0, "desc" ]],
                /*  "paging": true,
                 "lengthChange": false,
                 "searching": false,
                 "ordering": true,*/
                "info": true,
                "autoWidth": false
            });
        });
    </script>
@stop