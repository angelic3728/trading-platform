@extends('layouts.dashboard')
@section('title', 'Dashboard')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card mt-4 mt-lg-5">
                    <div class="card-header">
                        <div class="row align-items-center justify-content-between">
                          <div class="col-auto">
                              <h4 class="mb-0">Documents</h4>
                          </div>
                          <div class="col-auto d-flex">
                              <form action="{{ route('documents.index') }}" class="d-none d-sm-inline">
                                  <div class="search">
                                      <input type="text" class="form-control" placeholder="Search" name="q" value="{{ request()->q }}">
                                      <button type="submit" class="search-icon">
                                          @svg('table.search')
                                      </button>
                                  </div>
                              </form>

                              <upload-document-button></upload-document-button>
                          </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Type</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Provided by</th>
                                    <th scope="col">Date</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($documents as $document)
                                    <tr>
                                        <td class="type">{{ $document->type }}</td>
                                        <td width="20%" class="title">{{ $document->title }}</td>
                                        <td width="40%" class="description">{{ $document->description }}</td>
                                        <td class="text-nowrap">{{ $document->provider->first_name }} {{ $document->provider->last_name }}</td>
                                        <td class="text-nowrap">{{ $document->created_at }}</td>
                                        <td class="text-right">
                                            <a href="{{ route('documents.download', ['id' => $document->id]) }}" target="_blank">Download</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($documents->isEmpty())
                        <div class="table-empty">
                              @if(request()->has('q'))
                                  There are no documents that match your search result
                              @else
                                  There are no documents at the moment.
                              @endif
                        </div>
                    @endif
                </div>

                {{ $documents->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endsection
