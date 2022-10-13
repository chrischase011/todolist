@extends('layouts.app')

@section('content')
    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card bg-list">
                    <div class="card-header fw-bold">{{ __('Our Lists') }}</div>

                    <div class="card-body">
                        @if (count($posts) < 1)
                            <p class="text-center">No available list to show.</p>
                        @endif

                        @foreach ($posts as $post)
                            <div class="p-3 my-3 border row border-secondary">
                                <div class="col-md-12">
                                    <h3 class="text-center">{{ $post->title }}</h3>
                                </div>
                                <div class="col-md-12">
                                    <p class="text-center f-4">
                                        {{-- {!! nl2br($post->content) !!} --}}
                                        @php
                                            $url = '/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/';
                                            $string = preg_replace($url, '<a href="$0" target="_blank" title="$0">$0</a>', $post->content);
                                            echo nl2br($string);
                                        @endphp
                                    </p>
                                </div>
                                <div class="text-center col-md-6">
                                    <p class="fw-bold">Set Date:
                                        {{ $post->set_date ? date('F d, Y | h:i a', strtotime($post->set_date)) : 'To be set' }}
                                    </p>
                                </div>
                                <div class="text-center col-md-6">
                                    <p class="fw-bold">Is Date Done?: <span
                                            class="{{ $post->is_done != '' || $post->is_done != null ? 'text-success' : 'text-danger' }}">{{ $post->is_done != '' || $post->is_done != null ? 'Yes' : 'No' }}</span>
                                    </p>
                                </div>
                                <div class="my-2 col-md-12">
                                    <p class="text-center fw-bold f-4">Actions</p>
                                </div>
                                <div class="col-md-12 d-flex justify-content-center align-items-center">
                                    <button class="mx-1 btn btn-sm btn-warning" type="button" title="Edit"
                                        onclick="getList({{ $post->id }}, '{{ $post->title }}')"><i
                                            class="fa fa-pencil"></i></button>
                                    @if ($post->is_done == '' || $post->is_done == null || $post->is_done == 0)
                                        <button class="mx-1 btn btn-sm btn-success"
                                            onclick="markAsDone({{ $post->id }})" type="button"
                                            title="Mark as Done">Mark as
                                            Done</button>
                                    @else
                                        <button class="mx-1 btn btn-sm btn-primary"
                                            onclick="markAsNotDone({{ $post->id }})" type="button"
                                            title="Mark as Done">Mark as
                                            Not done</button>
                                    @endif
                                    <button class="mx-1 btn btn-sm btn-danger" onclick="deleteList({{ $post->id }})"
                                        type="button" title="Delete"><i class="fa fa-trash"></i></button>
                                </div>
                            </div>
                        @endforeach

                        <div class="container mt-5 d-flex justify-content-center">{{ $posts->links() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="editList" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit List for <span id="edit-title" class="fw-bold"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('pages.edit_list') }}" method="post">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <input type="hidden" id="id" name="id">
                        <div class="mb-3 row">
                            <label for="title" class="col-md-12">Title</label>
                            <div class="col-md-12">
                                <input type="text" name="title" id="title" value="{{ old('title') }}"
                                    class="form-control" required>
                            </div>
                        </div>
                        <div class="my-3 row">
                            <label for="content" class="col-md-12">Content</label>
                            <div class="col-md-12">
                                <textarea class="form-control" name="content" id="content" style="resize:none;" rows="10" required>{{ old('content') }}</textarea>
                            </div>
                        </div>
                        <div class="my-3 row">
                            <label for="set_date" class="col-md-12">Set Date</label>
                            <div class="col-md-12">
                                <input type="datetime-local" name="set_date" id="set_date" class="form-control"
                                    value="{{ old('set_date') }}">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
