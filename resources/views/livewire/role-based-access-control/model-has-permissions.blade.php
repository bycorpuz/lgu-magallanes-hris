<div> 
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Human Resource Management</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">RBAC - Model Has Permissions</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
       
    <!--table-->
    <div class="card">
        <div class="card-body"> 
            <div class="row pb-3">
                <div class="col-sm-2 text-center">
                    <button type="button" class="btn btn-primary" wire:click="openCreateUpdateModal">
                        <i class="bx bx-plus-circle me-0"></i> Add New
                    </button>
                </div>
                <div class="col-sm-7">
                    <div class="position-relative search-bar d-lg-block d-none">
                        <input class="form-control px-5" type="search" placeholder="Search" wire:model.live.debounce.100ms="search" {{ $showAdvancedSearch ? 'disabled' : '' }}>
                        <span class="position-absolute top-50 search-show ms-3 translate-middle-y start-0 top-50 fs-5"><i class="bx bx-search"></i></span>
                    </div>
                </div>
                <div class="col-sm-3 text-center">
                    <button class="btn btn-link" wire:click="toggleAdvancedSearch" >Toggle Advanced Search</button>
                </div>
            </div>

            <div class="pt-2" {{ !$showAdvancedSearch ? 'hidden' : '' }}>
                <div class="card">
                    <div class="card-body"> 
                        <form class="row" wire:submit.prevent="performAdvancedSearch">
                            @csrf
                            <div class="col-md-3 mb-3" wire:ignore>
                                <select class="form-select" wire:model="modelIdAdvancedSearchField" id="modelIdAdvancedSearchField">
                                    <option value="">User Name</option>
                                    @foreach (getUsers('') as $row)
                                        <option value="{{ $row->id }}">{{ $row->upi_firstname }} {{ $row->upi_lastname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <input type="search" class="form-control" wire:model="emailAdvancedSearchField" placeholder="Email">
                            </div>
                            <div class="col-md-3 mb-3" wire:ignore>
                                <select class="form-select" wire:model="permissionIdAdvancedSearchField" id="permissionIdAdvancedSearchField">
                                    <option value="">Permission Name</option>
                                    @foreach (getPermissions('') as $row)
                                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="search" class="form-control" wire:model="dateCreatedAdvancedSearchField" placeholder="Date Created">
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary" >Search</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table mb-0 table-striped">
                    <thead>
                        <tr>
                            <th class="cursor-pointer" wire:click="sortBy('created_at')">
                                #
                                @if ($sortField === 'created_at')
                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                @endif
                            </th>
                            <th class="cursor-pointer" wire:click="sortBy('upi.firstname')">
                                User Name
                                @if ($sortField === 'upi.firstname')
                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                @endif
                            </th>
                            <th class="cursor-pointer" wire:click="sortBy('u.email')">
                                Email
                                @if ($sortField === 'u.email')
                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                @endif
                            </th>
                            <th class="cursor-pointer" wire:click="sortBy('permission_id')">
                                Permission Name
                                @if ($sortField === 'permission_id')
                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                @endif
                            </th>
                            <th class="cursor-pointer" wire:click="sortBy('created_at')">
                                Date Created
                                @if ($sortField === 'created_at')
                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                @endif
                            </th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($tableList->count() > 0)
                            @foreach ($tableList as $row)
                                <tr>
                                    <td>{{ ++ $counter }}</td>
                                    <td>{{ $row->upi_firstname }} {{ $row->upi_lastname }}</td>
                                    <td>{{ $row->u_email }}</td>
                                    <td>{{ $row->p_name }}</td>
                                    <td>{{ $row->formatted_created_at }}</td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Action Buttons">
                                            <button class="btn btn-danger btn-sm" wire:click="toBeDeleted('{{ $row->model_id }}','{{ $row->permission_id }}')">
                                                <i class="bx bx-trash me-0"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7"><div class="text-center">No results found.</div></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <div class="row pt-3">
                <div class="col-sm-9">{{ $tableList->links() }}</div>
                <div class="col-sm-3">
                    <div class="row">
                        Show &nbsp;
                        <select class="form-select form-select-sm" wire:model="perPage" wire:change="selectedValuePerPage" style="width: 80px;">
                            <option value="10">10</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                            <option value="500">500</option>
                            <option value="1000">1000</option>
                        </select>
                        &nbsp; entries
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-9">
                    Showing {{ number_format($tableList->firstItem(), 0) }} to {{ number_format($tableList->lastItem(), 0) }} of {{ number_format($tableList->total(), 0) }} entries
                </div>
                <div class="col-sm-3">
                    <div class="row">
                        Total entries: {{ $totalTableDataCount }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end table-->

    <!--modal(create and update)-->
    <div wire:ignore.self class="modal fade" id="modelCreateUpdateModal" tabindex="-1" role="dialog" aria-labelledby="modelCreateUpdateModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modelCreateUpdateModalLabel">
                        {{ $isUpdateMode ? 'Edit Permission to a User' : 'Add New Permission to a User' }}
                    </h5>
                    <button type="button" class="btn-close" wire:click="closeModal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="{{ $isUpdateMode ? 'update' : 'store' }}">
                    @csrf
                    <div class="row modal-body">
                        <div class="mb-3" wire:ignore>
                            <label class="form-label">User Name</label>
                            <select class="form-select" wire:model="model_id" data-placeholder="Select 1 or more" required multiple id="model_id">
                                <option value="">Select</option>
                                @foreach (getUsers('') as $row)
                                    <option value="{{ $row->id }}">{{ $row->upi_firstname }} {{ $row->upi_lastname }}</option>
                                @endforeach
                            </select>
                            @error('model_id')
                                <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3" wire:ignore>
                            <label class="form-label">Permission Name</label>
                            <select class="form-select" wire:model="permission_id" data-placeholder="Select 1 or more" required multiple id="permission_id">
                                @foreach (getPermissions('') as $row)
                                    <option value="{{ $row->id }}">{{ $row->name }}</option>
                                @endforeach
                            </select>
                            @error('permission_id')
                                <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{ $isUpdateMode ? 'Update' : 'Create' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end modal(create and update)-->

    <!--modal(delete)-->
    <div wire:ignore.self class="modal fade" id="modelDeletionModal" tabindex="-1" role="dialog" aria-labelledby="modelDeletionModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modelDeletionModalLabel">Delete Permission to a User</h5>
                    <button type="button" class="btn-close" wire:click="closeModal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="delete">
                    <div class="modal-body">
                        <p>Are you sure you want to delete this record?</p>
                        <p>User Name: <b>{{ is_array($model_id) ? '' : getUsers($model_id)['upi_firstname'] . ' ' . getUsers($model_id)['upi_lastname'] }}</b> </p>
                        <p>Permission Name: <b>{{ is_array($permission_id) ? '' : getPermissions($permission_id)['name'] }}</b> </p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger close-modal" data-dismiss="modal">Yes, Delete it.</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end modal(delete)-->
</div>

@push('scripts')
    <script type="text/javascript">
        document.addEventListener('livewire:initialized', () => {
            @this.on('openCreateUpdateModal', (data) => {
                $('#modelCreateUpdateModal').modal('show');
                $('#modelCreateUpdateModal').on('shown.bs.modal', function (e) {
                    $('#model_id').select2( {
                        dropdownParent: $('#modelCreateUpdateModal'),
                        theme: "bootstrap-5",
                        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                        placeholder: $( this ).data( 'placeholder' ),
                        closeOnSelect: false,
                    });
                    $('#model_id').on('change', function (e) {
                        @this.set('model_id', $(this).val());
                    });

                    $('#permission_id').select2( {
                        dropdownParent: $('#modelCreateUpdateModal'),
                        theme: "bootstrap-5",
                        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                        placeholder: $( this ).data( 'placeholder' ),
                        closeOnSelect: false,
                    });
                    $('#permission_id').on('change', function (e) {
                        @this.set('permission_id', $(this).val());
                    });
                });
            });
            
            @this.on('openDeletionModal', (data) => {
                $('#modelDeletionModal').modal('show');
            });

            @this.on('closeModal', (data) => {
                $('#modelCreateUpdateModal').modal('hide');
                $('#modelDeletionModal').modal('hide');
            });
        });

        advanceSearchSelect2();
        function advanceSearchSelect2(){
            $('#modelIdAdvancedSearchField').select2( {
                theme: "bootstrap-5",
                width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
            });
            $('#modelIdAdvancedSearchField').on('change', function (e) {
                @this.set('modelIdAdvancedSearchField', $(this).val());
            });

            $('#permissionIdAdvancedSearchField').select2( {
                theme: "bootstrap-5",
                width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
            });
            $('#permissionIdAdvancedSearchField').on('change', function (e) {
                @this.set('permissionIdAdvancedSearchField', $(this).val());
            });
        }
    </script>
@endpush