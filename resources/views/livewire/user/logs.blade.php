<div>    
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">HUMAN RESOURCE - User Management</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('my-profile') }}"><i class="bx bx-user-circle"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">User Logs</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    
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
                                <input type="search" class="form-control" wire:model="actionAdvancedSearchField" placeholder="Action">
                            </div>
                            <div class="col-md-3 mb-3">
                                <input type="search" class="form-control" wire:model="moduleAdvancedSearchField" placeholder="Module">
                            </div>
                            <div class="col-md-3">
                                <input type="search" class="form-control" wire:model="dataAdvancedSearchField" placeholder="Data">
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
                            <th class="cursor-pointer" wire:click="sortBy('user_id')">
                                User Name
                                @if ($sortField === 'user_id')
                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                @endif
                            </th>
                            <th class="cursor-pointer" wire:click="sortBy('email')">
                                Email
                                @if ($sortField === 'email')
                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                @endif
                            </th>
                            <th class="cursor-pointer" wire:click="sortBy('action')">
                                Action
                                @if ($sortField === 'action')
                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                @endif
                            </th>
                            <th class="cursor-pointer" wire:click="sortBy('module')">
                                Module
                                @if ($sortField === 'module')
                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                @endif
                            </th>
                            <th class="cursor-pointer" wire:click="sortBy('data')">
                                Data
                                @if ($sortField === 'data')
                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                @endif
                            </th>
                            <th class="cursor-pointer" wire:click="sortBy('created_at')">
                                Date Created
                                @if ($sortField === 'created_at')
                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                @endif
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($tableList->count() > 0)
                            @foreach ($tableList as $row)
                                <tr>
                                    <td>{{ ++ $counter }}</td>
                                    <td>{{ $row->upi_firstname }} {{ $row->upi_lastname }}</td>
                                    <td>{{ $row->u_email }}</td>
                                    <td>{{ $row->action }}</td>
                                    <td>{{ $row->module }}</td>
                                    <td>
                                        <pre>
                                            {{ json_encode(json_decode($row->data), JSON_PRETTY_PRINT) }}
                                        </pre>
                                    </td>
                                    <td>{{ $row->formatted_created_at }}</td>
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
</div>

@push('scripts')
    <script type="text/javascript">
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