<div>
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">HUMAN RESOURCE - Leave Management</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('my-profile') }}"><i class="bx bx-user-circle"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Leave Earnings</li>
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
                            <div class="col-md-3 mb-3" wire:ignore>
                                <select class="form-select" wire:model="leaveTypeIdAdvancedSearchField" id="leaveTypeIdAdvancedSearchField">
                                    <option value="">Leave Type</option>
                                    @foreach (getLeaveTypes('') as $row)
                                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3" wire:ignore>
                                <select class="form-select" wire:model="monthAdvancedSearchField" id="monthAdvancedSearchField">
                                    <option value="">Month</option>
                                    @foreach (months() as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <input type="search" class="form-control" wire:model="yearAdvancedSearchField" placeholder="Year">
                            </div>
                            <div class="col-md-3 mb-3">
                                <input type="search" class="form-control" wire:model="valueAdvancedSearchField" placeholder="Value">
                            </div>
                            <div class="col-md-3 mb-3">
                                <input type="search" class="form-control" wire:model="dateFromAdvancedSearchField" placeholder="Date From">
                            </div>
                            <div class="col-md-3 mb-3">
                                <input type="search" class="form-control" wire:model="dateToAdvancedSearchField" placeholder="Date To">
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
                            <th class="cursor-pointer" wire:click="sortBy('created_at')">
                                #
                                @if ($sortField === 'created_at')
                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                @endif
                            </th>
                            <th class="cursor-pointer" wire:click="sortBy('hlca.user_id')">
                                User Name
                                @if ($sortField === 'hlca.user_id')
                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                @endif
                            </th>
                            <th class="cursor-pointer" wire:click="sortBy('llt.name')">
                                Leave Type
                                @if ($sortField === 'llt.name')
                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                @endif
                            </th>
                            <th class="cursor-pointer" wire:click="sortBy('hlcal.month')">
                                Month
                                @if ($sortField === 'hlcal.month')
                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                @endif
                            </th>
                            <th class="cursor-pointer" wire:click="sortBy('hlcal.year')">
                                Year
                                @if ($sortField === 'hlcal.year')
                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                @endif
                            </th>
                            <th class="cursor-pointer" wire:click="sortBy('hlcal.value')">
                                Value
                                @if ($sortField === 'hlcal.value')
                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                @endif
                            </th>
                            <th class="cursor-pointer" wire:click="sortBy('hlcal.date_from')">
                                Date From
                                @if ($sortField === 'hlcal.date_from')
                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                @endif
                            </th>
                            <th class="cursor-pointer" wire:click="sortBy('hlcal.date_to')">
                                Date To
                                @if ($sortField === 'hlcal.date_to')
                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                @endif
                            </th>
                            <th class="cursor-pointer" wire:click="sortBy('hlcal.remarks')">
                                Remarks
                                @if ($sortField === 'hlcal.remarks')
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
                                    <td>{{ $row->llt_name }}</td>
                                    <td>{{ $row->month }}</td>
                                    <td>{{ $row->year }}</td>
                                    <td>{{ number_format($row->value, 3) }}</td>
                                    <td>{{ $row->date_from }}</td>
                                    <td>{{ $row->date_to }}</td>
                                    <td>{{ $row->remarks }}</td>
                                    <td>{{ $row->formatted_created_at }}</td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Action Buttons">
                                            <button class="btn btn-danger btn-sm" wire:click="toBeDeleted('{{ $row->id }}')">
                                                <i class="bx bx-trash me-0"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="11"><div class="text-center">No results found.</div></td>
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
                        {{ $isUpdateMode ? 'Edit Leave Earnings' : 'Add New Leave Earnings' }}
                    </h5>
                    <button type="button" class="btn-close" wire:click="closeModal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="{{ $isUpdateMode ? 'update' : 'store' }}">
                    @csrf
                    <div class="row modal-body">
                        <div class="col-md-6 mb-3" wire:ignore>
                            <label class="form-label">Leave Type <span style="color: red;">*</span></label>
                            <select class="form-select" wire:model="leave_type_id" data-placeholder="Select 1 or more" id="leave_type_id" required multiple>
                                @foreach (getLeaveTypes('') as $row)
                                    <option value="{{ $row->id }}">{{ $row->name }}</option>
                                @endforeach
                            </select>
                            @error('leave_type_id')
                                <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3" wire:ignore>
                            <label class="form-label">User Name <span style="color: red;">*</span></label>
                            <select class="form-select" wire:model="user_id" data-placeholder="Select 1 or more" id="user_id" required multiple>
                                <option value="All Plantilla Users">All Plantilla Users</option>
                                @foreach (getUsers('') as $row)
                                    <option value="{{ $row->id }}">{{ $row->upi_firstname }} {{ $row->upi_lastname }}</option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3" wire:ignore>
                            <label class="form-label">Month <span style="color: red;">*</span></label>
                            <select class="form-select" wire:model="month" id="month" required>
                                <option value="">Select</option>
                                @foreach (months() as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                            @error('month')
                                <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Year <span style="color: red;">*</span></label>
                            <input type="number" step="1" min="1900" class="form-control" placeholder="Year" wire:model="year" required>
                            @error('year')
                                <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Value <span style="color: red;">*</span></label>
                            <input type="number" step="0.001" class="form-control" placeholder="Value" wire:model="hlcalValue" required>
                            @error('hlcalValue')
                                <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Remarks <span style="color: red;">*</span></label>
                            <textarea class="form-control" wire:model="remarks" placeholder="Remarks" rows="3"></textarea>
                            @error('remarks')
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
                    <h5 class="modal-title" id="modelDeletionModalLabel">Delete Leave Earning</h5>
                    <button type="button" class="btn-close" wire:click="closeModal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="delete">
                    <div class="modal-body">
                        <p>Are you sure you want to delete this record?</p>
                        <p>User Name: <b>{{ $user_name }}</b> </p>
                        <p>Leave Type: <b>{{ $leave_type_name }}</b> </p>
                        <p>Month: <b>{{ $month }}</b> </p>
                        <p>Year: <b>{{ $year }}</b> </p>
                        <p>Value: <b>{{ $hlcalValue }}</b> </p>
                        <p>Date From: <b>{{ $date_from }}</b> </p>
                        <p>Date To: <b>{{ $date_to }}</b> </p>
                        <p>Remarks: <b>{{ $remarks }}</b> </p>
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
                    $('#leave_type_id').select2( {
                        dropdownParent: $('#modelCreateUpdateModal'),
                        theme: "bootstrap-5",
                        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                        placeholder: $( this ).data( 'placeholder' ),
                        closeOnSelect: true,
                    });
                    $('#leave_type_id').on('change', function (e) {
                        @this.set('leave_type_id', $(this).val());
                    });

                    $('#user_id').select2( {
                        dropdownParent: $('#modelCreateUpdateModal'),
                        theme: "bootstrap-5",
                        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                        placeholder: $( this ).data( 'placeholder' ),
                        closeOnSelect: true,
                    });
                    $('#user_id').on('change', function (e) {
                        @this.set('user_id', $(this).val());
                    });

                    $('#month').select2( {
                        dropdownParent: $('#modelCreateUpdateModal'),
                        theme: "bootstrap-5",
                        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                        placeholder: $( this ).data( 'placeholder' ),
                        closeOnSelect: true,
                    });
                    $('#month').on('change', function (e) {
                        @this.set('month', $(this).val());
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

            advanceSearchSelect2();
        });

        function advanceSearchSelect2(){
            $('#userIdAdvancedSearchField').select2( {
                theme: "bootstrap-5",
                width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
            });
            $('#userIdAdvancedSearchField').on('change', function (e) {
                @this.set('userIdAdvancedSearchField', $(this).val());
            });

            $('#leaveTypeIdAdvancedSearchField').select2( {
                theme: "bootstrap-5",
                width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
            });
            $('#leaveTypeIdAdvancedSearchField').on('change', function (e) {
                @this.set('leaveTypeIdAdvancedSearchField', $(this).val());
            });

            $('#monthAdvancedSearchField').select2( {
                theme: "bootstrap-5",
                width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
            });
            $('#monthAdvancedSearchField').on('change', function (e) {
                @this.set('monthAdvancedSearchField', $(this).val());
            });
        }
    </script>
@endpush
