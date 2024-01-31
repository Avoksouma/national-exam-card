@extends('layouts.dashboard')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('paper.index') }}">Past Paper</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Paper</li>
        </ol>
    </nav>
    <div class='d-flex justify-content-center align-items-center h-75'>
        <div class='text-center w-75'>
            <form action='{{ route('paper.update', $paper->id) }}' method='post' enctype="multipart/form-data">
                <h2 class='mb-3'>Edit paper details</h2>
                @include('components.message')
                <div class='row'>
                    <div class='col-md-4'>
                        <input class='form-control mb-3' name='name' placeholder='paper name'
                            value='{{ $paper->name }}' />
                    </div>
                    <div class='col-md-4'>
                        <select name="subject" class="form-select mb-3">
                            <option value="{{ $paper->subject_id }}">{{ $paper->subject->name }}</option>
                            @foreach ($subjects as $subject)
                                <option value='{{ $subject->id }}'>{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input class='form-control mb-3' name='document' type='file'
                            accept="image/*,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" />
                    </div>
                </div>
                <textarea id='editor' class='form-control' name='description' placeholder="write more details">
                    {{ $paper->description }}
                </textarea>
                @csrf @method('put')
                <div class='d-flex justify-content-between mt-3'>
                    <button type='submit' class='btn btn-primary rounded-pill w-10'>Submit</button>
                    <a href='{{ route('paper.index') }}' class='btn btn-outline-primary rounded-pill w-10'>
                        All papers
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="/js/ckeditor.js"></script>
    <script>
        ClassicEditor.create(document.querySelector("#editor"));
    </script>
@endsection
