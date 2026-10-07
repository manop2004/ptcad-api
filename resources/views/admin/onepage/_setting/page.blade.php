@extends('layouts.temp_admin')
@section('title'){{$title_page}}@endsection

@section('css')

<link rel="stylesheet" href="{{ asset('assets/backend/js/plugins/buttons.dataTables.min.css') }}">

@endsection

@section('content')

<div class="row">
</div>
<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
            <h4 class="card-title transform-capitalize">{{$title_page}}</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <a href="" class="btn">Menu</a>
                    <a href="{{ route('onepage.setting.banner',['page'=>$item->id]) }}" class="btn">Banner</a>
                    <a href="{{ route('onepage.setting.section',['page'=>$item->id]) }}" class="btn">Section</a>
                    {{-- <a href="{{ route('onepage.setting.tab',['page'=>$item->id,'section'=>'tab']) }}" class="btn">Tab</a> --}}
                    <a href="{{ route('onepage.setting.footer',['page'=>$item->id]) }}" class="btn">Footer</a>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-8"></div>
            </div>
        </div>
        <!-- end content-->
      </div>
      <!--  end card  -->
    </div>
</div>

@endsection

@section('js')

@endsection
