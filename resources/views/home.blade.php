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
                            <div class="row my-3 border border-secondary p-3">
                                <div class="col-md-12">
                                    <h3 class="text-center">{{ $post->title }}</h3>
                                </div>
                                <div class="col-md-12">
                                    <p class="text-center f-4">{{ $post->content }}</p>
                                </div>
                                <div class="col-md-6 text-center">
                                    <p class="fw-bold">Set Date: {{ $post->set_date ? date('F d, Y', strtotime($post->set_date)) : 'To be set' }}</p>
                                </div>
                                <div class="col-md-6 text-center">
                                    <p class="fw-bold">Is Date Done?: <span
                                            class="{{ $post->is_done != '' || $post->is_done != null ? 'text-success' : 'text-danger' }}">{{ $post->is_done != '' || $post->is_done != null ? 'Yes' : 'No' }}</span>
                                    </p>
                                </div>
                                <div class="col-md-12 my-2">
                                    <p class="text-center fw-bold f-4">Actions</p>
                                </div>
                                <div class="col-md-12 d-flex justify-content-center align-items-center">
                                    <button class="btn btn-sm btn-warning mx-1" type="button" title="Edit"
                                        onclick="getList({{ $post->id }}, '{{ $post->title }}')"><i
                                            class="fa fa-pencil"></i></button>
                                    @if($post->is_done == "" || $post == null)
                                        <button class="btn btn-sm btn-success mx-1" onclick="markAsDone({{$post->id}})" type="button" title="Mark as Done">Mark as
                                        Done</button>
                                    @else
                                        <button class="btn btn-sm btn-primary mx-1" onclick="markAsNotDone({{$post->id}})" type="button" title="Mark as Done">Mark as
                                            Not done</button>
                                    @endif
                                    <button class="btn btn-sm btn-danger mx-1" onclick="deleteList({{$post->id}})" type="button" title="Delete"><i
                                            class="fa fa-trash"></i></button>
                                </div>
                            </div>
                        @endforeach

                        <div class="container d-flex justify-content-center mt-5">{{$posts->links()}}</div>
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
                        <div class="row mb-3">
                            <label for="title" class="col-md-12">Title</label>
                            <div class="col-md-12">
                                <input type="text" name="title" id="title" value="{{ old('title') }}"
                                    class="form-control" required>
                            </div>
                        </div>
                        <div class="row my-3">
                            <label for="content" class="col-md-12">Content</label>
                            <div class="col-md-12">
                                <textarea class="form-control" name="content" id="content" style="resize:none;" rows="10" required>{{ old('content') }}</textarea>
                            </div>
                        </div>
                        <div class="row my-3">
                            <label for="set_date" class="col-md-12">Set Date</label>
                            <div class="col-md-12">
                                <input type="date" name="set_date" id="set_date" class="form-control"
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
    <script>
        function getList(id, title) {
            $("#edit-title").text(title);

            $.ajax({
                url: "{{ route('pages.get_list') }}",
                type: 'post',
                data: {
                    '_token': '{{ csrf_token() }}',
                    id: id
                },
                dataType: 'json',
                success: (data) => {
                    // $.each(data, (i, e) => {
                    //     console.log(e);
                    $("#title").val(data.title);
                    $("#content").val(data.content);
                    $("#set_date").val(data.set_date);
                    $("#id").val(data.id);
                    // });

                    $("#editList").modal('show');
                }
            });
        }

        function markAsDone(id)
        {
            $.ajax({
                url: "{{route('pages.mark_done')}}",
                type: 'post',
                data: {'_token':'{{csrf_token()}}', id:id},
                dataType: 'html',
                success: (data) => {
                    window.location.reload();
                }
            });
        }
        function markAsNotDone(id)
        {
            $.ajax({
                url: "{{route('pages.mark_not_done')}}",
                type: 'post',
                data: {'_token':'{{csrf_token()}}', id:id},
                dataType: 'html',
                success: (data) => {
                    window.location.reload();
                }
            });
        }

        function deleteList(id)
        {
            Swal.fire({
                title:'Delete List?',
                text: 'Are you sure you want to delete this list?',
                allowOutsideClick: false,
                allowEscapeKey: false,
                confirmButtonClass: "bg-danger",
                showCancelButton: true,
                cancelButtonClass: "bg-success"
            }).then((res) =>{
                if(res.isConfirmed)
                {
                    $.ajax({
                        url: "{{route('pages.delete_list')}}",
                        type: 'post',
                        data: {'_token':'{{csrf_token()}}', id:id},
                        dataType: 'html',
                        success: (data) =>{
                            window.location.reload();
                        }
                    });
                }
            });
        }
    </script>
@endsection
