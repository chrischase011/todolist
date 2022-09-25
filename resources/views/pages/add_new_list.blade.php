@extends('layouts.app')
@section('title', 'Add new List - '.config('app.name', 'Laravel'))
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card bg-list">
                    <div class="card-header fw-bold">{{ __('Add New List') }}</div>
                    <div class="card-body">
                        <form action="{{route('pages.add_new_list')}}" method="post">
                            {{ csrf_field() }}
                            <div class="row my-3">
                                <label for="title" class="col-md-12">Title</label>
                                <div class="col-md-12">
                                    <input type="text" name="title" id="title" value="{{old('title')}}" class="form-control bg-list" required>
                                </div>
                            </div>
                            <div class="row my-3">
                                <label for="content" class="col-md-12">Content</label>
                                <div class="col-md-12">
                                    <textarea class="form-control bg-list" name="content" id="content" style="resize:none;" rows="10" required>{{old('content')}}</textarea>
                                </div>
                            </div>
                            <div class="row my-3">
                                <label for="set_date" class="col-md-12">Set Date</label>
                                <div class="col-md-12">
                                    <input type="date" name="set_date" id="set_date" class="form-control bg-list" value="{{old('set_date')}}">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg w-100">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection