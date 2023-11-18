<div> 
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">HUMAN RESOURCE</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('my-profile') }}"><i class="bx bx-user-circle"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Plantillas</li>
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
                    <button wire:click="toggleAdvancedSearch" class="btn btn-link">Toggle Advanced Search</button>
                </div>
            </div>

            <div class="pt-2" {{ !$showAdvancedSearch ? 'hidden' : '' }}>
                <div class="card">
                    <div class="card-body"> 
                        <form class="row" wire:submit.prevent="performAdvancedSearch">
                            @csrf
                            <div class="col-md-3 mb-3" wire:ignore>
                                <select class="form-select" wire:model="userIdAdvancedSearchField" id="userIdAdvancedSearchField">
                                    <option value="">User Name</option>
                                    @foreach (getUsers('') as $row)
                                        <option value="{{ $row->id }}">{{ $row->upi_firstname }} {{ $row->upi_lastname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <input type="search" class="form-control" wire:model="itemNumberAdvancedSearchField" placeholder="Item Number">
                            </div>
                            <div class="col-md-3 mb-3" wire:ignore>
                                <select class="form-select" wire:model="positionIdAdvancedSearchField" id="positionIdAdvancedSearchField">
                                    <option value="">Position Name</option>
                                    @foreach (getPositions('') as $row)
                                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3" wire:ignore>
                                <select class="form-select" wire:model="salaryIdAdvancedSearchField" id="salaryIdAdvancedSearchField">
                                    <option value="">Salary (Tranche - Grade - Step - Basic)</option>
                                    @foreach (getSalaries('') as $row)
                                        <option value="{{ $row->id }}">{{ $row->tranche }} - {{ $row->grade }} - {{ $row->step }} - {{ number_format($row->basic, 2) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3" wire:ignore>
                                <select class="form-select" wire:model="statusAdvancedSearchField" id="statusAdvancedSearchField">
                                    <option value="">Status</option>
                                    @foreach (plantillaStatus() as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3" wire:ignore>
                                <select class="form-select" wire:model="isPlantillaAdvancedSearchField" id="isPlantillaAdvancedSearchField">
                                    <option value="">Is Plantilla?</option>
                                    @foreach (yesNo() as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <input type="search" class="form-control" wire:model="remarksAdvancedSearchField" placeholder="Remarks">
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
                            <th class="cursor-pointer" wire:click="sortBy('u.created_at')">
                                #
                                @if ($sortField === 'hp.created_at')
                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                @endif
                            </th>
                            <th class="cursor-pointer" wire:click="sortBy('upi.firstname')">
                                User Name
                                @if ($sortField === 'upi.firstname')
                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                @endif
                            </th>
                            <th class="cursor-pointer" wire:click="sortBy('hp.item_number')">
                                Item Number
                                @if ($sortField === 'hp.item_number')
                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                @endif
                            </th>
                            <th class="cursor-pointer" wire:click="sortBy('lp.name')">
                                Position Name
                                @if ($sortField === 'lp.name')
                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                @endif
                            </th>
                            <th class="cursor-pointer" wire:click="sortBy('ls.id')">
                                Salary<br>(Tranche - Grade - Step - Basic)
                                @if ($sortField === 'ls.id')
                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                @endif
                            </th>
                            <th class="cursor-pointer" wire:click="sortBy('hp.status')">
                                Status
                                @if ($sortField === 'hp.status')
                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                @endif
                            </th>
                            <th class="cursor-pointer" wire:click="sortBy('hp.is_plantilla')">
                                Is Plantilla?
                                @if ($sortField === 'hp.is_plantilla')
                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                @endif
                            </th>
                            <th class="cursor-pointer" wire:click="sortBy('hp.remarks')">
                                Remarks
                                @if ($sortField === 'hp.remarks')
                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                @endif
                            </th>
                            <th class="cursor-pointer" wire:click="sortBy('u.created_at')">
                                Date Created
                                @if ($sortField === 'hp.created_at')
                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                @endif
                            </th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($tableList->count() > 0)
                            @foreach ($tableList as $row)
                                <tr>
                                    <td>{{ ++ $counter }}</td>
                                    <td>{{ $row->upi_firstname }} {{ $row->upi_lastname }}</td>
                                    <td>{{ $row->item_number }}</td>
                                    <td>{{ $row->lp_name }}</td>
                                    <td>{{ $row->ls_tranche }} - {{ $row->ls_grade }} - {{ $row->ls_step }} - {{ number_format($row->ls_basic, 2) }}</td>
                                    <td>{{ $row->status }}</td>
                                    <td>{{ $row->is_plantilla }}</td>
                                    <td>{{ $row->remarks }}</td>
                                    <td>{{ $row->formatted_created_at }}</td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Action Buttons">
                                            <button class="btn btn-primary btn-sm" wire:click="edit('{{ $row->id }}')">
                                                <i class="bx bx-edit me-0"></i>
                                            </button>
                                            <button class="btn btn-danger btn-sm" wire:click="toBeDeleted('{{ $row->id }}')">
                                                <i class="bx bx-trash me-0"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="10"><div class="text-center">No results found.</div></td>
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
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modelCreateUpdateModalLabel">
                        {{ $isUpdateMode ? 'Edit Plantilla' : 'Add New Plantilla' }}
                    </h5>
                    <button type="button" class="btn-close" wire:click="closeModal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="{{ $isUpdateMode ? 'update' : 'store' }}">
                    @csrf
                    <div class="row modal-body">
                        <div class="col-md-6 mb-3" wire:ignore>
                            <label class="form-label">User Name</label>
                            <select class="form-select" wire:model="user_id" data-placeholder="Select" id="user_id">
                                <option value="">Select</option>
                                @foreach (getUsers('') as $row)
                                    <option value="{{ $row->id }}">{{ $row->upi_firstname }} {{ $row->upi_lastname }}</option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Item Number <span style="color: red;">*</span></label>
                            <input type="text" class="form-control" placeholder="Item Number" wire:model="item_number" required id="focusMe">
                            @error('item_number')
                                <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3" wire:ignore>
                            <label class="form-label">Position Name <span style="color: red;">*</span></label>
                            <select class="form-select" wire:model="position_id" required id="position_id">
                                <option value="">Select</option>
                                @foreach (getPositions('') as $row)
                                    <option value="{{ $row->id }}">{{ $row->name }}</option>
                                @endforeach
                            </select>
                            @error('position_id')
                                <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3" wire:ignore>
                            <label class="form-label">Salary <span style="font-size: 8pt;">(Tranche - Grade - Step - Basic)</span> <span style="color: red;">*</span></label></label>
                            <select class="form-select" wire:model="salary_id" required id="salary_id">
                                <option value="">Select</option>
                                @foreach (getSalaries('') as $row)
                                    <option value="{{ $row->id }}">{{ $row->tranche }} - {{ $row->grade }} - {{ $row->step }} - {{ number_format($row->basic, 2) }}</option>
                                @endforeach
                            </select>
                            @error('salary_id')
                                <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3" wire:ignore>
                            <label class="form-label">Status <span style="color: red;">*</span></label>
                            <select class="form-select" wire:model="status" required id="status">
                                <option value="">Select</option>
                                @foreach (plantillaStatus() as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                            @error('status')
                                <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3" wire:ignore>
                            <label class="form-label">Is Plantilla? <span style="color: red;">*</span></label>
                            <select class="form-select" wire:model="is_plantilla" required id="is_plantilla">
                                <option value="">Select</option>
                                @foreach (yesNo() as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                            @error('is_plantilla')
                                <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label for="remarks" class="form-label">Remarks</label>
                            <textarea class="form-control" wire:model="remarks" id="remarks" placeholder="Remarks" rows="3"></textarea>
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
                    <h5 class="modal-title" id="modelDeletionModalLabel">Delete User</h5>
                    <button type="button" class="btn-close" wire:click="closeModal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="delete">
                    <div class="modal-body">
                        <p>Are you sure you want to delete this record?</p>
                        <p>User Name: <b>{{ $user_id ? getUsers($user_id)['upi_firstname'] . ' ' . getUsers($user_id)['upi_lastname'] : ''  }}</b> </p>
                        <p>Item Number: <b>{{ $item_number }}</b> </p>
                        <p>Position Name: <b>{{ $position_id ? getPositions($position_id)['name'] : '' }}</b> </p>
                        <p>Salary (Tranche - Grade - Step - Basic): <b>{{ $salary_id ? getSalaries($salary_id)['tranche'] . ' - ' . getSalaries($salary_id)['grade'] . ' - ' . getSalaries($salary_id)['step'] . ' - ' . number_format(getSalaries($salary_id)['basic'], 2) : '' }}</b> </p>
                        <p>Status: <b>{{ $status }}</b> </p>
                        <p>Is Plantilla?: <b>{{ $is_plantilla }}</b> </p>
                        <p>Remarks: <b>{{ $remarks }}</b> </p>
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
                    $('#focusMe').focus();

                    $('#user_id').select2( {
                        dropdownParent: $('#modelCreateUpdateModal'),
                        theme: "bootstrap-5",
                        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                        placeholder: $( this ).data( 'placeholder' ),
                        closeOnSelect: true,
                        allowClear: true,
                    });
                    $('#user_id').on('change', function (e) {
                        @this.set('user_id', $(this).val());
                    });

                    $('#position_id').select2( {
                        dropdownParent: $('#modelCreateUpdateModal'),
                        theme: "bootstrap-5",
                        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                        placeholder: $( this ).data( 'placeholder' ),
                        closeOnSelect: true,
                    });
                    $('#position_id').on('change', function (e) {
                        @this.set('position_id', $(this).val());
                    });

                    $('#salary_id').select2( {
                        dropdownParent: $('#modelCreateUpdateModal'),
                        theme: "bootstrap-5",
                        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                        placeholder: $( this ).data( 'placeholder' ),
                        closeOnSelect: true,
                    });
                    $('#salary_id').on('change', function (e) {
                        @this.set('salary_id', $(this).val());
                    });

                    $('#status').select2( {
                        dropdownParent: $('#modelCreateUpdateModal'),
                        theme: "bootstrap-5",
                        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                        placeholder: $( this ).data( 'placeholder' ),
                        closeOnSelect: true,
                    });
                    $('#status').on('change', function (e) {
                        @this.set('status', $(this).val());
                    });

                    $('#is_plantilla').select2( {
                        dropdownParent: $('#modelCreateUpdateModal'),
                        theme: "bootstrap-5",
                        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                        placeholder: $( this ).data( 'placeholder' ),
                        closeOnSelect: true,
                    });
                    $('#is_plantilla').on('change', function (e) {
                        @this.set('is_plantilla', $(this).val());
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
            $('#userIdAdvancedSearchField').select2( {
                theme: "bootstrap-5",
                width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
            });
            $('#userIdAdvancedSearchField').on('change', function (e) {
                @this.set('userIdAdvancedSearchField', $(this).val());
            });

            $('#positionIdAdvancedSearchField').select2( {
                theme: "bootstrap-5",
                width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
            });
            $('#positionIdAdvancedSearchField').on('change', function (e) {
                @this.set('positionIdAdvancedSearchField', $(this).val());
            });

            $('#salaryIdAdvancedSearchField').select2( {
                theme: "bootstrap-5",
                width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
            });
            $('#salaryIdAdvancedSearchField').on('change', function (e) {
                @this.set('salaryIdAdvancedSearchField', $(this).val());
            });

            $('#statusAdvancedSearchField').select2( {
                theme: "bootstrap-5",
                width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
            });
            $('#statusAdvancedSearchField').on('change', function (e) {
                @this.set('statusAdvancedSearchField', $(this).val());
            });

            $('#isPlantillaAdvancedSearchField').select2( {
                theme: "bootstrap-5",
                width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
            });
            $('#isPlantillaAdvancedSearchField').on('change', function (e) {
                @this.set('isPlantillaAdvancedSearchField', $(this).val());
            });
        }
    </script>
@endpush