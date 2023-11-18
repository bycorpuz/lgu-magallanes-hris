<div> 
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">HUMAN RESOURCE - User Management</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('my-profile') }}"><i class="bx bx-user-circle"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Users</li>
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
                            <div class="col-md-3 mb-3">
                                <input type="search" class="form-control" wire:model="firstNameAdvancedSearchField" placeholder="First Name">
                            </div>
                            <div class="col-md-3 mb-3">
                                <input type="search" class="form-control" wire:model="middleNameAdvancedSearchField" placeholder="Middle Name">
                            </div>
                            <div class="col-md-3 mb-3">
                                <input type="search" class="form-control" wire:model="lastNameAdvancedSearchField" placeholder="Last Name">
                            </div>
                            <div class="col-md-3 mb-3">
                                <input type="search" class="form-control" wire:model="extNameAdvancedSearchField" placeholder="Extension Name">
                            </div>
                            <div class="col-md-3 mb-3" wire:ignore>
                                <select class="form-select" wire:model="userIdAdvancedSearchField" id="userIdAdvancedSearchField">
                                    <option value="">User Name</option>
                                    @foreach (getUsers('') as $row)
                                        <option value="{{ $row->id }}">{{ $row->upi_firstname }} {{ $row->upi_lastname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <input type="search" class="form-control" wire:model="emailAdvancedSearchField" placeholder="Email">
                            </div>
                            <div class="col-md-3 mb-3">
                                <input type="search" class="form-control" wire:model="usernameAdvancedSearchField" placeholder="Username">
                            </div>
                            <div class="col-md-3 mb-3">
                                <input type="search" class="form-control" wire:model="mobileNoAdvancedSearchField" placeholder="Mobile No.">
                            </div>
                            <div class="col-md-3 mb-3">
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
                            <th colspan="5" class="text-center">User Name</th>
                            <th colspan="5" class="text-center">Other Information</th>
                        </tr>
                        <tr>
                            <th class="cursor-pointer" wire:click="sortBy('u.created_at')">
                                #
                                @if ($sortField === 'u.created_at')
                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                @endif
                            </th>
                            <th class="cursor-pointer" wire:click="sortBy('upi.firstname')">
                                First
                                @if ($sortField === 'upi.firstname')
                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                @endif
                            </th>
                            <th class="cursor-pointer" wire:click="sortBy('upi.middlename')">
                                Middle
                                @if ($sortField === 'upi.middlename')
                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                @endif
                            </th>
                            <th class="cursor-pointer" wire:click="sortBy('upi.lastname')">
                                Last
                                @if ($sortField === 'upi.lastname')
                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                @endif
                            </th>
                            <th class="cursor-pointer" wire:click="sortBy('upi.extname')">
                                Extension
                                @if ($sortField === 'upi.extname')
                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                @endif
                            </th>
                            <th class="cursor-pointer" wire:click="sortBy('u.email')">
                                Email
                                @if ($sortField === 'u.email')
                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                @endif
                            </th>
                            <th class="cursor-pointer" wire:click="sortBy('u.email')">
                                Username
                                @if ($sortField === 'u.email')
                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                @endif
                            </th>
                            <th class="cursor-pointer" wire:click="sortBy('upi.mobile_no')">
                                Mobile No.
                                @if ($sortField === 'upi.mobile_no')
                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                @endif
                            </th>
                            <th class="cursor-pointer" wire:click="sortBy('u.created_at')">
                                Date Created
                                @if ($sortField === 'u.created_at')
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
                                    <td>{{ $row->firstname }}</td>
                                    <td>{{ $row->middlename }}</td>
                                    <td>{{ $row->lastname }}</td>
                                    <td>{{ $row->extname }}</td>
                                    <td>{{ $row->email }}</td>
                                    <td>{{ $row->username }}</td>
                                    <td>{{ $row->mobile_no }}</td>
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modelCreateUpdateModalLabel">
                        {{ $isUpdateMode ? 'Edit User' : 'Add New User' }}
                    </h5>
                    <button type="button" class="btn-close" wire:click="closeModal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="{{ $isUpdateMode ? 'update' : 'store' }}">
                    @csrf
                    <div class="row modal-body">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">First Name <span style="color: red;">*</span></label>
                            <input type="text" class="form-control" placeholder="First Name" id="focusMe" wire:model="firstname" wire:keyup="generateUsername" required>
                            @error('firstname')
                                <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Middle Name</label>
                            <input type="text" class="form-control" placeholder="Middle Name" wire:model="middlename" wire:keyup="generateUsername">
                            @error('middlename')
                                <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Last Name <span style="color: red;">*</span></label>
                            <input type="text" class="form-control" placeholder="Last Name" wire:model="lastname" wire:keyup="generateUsername" required>
                            @error('lastname')
                                <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-3" wire:ignore>
                            <label class="form-label">Extension Name</label>
                            <select class="form-select" wire:model="extname" data-placeholder="Select" id="extname">
                                <option value="">Select</option>
                                @foreach (extName() as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                            @error('extname')
                                <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Date of Birth <span style="color: red;">*</span></label>
                            <input type="date" class="form-control" placeholder="Date of Birth" wire:model="date_of_birth" required>
                            @error('date_of_birth')
                                <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-9 mb-3">
                            <label class="form-label">Place of Birth</label>
                            <input type="text" class="form-control" placeholder="Place of Birth" wire:model="place_of_birth">
                            @error('place_of_birth')
                                <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-3" wire:ignore>
                            <label class="form-label">Sex <span style="color: red;">*</span></label>
                            <select class="form-select" wire:model="sex" data-placeholder="Select" id="sex" required>
                                <option value="">Select</option>
                                @foreach (sex() as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                            @error('sex')
                                <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-3" wire:ignore>
                            <label class="form-label">Civil Status <span style="color: red;">*</span></label>
                            <select class="form-select" wire:model="civil_status" data-placeholder="Select" id="civil_status" required>
                                <option value="">Select</option>
                                @foreach (civilStatus() as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                            @error('civil_status')
                                <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Telephone No.</label>
                            <input type="text" class="form-control" placeholder="Telephone No." wire:model="tel_no">
                            @error('tel_no')
                                <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Mobile No.</label>
                            <input type="text" class="form-control" placeholder="Mobile No." wire:model="mobile_no">
                            @error('mobile_no')
                                <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email <span style="color: red;">*</span></label>
                            <input type="text" class="form-control" placeholder="Email" wire:model="email" required>
                            @error('email')
                                <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Username <span style="color: red;">*</span></label>
                            <input type="text" class="form-control" placeholder="Username" wire:model="username" required>
                            @error('username')
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
                        <p>First Name: <b>{{ $firstname }}</b> </p>
                        <p>Middle Name: <b>{{ $middlename }}</b> </p>
                        <p>Last Name: <b>{{ $lastname }}</b> </p>
                        <p>Extension Name: <b>{{ $extname }}</b> </p>
                        <p>Date of Birth: <b>{{ $date_of_birth }}</b> </p>
                        <p>Place of Birth: <b>{{ $place_of_birth }}</b> </p>
                        <p>Sex: <b>{{ $sex }}</b> </p>
                        <p>Civil Status: <b>{{ $civil_status }}</b> </p>
                        <p>Telephone No.: <b>{{ $tel_no }}</b> </p>
                        <p>Mobile No.: <b>{{ $mobile_no }}</b> </p>
                        <hr>
                        <p>Email: <b>{{ $email }}</b> </p>
                        <p>Username: <b>{{ $username }}</b> </p>
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

                    $('#extname').select2( {
                        dropdownParent: $('#modelCreateUpdateModal'),
                        theme: "bootstrap-5",
                        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                        placeholder: $( this ).data( 'placeholder' ),
                        closeOnSelect: true,
                        allowClear: true,
                    });
                    $('#extname').on('change', function (e) {
                        @this.set('extname', $(this).val());
                    });

                    $('#sex').select2( {
                        dropdownParent: $('#modelCreateUpdateModal'),
                        theme: "bootstrap-5",
                        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                        placeholder: $( this ).data( 'placeholder' ),
                        closeOnSelect: true,
                    });
                    $('#sex').on('change', function (e) {
                        @this.set('sex', $(this).val());
                    });

                    $('#civil_status').select2( {
                        dropdownParent: $('#modelCreateUpdateModal'),
                        theme: "bootstrap-5",
                        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                        placeholder: $( this ).data( 'placeholder' ),
                        closeOnSelect: true,
                    });
                    $('#civil_status').on('change', function (e) {
                        @this.set('civil_status', $(this).val());
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
        }
    </script>
@endpush