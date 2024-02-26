<a class='btn btn-success rounded-pill' href='{{ route('application.create') }}'>
    <i class='bi bi-check'></i> Apply for the National Exam Card
</a>

<table class="table table-bordered table-hover mt-3">
    @if ($applications->count())
        <thead class="table-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Status</th>
                <th scope="col">Birth Date</th>
                <th scope="col">School</th>
                <th scope="col">Contact Person</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
    @endif
    <tbody>
        @foreach ($applications as $key => $application)
            <tr>
                <th scope="row">{{ $key + 1 }}</th>
                <td>
                    @if ($application->image)
                        <img alt='{{ $application->first_name }}' src='{{ asset('storage/' . $application->image) }}'
                            width='40' height='40' style='object-fit:cover' class='rounded-pill me-1' />
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
                <td>
                    @if (Auth::user()->role == 'sponsor')
                        <div class='btn-group'>
                            <a class='btn btn-sm btn-success' href='{{ route('application.show', $application->id) }}'>
                                <i class='bi bi-eye'></i>
                            </a>
                            <a href='{{ route('application.support', $application->id) }}' class='btn btn-sm btn-info'
                                data-toggle="tooltip" title="Sponsor child">
                                <i class='bi bi-check'></i>
                            </a>
                        </div>
                    @endif
                    <div class='btn-group'>
                        <a class='btn btn-sm btn-success' href='{{ route('application.show', $application->id) }}'>
                            <i class='bi bi-eye'></i>
                        </a>
                        <a class='btn btn-sm btn-info' href='{{ route('application.edit', $application->id) }}'>
                            <i class='bi bi-pencil'></i>
                        </a>
                    </div>
                    <form action='{{ route('application.destroy', $application->id) }}' method='post'
                        class='d-inline'>
                        @csrf @method('delete')
                        <button class='btn btn-sm btn-warning'>
                            <i class='bi bi-trash'></i>
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
