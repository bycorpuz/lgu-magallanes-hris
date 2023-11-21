<div> 
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">MAIN NAVIGATION</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('my-profile') }}"><i class="bx bx-user-circle"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">My Leave</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <button type="button" class="btn btn-primary">Settings</button>
                <button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">	<span class="visually-hidden">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
                    <a class="dropdown-item" href="javascript:;" wire:click="openCreateUpdateSignatoriesModal">Set Signatories</a>
                </div>
            </div>
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
                            <th class="cursor-pointer" wire:click="sortBy('u.created_at')">
                                #
                                @if ($sortField === 'hl.created_at')
                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                @endif
                            </th>
                            <th class="cursor-pointer" wire:click="sortBy('hl.tracking_code')">
                                Tracking Code
                                @if ($sortField === 'hl.tracking_code')
                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                @endif
                            </th>
                            <th class="cursor-pointer" wire:click="sortBy('llt.name')">
                                Leave Type
                                @if ($sortField === 'llt.name')
                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                @endif
                            </th>
                            <th class="cursor-pointer" wire:click="sortBy('hl.date_from')">
                                Date From
                                @if ($sortField === 'hl.date_from')
                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                @endif
                            </th>
                            <th class="cursor-pointer" wire:click="sortBy('hl.date_to')">
                                Date To
                                @if ($sortField === 'hl.date_to')
                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                @endif
                            </th>
                            <th class="cursor-pointer" wire:click="sortBy('hl.days')">
                                Days
                                @if ($sortField === 'hl.days')
                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                @endif
                            </th>
                            <th class="cursor-pointer" wire:click="sortBy('hl.is_with_pay')">
                                Is With Pay?
                                @if ($sortField === 'hl.is_with_pay')
                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                @endif
                            </th>
                            <th class="cursor-pointer" wire:click="sortBy('hl.status')">
                                Status
                                @if ($sortField === 'hl.status')
                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                @endif
                            </th>
                            <th class="cursor-pointer" wire:click="sortBy('hl.remarks')">
                                Remarks
                                @if ($sortField === 'hl.remarks')
                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                @endif
                            </th>
                            <th class="cursor-pointer" wire:click="sortBy('u.created_at')">
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
                                        @if ($row->status != 'Pending')
                                            <div class="btn-group" role="group" aria-label="Action Buttons">
                                                <button class="btn btn-success btn-sm" wire:click="print('{{ $row->id }}')">
                                                    <i class="bx bx-printer me-0"></i>
                                                </button>
                                            </div>
                                        @else
                                            <div class="btn-group" role="group" aria-label="Action Buttons">
                                                <button class="btn btn-success btn-sm" wire:click="print('{{ $row->id }}')">
                                                    <i class="bx bx-printer me-0"></i>
                                                </button>
                                                <button class="btn btn-primary btn-sm" wire:click="edit('{{ $row->id }}')">
                                                    <i class="bx bx-edit me-0"></i>
                                                </button>
                                                <button class="btn btn-danger btn-sm" wire:click="toBeDeleted('{{ $row->id }}')">
                                                    <i class="bx bx-trash me-0"></i>
                                                </button>
                                            </div>
                                        @endif
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
                        {{ $isUpdateMode ? 'Edit Leave' : 'Add New Leave' }}
                    </h5>
                    <button type="button" class="btn-close" wire:click="closeModal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="{{ $isUpdateMode ? 'update' : 'store' }}">
                    @csrf
                    <div class="row modal-body">
                        <div class="col-md-6 mb-3" wire:ignore>
                            <label class="form-label">Leave Type <span style="color: red;">*</span></label>
                            <select class="form-select" wire:model="leave_type_id" data-placeholder="Select" id="leave_type_id" required id="focusMe">
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
                    <h5 class="modal-title" id="modelDeletionModalLabel">Delete User</h5>
                    <button type="button" class="btn-close" wire:click="closeModal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="delete">
                    <div class="modal-body">
                        <p>Are you sure you want to delete this record?</p>
                        <p>Tracking Code: <b>{{ $tracking_code }}</b> </p>
                        <p>Leave Type: <b>{{ $leave_type_id ? getLeaveTypes($leave_type_id)['name'] : '' }}</b> </p>
                        <p>Date From: <b>{{ $date_from }}</b> </p>
                        <p>Date To: <b>{{ $date_to }}</b> </p>
                        <p>Days: <b>{{ $days }}</b> </p>
                        <p>Is With Pay?: <b>{{ $is_with_pay }}</b> </p>
                        <p>Status: <b>{{ $status }}</b> </p>
                        <p>remarks: <b>{{ $remarks }}</b> </p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger close-modal" data-dismiss="modal">Yes, Delete it.</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end modal(delete)-->

    <!--modal(create and update signatories)-->
    <div wire:ignore.self class="modal fade" id="modelCreateUpdateSignatoriesModal" tabindex="-1" role="dialog" aria-labelledby="modelCreateUpdateSignatoriesModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modelCreateUpdateSignatoriesModalLabel">
                        Edit Signatories
                    </h5>
                    <button type="button" class="btn-close" wire:click="closeModal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="updatesignatories">
                    @csrf
                    <div class="row modal-body">
                        <div class="col-md-6 mb-3" wire:ignore>
                            <label class="form-label">Certification Signatory</label>
                            <select class="form-select" wire:model="param1_signatory" data-placeholder="Select" id="param1_signatory" required>
                                <option value="">Select</option>
                                @foreach (getUsers('') as $row)
                                    <option value="{{ $row->id }}">{{ $row->upi_firstname }} {{ $row->upi_lastname }}</option>
                                @endforeach
                            </select>
                            @error('param1_signatory')
                                <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3" wire:ignore>
                            <label class="form-label">Certification Designation</label>
                            <select class="form-select" wire:model="param1_designation" data-placeholder="Select" id="param1_designation" required>
                                <option value="">Select</option>
                                @foreach (getDesignations('') as $row)
                                    <option value="{{ $row->id }}">{{ $row->name }}</option>
                                @endforeach
                            </select>
                            @error('param1_designation')
                                <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3" wire:ignore>
                            <label class="form-label">Recommendation Signatory</label>
                            <select class="form-select" wire:model="param2_signatory" data-placeholder="Select" id="param2_signatory" required>
                                <option value="">Select</option>
                                @foreach (getUsers('') as $row)
                                    <option value="{{ $row->id }}">{{ $row->upi_firstname }} {{ $row->upi_lastname }}</option>
                                @endforeach
                            </select>
                            @error('param2_signatory')
                                <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3" wire:ignore>
                            <label class="form-label">Recommendation Designation</label>
                            <select class="form-select" wire:model="param2_designation" data-placeholder="Select" id="param2_designation" required>
                                <option value="">Select</option>
                                @foreach (getDesignations('') as $row)
                                    <option value="{{ $row->id }}">{{ $row->name }}</option>
                                @endforeach
                            </select>
                            @error('param2_designation')
                                <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3" wire:ignore>
                            <label class="form-label">Approval Signatory</label>
                            <select class="form-select" wire:model="param3_signatory" data-placeholder="Select" id="param3_signatory" required>
                                <option value="">Select</option>
                                @foreach (getUsers('') as $row)
                                    <option value="{{ $row->id }}">{{ $row->upi_firstname }} {{ $row->upi_lastname }}</option>
                                @endforeach
                            </select>
                            @error('param3_signatory')
                                <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3" wire:ignore>
                            <label class="form-label">Approval Designation</label>
                            <select class="form-select" wire:model="param3_designation" data-placeholder="Select" id="param3_designation" required>
                                <option value="">Select</option>
                                @foreach (getDesignations('') as $row)
                                    <option value="{{ $row->id }}">{{ $row->name }}</option>
                                @endforeach
                            </select>
                            @error('param3_designation')
                                <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end modal(create and update signatories)-->
</div>

@push('scripts')
    <script type="text/javascript">
        document.addEventListener('livewire:initialized', () => {
            @this.on('openCreateUpdateModal', (data) => {
                $('#modelCreateUpdateModal').modal('show');
                $('#modelCreateUpdateModal').on('shown.bs.modal', function (e) {
                    $('#leave_type_id').select2( {
                        container: 'body',
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
            
            @this.on('openDeletionModal', (data) => {
                $('#modelDeletionModal').modal('show');
            });

            @this.on('closeModal', (data) => {
                $('#modelCreateUpdateModal').modal('hide');
                $('#modelDeletionModal').modal('hide');
                $('#modelCreateUpdateSignatoriesModal').modal('hide');
            });
            
            @this.on('openNewWindow', (data) => {
                var url = data[0].viewFileUrl;
                var newWindow = window.open(url, "Print Form No. 6", "width="+screen.availWidth+",height="+screen.availHeight)
                newWindow.onload = function() {
                    newWindow.print();
                };
            });

            @this.on('openCreateUpdateSignatoriesModal', (data) => {
                $('#modelCreateUpdateSignatoriesModal').modal('show');
                $('#modelCreateUpdateSignatoriesModal').on('shown.bs.modal', function (e) {
                    $('#param1_signatory').select2( {
                        container: 'body',
                        dropdownParent: $('#modelCreateUpdateSignatoriesModal'),
                        theme: "bootstrap-5",
                        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                        placeholder: $( this ).data( 'placeholder' ),
                        closeOnSelect: true,
                    });
                    $('#param1_signatory').on('change', function (e) {
                        @this.set('param1_signatory', $(this).val());
                    });
                    
                    $('#param1_designation').select2( {
                        container: 'body',
                        dropdownParent: $('#modelCreateUpdateSignatoriesModal'),
                        theme: "bootstrap-5",
                        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                        placeholder: $( this ).data( 'placeholder' ),
                        closeOnSelect: true,
                    });
                    $('#param1_designation').on('change', function (e) {
                        @this.set('param1_designation', $(this).val());
                    });
                    
                    $('#param2_signatory').select2( {
                        container: 'body',
                        dropdownParent: $('#modelCreateUpdateSignatoriesModal'),
                        theme: "bootstrap-5",
                        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                        placeholder: $( this ).data( 'placeholder' ),
                        closeOnSelect: true,
                    });
                    $('#param2_signatory').on('change', function (e) {
                        @this.set('param2_signatory', $(this).val());
                    });
                    
                    $('#param2_designation').select2( {
                        container: 'body',
                        dropdownParent: $('#modelCreateUpdateSignatoriesModal'),
                        theme: "bootstrap-5",
                        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                        placeholder: $( this ).data( 'placeholder' ),
                        closeOnSelect: true,
                    });
                    $('#param2_designation').on('change', function (e) {
                        @this.set('param2_designation', $(this).val());
                    });
                    
                    $('#param3_signatory').select2( {
                        container: 'body',
                        dropdownParent: $('#modelCreateUpdateSignatoriesModal'),
                        theme: "bootstrap-5",
                        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                        placeholder: $( this ).data( 'placeholder' ),
                        closeOnSelect: true,
                    });
                    $('#param3_signatory').on('change', function (e) {
                        @this.set('param3_signatory', $(this).val());
                    });
                    
                    $('#param3_designation').select2( {
                        container: 'body',
                        dropdownParent: $('#modelCreateUpdateSignatoriesModal'),
                        theme: "bootstrap-5",
                        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                        placeholder: $( this ).data( 'placeholder' ),
                        closeOnSelect: true,
                    });
                    $('#param3_designation').on('change', function (e) {
                        @this.set('param3_designation', $(this).val());
                    });
                });
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