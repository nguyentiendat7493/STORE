@extends('admin.layouts.app')

@section('title', 'Customers')

@section('content')
    <div class="panel panel-pad mb-3">
        <form class="row g-2" method="GET">
            <div class="col-md-10"><input class="form-control" name="q" value="{{ request('q') }}" placeholder="Search customers"></div>
            <div class="col-md-2"><button class="btn btn-dark w-100" type="submit">Search</button></div>
        </form>
    </div>
    <div class="panel">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Created</th><th></th></tr></thead>
                <tbody>
                    @forelse ($customers as $customer)
                        <tr>
                            <td>{{ $customer->id }}</td>
                            <td>{{ $customer->name }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->phone }}</td>
                            <td>{{ $customer->created_at?->format('Y-m-d') }}</td>
                            <td class="text-end"><a class="btn btn-sm btn-outline-dark" href="{{ route('admin.customers.show', $customer) }}">View</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-muted p-4">No customers found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="panel-pad">{{ $customers->links() }}</div>
    </div>
@endsection
