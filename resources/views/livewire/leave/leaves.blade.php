<div> 
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">HUMAN RESORUCE</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('my-profile') }}"><i class="bx bx-user-circle"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Leaves</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->

    <!--table2-->
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <form wire:submit.prevent="performAdvancedSearch">
                        @csrf
                        <div class="mb-3" wire:ignore>
                            <label class="form-label">User Name <span style="color: red;">*</span></label>
                            <select class="form-select" wire:model="userIdAdvancedSearchField" id="userIdAdvancedSearchField">
                                <option value="">Select</option>
                                @foreach (getUsers('') as $row)
                                    <option value="{{ $row->id }}">{{ $row->upi_firstname }} {{ $row->upi_lastname }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0 table-striped">
                            <thead>
                                <tr>
                                    <th class="cursor-pointer" wire:click="sortBy('hlca', 'hlca.created_at')">
                                        #
                                        @if ($sortField2 === 'hlca.created_at')
                                            @if ($sortDirection2 === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                        @endif
                                    </th>
                                    <th class="cursor-pointer" wire:click="sortBy('hlca', 'llt.name')">
                                        Leave Type
                                        @if ($sortField2 === 'llt.name')
                                            @if ($sortDirection2 === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                        @endif
                                    </th>
                                    <th class="cursor-pointer" wire:click="sortBy('hlca', 'hlca.available')">
                                        Available
                                        @if ($sortField2 === 'hlca.available')
                                            @if ($sortDirection2 === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                        @endif
                                    </th>
                                    <th class="cursor-pointer" wire:click="sortBy('hlca', 'hlca.used')">
                                        Used
                                        @if ($sortField2 === 'hlca.used')
                                            @if ($sortDirection2 === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                        @endif
                                    </th>
                                    <th class="cursor-pointer" wire:click="sortBy('hlca', 'hlca.balance')">
                                        Balance
                                        @if ($sortField2 === 'hlca.balance')
                                            @if ($sortDirection2 === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                        @endif
                                    </th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($tableList2->count() > 0)
                                    @foreach ($tableList2 as $row)
                                        <tr>
                                            <td>{{ ++ $counter2 }}</td>
                                            <td>{{ $row->llt_name }}</td>
                                            <td>{{ $row->available }}</td>
                                            <td>{{ $row->used }}</td>
                                            <td>{{ $row->balance }}</td>
                                            <td>
                                                <div class="btn-group" role="group" aria-label="Action Button">
                                                    <button class="btn btn-primary btn-sm" wire:click="addleavecredits('{{ $row->id }}')">
                                                        <i class="bx bx-edit me-0"></i>
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
                </div>
            </div>
        </div>
    </div>
    <!--end table2-->

    <!--modal(add leave credits)-->
    <div wire:ignore.self class="modal fade" id="modelAddLeaveCreditsModal" tabindex="-1" role="dialog" aria-labelledby="modelAddLeaveCreditsModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modelAddLeaveCreditsModalLabel">
                        Add Leave Credits to {{ $modal_title2 }}
                    </h5>
                    <button type="button" class="btn-close" wire:click="closeModal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="addleavecreditsform">
                    @csrf
                    <div class="row modal-body">
                        <div class="col-md-4 mb-3" wire:ignore>
                            <label class="form-label">Month <span style="color: red;">*</span></label>
                            <select class="form-select" wire:model="month2" data-placeholder="Select" id="month2" required>
                                <option value="">Select</option>
                                @foreach (months() as $key => $value)
                                    <option value="{{ $row->key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                            @error('month2')
                                <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Year <span style="color: red;">*</span></label>
                            <input type="number" step="1" min="1900" class="form-control" placeholder="Year" wire:model="year2" required>
                            @error('year2')
                                <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Value <span style="color: red;">*</span></label>
                            <input type="number" step="0.001" min="0.001" class="form-control" placeholder="Value" wire:model="value2" required>
                            @error('value2')
                                <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Date From <span style="color: red;">*</span></label>
                            <input type="date" class="form-control" placeholder="Date From" wire:model="date_from2" required>
                            @error('date_from2')
                                <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Date To <span style="color: red;">*</span></label>
                            <input type="date" class="form-control" placeholder="Date To" wire:model="date_to2" required>
                            @error('date_to2')
                                <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Remarks <span style="color: red;">*</span></label>
                            <input type="text" class="form-control" placeholder="Remarks" wire:model="remarks2" required>
                            @error('remarks2')
                                <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end modal(add leave credits)-->
       
    <!--table-->
    <div class="card">
        <div class="card-body"> 
            <div class="row pb-3">
                <div class="col-sm-9">
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
                            <div class="col-md-3 mb-3">
                                <input type="search" class="form-control" wire:model="trackingCodeAdvancedSearchField" placeholder="Tracking Code">
                            </div>
                            <div class="col-md-3 mb-3" wire:ignore>
                                <select class="form-select" wire:model="leaveTypeIdAdvancedSearchField" id="leaveTypeIdAdvancedSearchField">
                                    <option value="">Leave Type</option>
                                    @foreach (getLeaveTypes('') as $row)
                                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <input type="search" class="form-control" wire:model="dateFromAdvancedSearchField" placeholder="Date From">
                            </div>
                            <div class="col-md-3 mb-3">
                                <input type="search" class="form-control" wire:model="dateToAdvancedSearchField" placeholder="Date To">
                            </div>
                            <div class="col-md-3 mb-3">
                                <input type="search" class="form-control" wire:model="daysAdvancedSearchField" placeholder="Days">
                            </div>
                            <div class="col-md-3 mb-3" wire:ignore>
                                <select class="form-select" wire:model="isWithPayAdvancedSearchField" id="isWithPayAdvancedSearchField">
                                    <option value="">Is With Pay?</option>
                                    @foreach (yesNo() as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3" wire:ignore>
                                <select class="form-select" wire:model="statusAdvancedSearchField" id="statusAdvancedSearchField">
                                    <option value="">Status</option>
                                    @foreach (leaveStatus() as $key => $value)
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
                            <th class="cursor-pointer" wire:click="sortBy('hl', 'hl.created_at')">
                                #
                                @if ($sortField === 'hl.created_at')
                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                @endif
                            </th>
                            <th class="cursor-pointer" wire:click="sortBy('hl', 'hl.tracking_code')">
                                Tracking Code
                                @if ($sortField === 'hl.tracking_code')
                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                @endif
                            </th>
                            <th class="cursor-pointer" wire:click="sortBy('hl', 'llt.name')">
                                Leave Type
                                @if ($sortField === 'llt.name')
                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                @endif
                            </th>
                            <th class="cursor-pointer" wire:click="sortBy('hl', 'hl.date_from')">
                                Date From
                                @if ($sortField === 'hl.date_from')
                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                @endif
                            </th>
                            <th class="cursor-pointer" wire:click="sortBy('hl', 'hl.date_to')">
                                Date To
                                @if ($sortField === 'hl.date_to')
                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                @endif
                            </th>
                            <th class="cursor-pointer" wire:click="sortBy('hl', 'hl.days')">
                                Days
                                @if ($sortField === 'hl.days')
                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                @endif
                            </th>
                            <th class="cursor-pointer" wire:click="sortBy('hl', 'hl.is_with_pay')">
                                Is With Pay?
                                @if ($sortField === 'hl.is_with_pay')
                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                @endif
                            </th>
                            <th class="cursor-pointer" wire:click="sortBy('hl', 'hl.status')">
                                Status
                                @if ($sortField === 'hl.status')
                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                @endif
                            </th>
                            <th class="cursor-pointer" wire:click="sortBy('hl', 'hl.remarks')">
                                Remarks
                                @if ($sortField === 'hl.remarks')
                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                @endif
                            </th>
                            <th class="cursor-pointer" wire:click="sortBy('hl', 'hl.created_at')">
                                Date Created
                                @if ($sortField === 'hl.created_at')
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
                                    <td>{{ $row->tracking_code }}</td>
                                    <td>{{ $row->llt_name }}</td>
                                    <td>{{ $row->date_from }}</td>
                                    <td>{{ $row->date_to }}</td>
                                    <td>{{ $row->days }}</td>
                                    <td>{{ $row->is_with_pay }}</td>
                                    <td>{{ $row->status }}</td>
                                    <td>{{ $row->remarks }}</td>
                                    <td>{{ $row->formatted_created_at }}</td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Action Buttons">
                                            <button class="btn btn-success btn-sm" wire:click="print('{{ $row->id }}')">
                                                <i class="bx bx-printer me-0"></i>
                                            </button>
                                            <button class="btn btn-primary btn-sm" wire:click="edit('{{ $row->id }}')">
                                                <i class="bx bx-edit me-0"></i>
                                            </button>
                                        </div>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-secondary btn-sm">Status</button>
                                            <button type="button" class="btn btn-secondary btn-sm split-bg-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">	<span class="visually-hidden">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
                                                <a class="dropdown-item" href="javascript:;" wire:click="changestatus('Pending', '{{ $row->id }}')">Pending</a>
                                                <a class="dropdown-item" href="javascript:;" wire:click="changestatus('Processing', '{{ $row->id }}')">Processing</a>
                                                <a class="dropdown-item" href="javascript:;" wire:click="changestatus('Cancelled', '{{ $row->id }}')">Cancelled</a>
                                                <a class="dropdown-item" href="javascript:;" wire:click="changestatus('Disapproved', '{{ $row->id }}')">Disapproved</a>
                                                <a class="dropdown-item" href="javascript:;" wire:click="changestatus('Approved', '{{ $row->id }}')">Approved</a>
                                            </div>
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


</div>

@push('scripts')
    <script type="text/javascript">
        document.addEventListener('livewire:initialized', () => {
            @this.on('openModelAddLeaveCreditsModal', (data) => {
                $('#modelAddLeaveCreditsModal').modal('show');
            });

            @this.on('closeModal', (data) => {
                $('#modelAddLeaveCreditsModal').modal('hide');
            });
        });

        advanceSearchSelect2();
        function advanceSearchSelect2(){
            $('#leaveTypeIdAdvancedSearchField').select2( {
                theme: "bootstrap-5",
                width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
            });
            $('#leaveTypeIdAdvancedSearchField').on('change', function (e) {
                @this.set('leaveTypeIdAdvancedSearchField', $(this).val());
            });

            $('#userIdAdvancedSearchField').select2( {
                theme: "bootstrap-5",
                width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
            });
            $('#userIdAdvancedSearchField').on('change', function (e) {
                @this.set('userIdAdvancedSearchField', $(this).val());
            });
            
            $('#isWithPayAdvancedSearchField').select2( {
                theme: "bootstrap-5",
                width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
            });
            $('#isWithPayAdvancedSearchField').on('change', function (e) {
                @this.set('isWithPayAdvancedSearchField', $(this).val());
            });
            
            $('#statusAdvancedSearchField').select2( {
                theme: "bootstrap-5",
                width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
            });
            $('#statusAdvancedSearchField').on('change', function (e) {
                @this.set('statusAdvancedSearchField', $(this).val());
            });
        }
    </script>
@endpush