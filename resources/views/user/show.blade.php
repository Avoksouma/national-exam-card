@extends('layouts.dashboard')
@section('content')
    <nav aria-label="breadcrumb" class='hide-me'>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('user.index') }}">User</a></li>
            <li class="breadcrumb-item active" aria-current="page">User Profile</li>
        </ol>
    </nav>
    <div class="card card-body shadow-sm mb-3 hide-me">
        <div class="d-flex flex-row">
            @if ($user->image)
                <img alt='{{ $user->name }}' src='{{ asset('storage/' . $user->image) }}' width='120' height='120'
                    style='object-fit:cover' class='rounded-pill me-3 my-auto' />
            @endif
            <table class="table table-bordered table-hover mb-0">
                <tbody>
                    <tr>
                        <th>Name</th>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th>Role</th>
                        <td>{{ $user->role }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    @if ($user->role == 'student')
        @if ($applications->count())
            <h3 class='hide-me'>Applications</h3>
        @endif
        <table class="table table-bordered table-hover hide-me">
            @if ($applications->count())
                <thead class="table-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Status</th>
                        <th scope="col">Birth Date</th>
                        <th scope="col">School</th>
                        <th scope="col">Contact Person</th>
                    </tr>
                </thead>
            @endif
            <tbody>
                @foreach ($applications as $key => $application)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>
                            @if ($application->image)
                                <img alt='{{ $application->first_name }}'
                                    src='{{ asset('storage/' . $application->image) }}' width='40' height='40'
                                    style='object-fit:cover' class='rounded-pill me-1' />
                            @endif
                            {{ $application->first_name }} {{ $application->last_name }}
                        </td>
                        <td>
                            <span class='badge {{ $colors[$application->status] }}'>
                                {{ $application->status }}
                            </span>
                        </td>
                        <td>{{ $application->dob }}</td>
                        <td>{{ $application->school->name }}</td>
                        <td>{{ $application->contact_person }} {{ $application->contact_details }}</td>

                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $applications->links() }}
        @if ($marks->count())
            <div class='hide-me float-end'>
                <button class='btn btn-info ms-4' onclick='printReport()'>
                    <i class='bi bi-file-break'></i> PRINT
                </button>
            </div>
            <div class='d-flex justify-content-between'>
                <h3>Marks Report</h3>
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
        @endif
        <table class="table table-bordered table-hover">
            @if ($marks->count())
                <thead class="table-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Student</th>
                        <th scope="col">Subject</th>
                        <th scope="col">Marks</th>
                        <th scope="col">Year</th>
                    </tr>
                </thead>
            @endif
            <tbody>
                @foreach ($marks as $key => $mark)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $mark->student->name }}</td>
                        <td>{{ $mark->subject->name }}</td>
                        <td>{{ $mark->marks }}</td>
                        <td>{{ $mark->year }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $marks->links() }}
        <div class="float-end my-3 show-credit">
            <h6 class='text-muted text-end'>
                {{ now()->format('l, F j, Y') }} <br />
                printed by {{ Auth::user()->name }}
            </h6>
        </div>
    @endif
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
