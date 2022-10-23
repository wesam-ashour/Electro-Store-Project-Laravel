@extends('celebrity.layouts.master')
@section('content')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Categories Sections</h4><span
                    class="text-muted mt-1 tx-13 ml-2 mb-0">/ Categorieslist</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
    <div class="row row-sm">
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 grid-margin">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">Categories Table</h4>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                    <p class="tx-12 tx-gray-500 mb-2">List of all Categories</p>
                    <div class="row row-xs wd-xl-80p">
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive border-top userlist-table">
                        @if (Session::has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <h4 class="alert-heading">Success!</h4>
                                <p>{{ Session::get('success') }}</p>

                                <button type="button" class="close" data-dismiss="alert aria-label=" Close
                                ">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if (Session::has('errors'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <h4 class="alert-heading">Error!</h4>
                                <p>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                </p>

                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <div class="container py-3">

                            <div class="modal" tabindex="-1" role="dialog" id="editCategoryModal">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Category</h5>

                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <form action="" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <input type="text" name="name" class="form-control" value=""
                                                           placeholder="Category Name" required>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                    Close
                                                </button>
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-8">

                                    <div class="card">
                                        <div class="card-header">
                                            <h3>Categories</h3>
                                        </div>
                                        <div class="card-body">
                                            <ul class="list-group">
                                                @foreach ($categories as $category)
                                                    <li class="list-group-item">
                                                        <div class="d-flex justify-content-between">
                                                            Main: {{ $category->name }}
                                                        </div>

                                                        @if ($category->children)
                                                            <ul class="list-group mt-2">
                                                                @forelse ($category->children->where('celebrity_id',\Illuminate\Support\Facades\Auth::user()->id) as $child)
                                                                    <li class="list-group-item">
                                                                        <div class="d-flex justify-content-between">
                                                                            SubCategory: {{ $child->name }}

                                                                            <div class="button-group d-flex">
                                                                                <button type="button"
                                                                                        class="btn btn-sm btn-primary mr-1 edit-category"
                                                                                        data-toggle="modal"
                                                                                        data-target="#editCategoryModal"
                                                                                        data-id="{{ $child->id }}"
                                                                                        data-name="{{ $child->name }}">
                                                                                    Edit
                                                                                </button>

                                                                                <form
                                                                                    action="{{ route('categories.destroy', $child->id) }}"
                                                                                    method="POST">
                                                                                    @csrf
                                                                                    @method('DELETE')

                                                                                    <button type="submit"
                                                                                            class="btn btn-sm btn-danger">
                                                                                        Delete
                                                                                    </button>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                        <ul class="list-group">
                                                                            @foreach($child->children as $childs)
                                                                                <li class="list-group-item">
                                                                                    <div
                                                                                        class="d-flex justify-content-between">
                                                                                        SubSubCategory: {{ $childs->name }}

                                                                                        <div
                                                                                            class="button-group d-flex">
                                                                                            <button type="button"
                                                                                                    class="btn btn-sm btn-primary mr-1 edit-category"
                                                                                                    data-toggle="modal"
                                                                                                    data-target="#editCategoryModal"
                                                                                                    data-id="{{ $childs->id }}"
                                                                                                    data-name="{{ $childs->name }}">
                                                                                                Edit
                                                                                            </button>

                                                                                            <form
                                                                                                action="{{ route('categories.destroy', $childs->id) }}"
                                                                                                method="POST">
                                                                                                @csrf
                                                                                                @method('DELETE')

                                                                                                <button type="submit"
                                                                                                        class="btn btn-sm btn-danger">
                                                                                                    Delete
                                                                                                </button>
                                                                                            </form>
                                                                                        </div>
                                                                                    </div>
                                                                                    @endforeach
                                                                                </li>
                                                                        </ul>
                                                                    </li>
                                                                @empty
                                                                   <small style="color: #8a1f11">There is no subcategory .. you can add new subcategory</small>
                                                                @endforelse
                                                            </ul>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3>Create subCategory</h3>
                                        </div>

                                        <div class="card-body">
                                            <form action="{{ route('categories.store') }}" method="POST">
                                                @csrf

                                                <div class="form-group">
                                                    <select class="form-control" name="parent_id">
                                                        @foreach ($categories as $category)
                                                            <option
                                                                value="{{ $category->id }}">{{ $category->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <input type="text" name="name" class="form-control"
                                                           value="{{ old('name') }}" placeholder="Category Name"
                                                           required>
                                                </div>

                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary">Create</button>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="card-header">
                                            <h3>Create Sub-SubCategory</h3>
                                        </div>
                                        <div class="card-body">
                                            <form action="{{ route('categories.store') }}" method="POST">
                                                @csrf

                                                <div class="form-group">
                                                    <select class="form-control" name="parent_id">
                                                        <option value="">Select Parent Category</option>

                                                        @foreach ($categoriesChildes as $category)
                                                            <option
                                                                value="{{ $category->id }}">{{ $category->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <input type="text" name="name" class="form-control"
                                                           value="{{ old('name') }}" placeholder="Category Name"
                                                           required>
                                                    <input type="hidden" name="haveSub" class="form-control"
                                                           value="true"
                                                           required>
                                                </div>

                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary">Create</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script
                            src="https://code.jquery.com/jquery-3.4.1.min.js"
                            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
                            crossorigin="anonymous"></script>

                        <script type="text/javascript">
                            $('.edit-category').on('click', function () {
                                var id = $(this).data('id');
                                var name = $(this).data('name');
                                var url = "{{ url('celebrity/categories') }}/" + id;

                                $('#editCategoryModal form').attr('action', url);
                                $('#editCategoryModal form input[name="name"]').val(name);
                            });
                        </script>

                    </div>
                </div>
            </div>
        </div><!-- COL END -->
    </div>
    <!-- row closed  -->
@endsection
