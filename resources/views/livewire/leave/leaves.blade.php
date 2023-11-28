<div> 
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">HUMAN RESOURCE - Leave Management</div>
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
                                    <th>Action</th>
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
                                                    <button class="btn btn-success btn-sm" wire:click="addleavecredits('{{ $row->id }}')">
                                                        <i class="bx bx-plus me-0"></i>
                                                    </button>
                                                    @if ($row->available == 0 && $row->used == 0 && $row->balance)
                                                        <button class="btn btn-danger btn-sm" wire:click="deleteleavecreditsavailable('{{ $row->id }}')">
                                                            <i class="bx bx-trash me-0"></i>
                                                        </button>
                                                    @endif
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
                        {{ $isUpdateMode2 ? 'Edit Leave Credits of': 'Add Leave Credits to'}} {{ $modal_title2 }} 
                    </h5>
                    <button type="button" class="btn-close" wire:click="closeModal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="{{ $isUpdateMode2 ? 'updateleavecreditsform': 'addleavecreditsform'}}">
                    @csrf
                    <div class="row modal-body">
                        <div class="col-md-4 mb-3" wire:ignore>
                            <label class="form-label">Month <span style="color: red;">*</span></label>
                            <select class="form-select" wire:model="month2" id="month2" required>
                                <option value="">Select</option>
                                @foreach (months() as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
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
                            <input type="number" step="0.001" class="form-control" placeholder="Value" wire:model="value2" required>
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
                        <button type="submit" class="btn btn-primary">{{  $isUpdateMode2 ? 'Update': 'Create' }}</button>
                    </div>
                </form>

                <div class="card m-3">
                    <div class="card-body"> 
                        <div class="row pb-3">
                            <div class="col-sm-8">
                                <div class="position-relative search-bar d-lg-block d-none">
                                    <input class="form-control px-5" type="search" placeholder="Search" wire:model.live.debounce.100ms="search3" {{ $showAdvancedSearch3 ? 'disabled' : '' }}>
                                    <span class="position-absolute top-50 search-show ms-3 translate-middle-y start-0 top-50 fs-5"><i class="bx bx-search"></i></span>
                                </div>
                            </div>
                            <div class="col-sm-4 text-center">
                                <button wire:click="toggleAdvancedSearch3" class="btn btn-link">Toggle Advanced Search</button>
                            </div>
                        </div>
    
                        <div class="pt-2" {{ !$showAdvancedSearch3 ? 'hidden' : '' }}>
                            <div class="card">
                                <div class="card-body">
                                    <form class="row" wire:submit.prevent="performAdvancedSearch3">
                                        @csrf
                                        <div class="col-md-3 mb-3" wire:ignore>
                                            <select class="form-select" wire:model="leaveTypeIdAdvancedSearchField3" id="leaveTypeIdAdvancedSearchField3">
                                                <option value="">Leave Type</option>
                                                @foreach (getLeaveTypes('') as $row)
                                                    <option value="{{ $row->id }}">{{ $row->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3 mb-3" wire:ignore>
                                            <select class="form-select" wire:model="monthAdvancedSearchField3" id="monthAdvancedSearchField3">
                                                <option value="">Month</option>
                                                @foreach (months() as $key => $value)
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <input type="search" class="form-control" wire:model="yearAdvancedSearchField3" placeholder="Year">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <input type="search" class="form-control" wire:model="valueAdvancedSearchField3" placeholder="Value">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <input type="search" class="form-control" wire:model="dateFromAdvancedSearchField3" placeholder="Date From">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <input type="search" class="form-control" wire:model="dateToAdvancedSearchField3" placeholder="Date To">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <input type="search" class="form-control" wire:model="remarksAdvancedSearchField3" placeholder="Remarks">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="search" class="form-control" wire:model="dateCreatedAdvancedSearchField3" placeholder="Date Created">
                                        </div>
                                        <div class="col-md-3">
                                            <button type="submit" class="btn btn-primary" >Search</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!--table3-->
                            <div class="table-responsive">
                                <table class="table mb-0 table-striped">
                                    <thead>
                                        <tr>
                                            <th class="cursor-pointer" wire:click="sortBy('hlcal', 'hlcal.created_at')">
                                                #
                                                @if ($sortField2 === 'hlcal.created_at')
                                                    @if ($sortDirection2 === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                                @endif
                                            </th>
                                            <th class="cursor-pointer" wire:click="sortBy('hlcal', 'llt.name')">
                                                Leave Type
                                                @if ($sortField2 === 'llt.name')
                                                    @if ($sortDirection2 === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                                @endif
                                            </th>
                                            <th class="cursor-pointer" wire:click="sortBy('hlcal', 'hlcal.month')">
                                                Month
                                                @if ($sortField2 === 'hlcal.month')
                                                    @if ($sortDirection2 === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                                @endif
                                            </th>
                                            <th class="cursor-pointer" wire:click="sortBy('hlcal', 'hlcal.year')">
                                                Year
                                                @if ($sortField2 === 'hlcal.year')
                                                    @if ($sortDirection2 === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                                @endif
                                            </th>
                                            <th class="cursor-pointer" wire:click="sortBy('hlcal', 'hlcal.value')">
                                                Value
                                                @if ($sortField2 === 'hlcal.value')
                                                    @if ($sortDirection2 === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                                @endif
                                            </th>
                                            <th class="cursor-pointer" wire:click="sortBy('hlcal', 'hlcal.date_from')">
                                                Date From
                                                @if ($sortField2 === 'hlcal.date_from')
                                                    @if ($sortDirection2 === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                                @endif
                                            </th>
                                            <th class="cursor-pointer" wire:click="sortBy('hlcal', 'hlcal.date_to')">
                                                Date To
                                                @if ($sortField2 === 'hlcal.date_to')
                                                    @if ($sortDirection2 === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                                @endif
                                            </th>
                                            <th class="cursor-pointer" wire:click="sortBy('hlcal', 'hlcal.remarks')">
                                                Remarks
                                                @if ($sortField2 === 'hlcal.remarks')
                                                    @if ($sortDirection2 === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                                @endif
                                            </th>
                                            <th class="cursor-pointer" wire:click="sortBy('hlcal', 'hlcal.created_at')">
                                                Date Created
                                                @if ($sortField2 === 'hlcal.created_at')
                                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                                @endif
                                            </th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($tableList3)
                                            @if($tableList3->count() > 0)
                                                @foreach ($tableList3 as $row)
                                                    <tr>
                                                        <td>{{ ++ $counter3 }}</td>
                                                        <td>{{ $row->llt_name }}</td>
                                                        <td>{{ $row->month }}</td>
                                                        <td>{{ $row->year }}</td>
                                                        <td>{{ $row->value }}</td>
                                                        <td>{{ $row->date_from }}</td>
                                                        <td>{{ $row->date_to }}</td>
                                                        <td>{{ $row->remarks }}</td>
                                                        <td>{{ $row->formatted_created_at }}</td>
                                                        <td>
                                                            <div class="btn-group" role="group" aria-label="Action Button">
                                                                <button class="btn btn-primary btn-sm" wire:click="editleavecredits('{{ $row->id }}')">
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
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        <!--end table3-->

                        <div class="row pt-3">
                            <div class="col-sm-9">{{ $tableList3->links() }}</div>
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
                                Showing {{ number_format($tableList3->firstItem(), 0) }} to {{ number_format($tableList3->lastItem(), 0) }} of {{ number_format($tableList3->total(), 0) }} entries
                            </div>
                            <div class="col-sm-3">
                                <div class="row">
                                    Total entries: {{ $totalTableDataCount3 }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                            <th class="cursor-pointer" wire:click="sortBy('hlca.firstname')">
                                User Name
                                @if ($sortField === 'hlca.firstname')
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
                                    <td>{{ $row->upi_firstname }} {{ $row->upi_lastname }}</td>
                                    <td>{{ $row->tracking_code }}</td>
                                    <td>{{ $row->llt_name }}</td>
                                    <td>{{ $row->date_from }}</td>
                                    <td>{{ $row->date_to }}</td>
                                    <td>{{ $row->days }}</td>
                                    <td>{{ $row->is_with_pay }}</td>
                                    <td>
                                        @if ($row->status == 'Approved')
                                            <span class="badge bg-success">{{ $row->status }}</span>
                                        @elseif ($row->status == 'Disapproved')
                                            <span class="badge bg-danger">{{ $row->status }}</span>
                                        @elseif ($row->status == 'Cancelled')
                                            <span class="badge bg-warning">{{ $row->status }}</span>
                                        @elseif ($row->status == 'Processing')
                                            <span class="badge bg-info">{{ $row->status }}</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $row->status }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $row->remarks }}</td>
                                    <td>{{ $row->formatted_created_at }}</td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Action Buttons">
                                            <button class="btn btn-success btn-sm" wire:click="print('{{ $row->id }}')">
                                                <i class="bx bx-printer me-0"></i>
                                            </button>
                                            @if ($row->status != 'Approved')
                                                <button class="btn btn-primary btn-sm" wire:click="edit('{{ $row->id }}')">
                                                    <i class="bx bx-edit me-0"></i>
                                                </button>
                                            @endif
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
                                <td colspan="12"><div class="text-center">No results found.</div></td>
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
                        {{ $isUpdateMode ? 'Edit Leave' : 'Add New Leave' }}
                    </h5>
                    <button type="button" class="btn-close" wire:click="closeModal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="{{ $isUpdateMode ? 'updateleave' : 'addleave' }}">
                    @csrf
                    <div class="row modal-body">
                        <div class="col-md-6 mb-3" wire:ignore>
                            <label class="form-label">Leave Type <span style="color: red;">*</span></label>
                            <select class="form-select" wire:model="leave_type_id" data-placeholder="Select" id="leave_type_id" required>
                                <option value="">Select</option>
                                @foreach (getLeaveTypes('') as $row)
                                    <option value="{{ $row->id }}">{{ $row->name }}</option>
                                @endforeach
                            </select>
                            @error('leave_type_id')
                                <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3" wire:ignore>
                            <label class="form-label">Is With Pay? <span style="color: red;">*</span></label>
                            <select class="form-select" wire:model="is_with_pay" data-placeholder="Select" id="is_with_pay" required>
                                <option value="">Select</option>
                                @foreach (yesNo() as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                            @error('is_with_pay')
                                <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Date From <span style="color: red;">*</span></label>
                            <input type="date" class="form-control" placeholder="Date From" wire:model="date_from" required wire:change="calculateDays">
                            @error('date_from')
                                <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Date To <span style="color: red;">*</span></label>
                            <input type="date" class="form-control" placeholder="Date To" wire:model="date_to" required wire:change="calculateDays">
                            @error('date_to')
                                <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Days <span style="color: red;">*</span></label>
                            <input type="text" class="form-control" placeholder="Days" wire:model="days" required>
                            @error('days')
                                <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="remarks" class="form-label">Remarks</label>
                            <textarea class="form-control" wire:model="remarks" id="remarks" placeholder="Remarks" rows="3"></textarea>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label><b>In case of Vacation/Special Privilege Leave:</b></label>
                        </div>
                        <div class="col-md-6 mb-3" wire:ignore>
                            <label class="form-label">Within the Philippines?</label>
                            <select class="form-select" wire:model="details_b1" data-placeholder="Select" id="details_b1">
                                <option value="">Select</option>
                                @foreach (yesNo() as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                            @error('details_b1')
                                <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Specify</label>
                            <input type="text" class="form-control" placeholder="Specify" wire:model="details_b1_name">
                            @error('details_b1_name')
                                <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label><b>In case of Sick Leave:</b></label>
                        </div>
                        <div class="col-md-6 mb-3" wire:ignore>
                            <label class="form-label">In Hospital?</label>
                            <select class="form-select" wire:model="details_b2" data-placeholder="Select" id="details_b2">
                                <option value="">Select</option>
                                @foreach (yesNo() as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                            @error('details_b2')
                                <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Specify Illness</label>
                            <input type="text" class="form-control" placeholder="Specify Illness" wire:model="details_b2_name">
                            @error('details_b2_name')
                                <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label><b>In case of Special Leave Benefits for Women:</b></label>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Specify Illness</label>
                            <input type="text" class="form-control" placeholder="Specify Illness" wire:model="details_b3_name">
                            @error('details_b3_name')
                                <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label><b>In case of Study Leave:</b></label>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label><b>Other purpose:</b></label>
                        </div>

                        <div class="col-md-6 mb-3" wire:ignore>
                            <label class="form-label">Completion of<br>Master's Degree?</label>
                            <select class="form-select" wire:model="details_b4" data-placeholder="Select" id="details_b4">
                                <option value="">Select</option>
                                @foreach (yesNo() as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                            @error('details_b4')
                                <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3" wire:ignore>
                            <label class="form-label">Monetization of<br>Leave Credits?</label>
                            <select class="form-select" wire:model="details_b5" data-placeholder="Select" id="details_b5">
                                <option value="">Select</option>
                                @foreach (yesNo() as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                            @error('details_b5')
                                <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        
                        <div class="col-md-6 mb-3" wire:ignore>
                            <label class="form-label">Commutation Requested?</label>
                            <select class="form-select" wire:model="details_d1" data-placeholder="Select" id="details_d1">
                                <option value="">Select</option>
                                @foreach (yesNo() as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                            @error('details_d1')
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
                    <button type="button" class="btn-close" wire:click="closeDeletionModal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="deleteleavecredits">
                    <div class="modal-body">
                        <p>Are you sure you want to delete this record?</p>
                        <p>Leave Type: <b>{{ $hlcalId }}</b> </p>
                        <p>Month: <b>{{ $month3 }}</b> </p>
                        <p>Year: <b>{{ $year3 }}</b> </p>
                        <p>Value: <b>{{ $value3 }}</b> </p>
                        <p>Date From: <b>{{ $date_from3 }}</b> </p>
                        <p>Date To: <b>{{ $date_to3 }}</b> </p>
                        <p>Remarks: <b>{{ $remarks3 }}</b> </p>
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
                });
            });

            @this.on('openModelAddLeaveCreditsModal', (data) => {
                $('#modelAddLeaveCreditsModal').modal('show');
                $('#modelAddLeaveCreditsModal').on('shown.bs.modal', function (e) {
                    $('#leaveTypeIdAdvancedSearchField3').select2( {
                        dropdownParent: $('#modelAddLeaveCreditsModal'),
                        theme: "bootstrap-5",
                        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                        placeholder: $( this ).data( 'placeholder' ),
                        closeOnSelect: true,
                    });
                    $('#leaveTypeIdAdvancedSearchField3').on('change', function (e) {
                        @this.set('leaveTypeIdAdvancedSearchField3', $(this).val());
                    });
                    
                    $('#monthAdvancedSearchField3').select2( {
                        dropdownParent: $('#modelAddLeaveCreditsModal'),
                        theme: "bootstrap-5",
                        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                        placeholder: $( this ).data( 'placeholder' ),
                        closeOnSelect: true,
                    });
                    $('#monthAdvancedSearchField3').on('change', function (e) {
                        @this.set('monthAdvancedSearchField3', $(this).val());
                    });
                });
            });

            @this.on('closeModal', (data) => {
                $('#modelCreateUpdateModal').modal('hide');
                $('#modelAddLeaveCreditsModal').modal('hide');
            });

            @this.on('openDeletionModal', (data) => {
                $('#modelDeletionModal').modal('show');
            });

            @this.on('closeDeletionModal', (data) => {
                $('#modelDeletionModal').modal('hide');
            });

            @this.on('openNewWindow', (data) => {
                var url = data[0].viewFileUrl;
                var newWindow = window.open(url, "Print Form No. 6", "width="+screen.availWidth+",height="+screen.availHeight)
                newWindow.onload = function() {
                    newWindow.print();
                };
            });

            advanceSearchSelect2();
        });

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