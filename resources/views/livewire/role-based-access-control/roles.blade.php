<div>
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Role-Based Access Control</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Roles</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->

    {{-- component modal --}}
    @if ($showModal)
        <x-modal wire:model='showModal' :modalTitle="$modalTitle" :modalSize="$modalSize" :modalAction="$modalAction">
            @if ($modalAction === 'Create')
                <div>
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control" placeholder="Name" required wire:model="name" x-ref="focusMe" x-init="$nextTick(() => { $refs.focusMe.focus() })">
                    @error('name')
                        <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                    @enderror
                </div>
            @endif

            @if ($modalAction === 'Delete')
                <div>
                    <p>Are you sure you want to delete this record?</p>
                    <p>Name: <b>{{ $name }}</b> </p>
                </div>
            @endif
        </x-modal>
    @endif
    {{-- end component modal --}}

    <!--table-->
    <div class="card">
        <div class="card-body"> 
            <div class="row pb-3">
                <div class="col-sm-2 text-center">
                    <button type="button" class="btn btn-primary" @click="$dispatch('showModalListener', ['Add New Role', 'modal-sm', 'Create'])"><i class="bx bx-plus-circle me-0"></i> Add New</button>
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

            @if ($showAdvancedSearch)
                <div class="pt-2">
                    <div class="card">
                        <div class="card-body"> 
                            <form class="row" wire:submit.prevent="performAdvancedSearch">
                                @csrf
                                <div class="col-md-3 mb-3">
                                    <input type="search" class="form-control" wire:model="nameAdvancedSearchField" placeholder="Name">
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
            @endif

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
                            <th class="cursor-pointer" wire:click="sortBy('name')">
                                Name
                                @if ($sortField === 'name')
                                    @if ($sortDirection === 'asc') <i class="bx bx-sort-up"></i> @else <i class="bx bx-sort-down"></i> @endif
                                @endif
                            </th>
                            <th class="cursor-pointer" wire:click="sortBy('created_at')">
                                Date Created
                                @if ($sortField === 'created_at')
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
                                    <td>{{ $row->name }}</td>
                                    <td>{{ $row->formatted_created_at }}</td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Action Buttons">
                                            <button data-bs-toggle="modal" data-bs-target="#paymentServicesModal" class="btn btn-primary btn-sm" wire:click="edit('{{ $row->id }}')">
                                                <i class="bx bx-edit me-0"></i>
                                            </button>
                                            {{-- <button data-bs-toggle="modal" data-bs-target="#paymentServicesDeletionModal" class="btn btn-danger btn-sm" wire:click="toBeDeleted('{{ $row->id }}')">
                                                <i class="bx bx-trash me-0"></i>
                                            </button> --}}
                                            <button type="button" class="btn btn-danger" @click="$dispatch('showModalListener', ['Delete Role', 'modal-sm', 'Delete'])" wire:click="toBeDeleted('{{ $row->id }}')">
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
</div>