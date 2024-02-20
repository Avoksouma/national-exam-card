@extends('layouts.dashboard')
@section('content')
    <nav aria-label="breadcrumb" class='hide-me'>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Report</li>
        </ol>
    </nav>
    <div>
        <ul class="nav nav-tabs mb-3 hide-me" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                @if ($tab == 'year')
                    <button class="nav-link active" id="year-tab" data-bs-toggle="tab" data-bs-target="#year"
                        type="button" role="tab" aria-controls="year" aria-selected="true">Marks by Year</button>
                @else
                    <button class="nav-link" id="year-tab" data-bs-toggle="tab" data-bs-target="#year" type="button"
                        role="tab" aria-controls="year" aria-selected="false">Marks by Year</button>
                @endif
            </li>
            <li class="nav-item" role="presentation">
                @if ($tab == 'subject')
                    <button class="nav-link active" id="subject-tab" data-bs-toggle="tab" data-bs-target="#subject"
                        type="button" role="tab" aria-controls="subject" aria-selected="true">Marks by Subject</button>
                @else
                    <button class="nav-link" id="subject-tab" data-bs-toggle="tab" data-bs-target="#subject" type="button"
                        role="tab" aria-controls="subject" aria-selected="false">Marks by Subject</button>
                @endif
            </li>
            <li class="nav-item" role="presentation">
                @if ($tab == 'student')
                    <button class="nav-link active" id="student-tab" data-bs-toggle="tab" data-bs-target="#student"
                        type="button" role="tab" aria-controls="student" aria-selected="true">Marks by Student</button>
                @else
                    <button class="nav-link" id="student-tab" data-bs-toggle="tab" data-bs-target="#student" type="button"
                        role="tab" aria-controls="student" aria-selected="false">Marks by Student</button>
                @endif
            </li>
        </ul>
        <div class='hide-me float-end'>
            <button class='btn btn-info ms-4' onclick='printReport()'>
                <i class='bi bi-file-break'></i> PRINT
            </button>
        </div>
    </div>
    <div class="tab-content" id="myTabContent">
        @if ($tab == 'year')
            <div class="tab-pane fade show active" id="year" role="tabpanel" aria-labelledby="year-tab">
            @else
                <div class="tab-pane fade" id="year" role="tabpanel" aria-labelledby="year-tab">
        @endif
        <h2>Top Marks by Year</h2>
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Student</th>
                    <th scope="col">Subject</th>
                    <th scope="col">Marks</th>
                    <th scope="col">Year</th>
                    <th scope="col" class='hide-me'>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($topMarksByYear as $key => $mark)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $mark->student->name }}</td>
                        <td>{{ $mark->subject->name }}</td>
                        <td>{{ $mark->marks }}</td>
                        <td>{{ $mark->year }}</td>
                        <td class='hide-me'>
                            @if (in_array(Auth::user()->role, ['admin', 'staff']))
                                <div class='btn-group'>
                                    <a class='btn btn-sm btn-success' href='{{ route('student.show', $mark->student_id) }}'>
                                        <i class='bi bi-eye'></i>
                                    </a>
                                    <a class='btn btn-sm btn-info' href='{{ route('marks.edit', $mark->id) }}'>
                                        <i class='bi bi-pencil'></i>
                                    </a>
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if ($tab == 'subject')
        <div class="tab-pane fade show active" id="subject" role="tabpanel" aria-labelledby="subject-tab">
        @else
            <div class="tab-pane fade" id="subject" role="tabpanel" aria-labelledby="subject-tab">
    @endif
    <div class='d-flex justify-content-between'>
        <h2>Top Marks by Subject</h2>
        <form method='post' action='#' class='w-50 row justify-content-end hide-me'>
            <div class='col-4'>
                <input class='form-control' type='number' min='1900' max='2100' name='year'
                    placeholder='year' value='{{ old('year') }}' />
            </div>
            <div class='col-5'>
                <select name="student" class="form-select mb-3">
                    <option value="">- all student -</option>
                    @foreach ($students as $student)
                        <option value='{{ $student->id }}'>{{ $student->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class='col-3'>
                @csrf
                <input type="hidden" name="tab" value='subject' />
                <button type='submit' class='btn btn-primary w-100'>Filter</button>
            </div>
        </form>
    </div>
    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Student</th>
                <th scope="col">Subject</th>
                <th scope="col">Marks</th>
                <th scope="col">Year</th>
                <th scope="col" class='hide-me'>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($topMarksBySubject as $key => $mark)
                <tr>
                    <th scope="row">{{ $key + 1 }}</th>
                    <td>{{ $mark->student->name }}</td>
                    <td>{{ $mark->subject->name }}</td>
                    <td>{{ $mark->marks }}</td>
                    <td>{{ $mark->year }}</td>
                    <td class='hide-me'>
                        @if (in_array(Auth::user()->role, ['admin', 'staff']))
                            <div class='btn-group'>
                                <a class='btn btn-sm btn-success' href='{{ route('student.show', $mark->student_id) }}'>
                                    <i class='bi bi-eye'></i>
                                </a>
                                <a class='btn btn-sm btn-info' href='{{ route('marks.edit', $mark->id) }}'>
                                    <i class='bi bi-pencil'></i>
                                </a>
                            </div>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
    @if ($tab == 'student')
        <div class="tab-pane fade show active" id="student" role="tabpanel" aria-labelledby="student-tab">
        @else
            <div class="tab-pane fade" id="student" role="tabpanel" aria-labelledby="student-tab">
    @endif
    <div class='d-flex justify-content-between'>
        <h2>Top Marks by Student</h2>
        <form method='post' action='#' class='w-50 row justify-content-end hide-me'>
            <div class='col-4'>
                <input class='form-control' type='number' min='1900' max='2100' name='year'
                    placeholder='year' value='{{ old('year') }}' />
            </div>
            <div class='col-5'>
                <select name="subject" class="form-select mb-3">
                    <option value="">- all subject -</option>
                    @foreach ($subjects as $subject)
                        <option value='{{ $subject->id }}'>{{ $subject->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class='col-3'>
                @csrf
                <input type="hidden" name="tab" value='student' />
                <button type='submit' class='btn btn-primary w-100'>Filter</button>
            </div>
        </form>
    </div>
    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Student</th>
                <th scope="col">Subject</th>
                <th scope="col">Marks</th>
                <th scope="col">Year</th>
                <th scope="col" class='hide-me'>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($topMarksByStudent as $key => $mark)
                <tr>
                    <th scope="row">{{ $key + 1 }}</th>
                    <td>{{ $mark->student->name }}</td>
                    <td>{{ $mark->subject->name }}</td>
                    <td>{{ $mark->marks }}</td>
                    <td>{{ $mark->year }}</td>
                    <td class='hide-me'>
                        @if (in_array(Auth::user()->role, ['admin', 'staff']))
                            <div class='btn-group'>
                                <a class='btn btn-sm btn-success' href='{{ route('student.show', $mark->student_id) }}'>
                                    <i class='bi bi-eye'></i>
                                </a>
                                <a class='btn btn-sm btn-info' href='{{ route('marks.edit', $mark->id) }}'>
                                    <i class='bi bi-pencil'></i>
                                </a>
                            </div>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
    </div>
    <div class="float-end my-3 show-credit">
        <h6 class='text-muted text-end'>
            {{ now()->format('l, F j, Y') }} <br />
            prepared by {{ Auth::user()->name }}
        </h6>
    </div>
@endsection
@section('scripts')
    <script>
        document.querySelector('.show-credit').style.display = 'none'

        function printReport() {
            document.querySelector('.sidebar').style.width = 0
            document.querySelector('.show-credit').style.display = ''
            const elementsToHide = document.querySelectorAll('.hide-me');
            elementsToHide.forEach(element => {
                element.style.display = 'none';
            });

            window.print();
            setTimeout(() => {
                document.querySelector('.sidebar').style.width = 'inherit'
                document.querySelector('.show-credit').style.display = 'none'
                elementsToHide.forEach(element => {
                    element.style.display = '';
                });
            }, 2000);
        }
    </script>
@endsection
