@extends('admin.layouts.app')

@section('title', 'Pages')

@section('content')
    <div class="d-flex justify-content-end mb-3">
        <a class="btn btn-dark" href="{{ route('admin.pages.create') }}">New Page</a>
    </div>

    <div class="panel panel-pad mb-3">
        <form class="row g-2" method="GET">
            <div class="col-lg-5"><input class="form-control" name="q" value="{{ request('q') }}" placeholder="Search pages"></div>
            <div class="col-lg-3">
                <select class="form-select" name="template">
                    <option value="">All templates</option>
                    @foreach ($templates as $template)
                        <option value="{{ $template }}" @selected(request('template') === $template)>{{ $template }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-2">
                <select class="form-select" name="status">
                    <option value="">All statuses</option>
                    <option value="draft" @selected(request('status') === 'draft')>Draft</option>
                    <option value="published" @selected(request('status') === 'published')>Published</option>
                </select>
            </div>
            <div class="col-lg-2"><button class="btn btn-dark w-100" type="submit">Filter</button></div>
        </form>
    </div>

    <div class="panel">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>Template</th>
                        <th>Status</th>
                        <th>Published</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pages as $page)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $page->title }}</div>
                                <div class="text-muted small">{{ $page->excerpt }}</div>
                            </td>
                            <td>{{ $page->slug }}</td>
                            <td>{{ $page->template }}</td>
                            <td><span class="badge {{ $page->status === 'published' ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $page->status }}</span></td>
                            <td>{{ $page->published_at?->format('Y-m-d H:i') ?: '-' }}</td>
                            <td class="text-end">
                                @if ($page->status === 'published')
                                    <a class="btn btn-sm btn-outline-dark" href="{{ route('pages.show', $page) }}" target="_blank">View</a>
                                @endif
                                <a class="btn btn-sm btn-outline-dark" href="{{ route('admin.pages.edit', $page) }}">Edit</a>
                                <form class="d-inline" method="POST" action="{{ route('admin.pages.destroy', $page) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-muted p-4">No pages found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="panel-pad">{{ $pages->links() }}</div>
    </div>
@endsection
