<div>
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-pills mb-3" role="tablist">
                <li class="nav-item" role="presentation">
                    <a wire:click.prevent="selectTab('personal_details')" class="nav-link {{ $tab == 'personal_details' ? 'active' : '' }}" data-bs-toggle="pill" href="#primary-pills-home" role="tab" aria-selected="true">
                        <div class="d-flex align-items-center">
                            <div class="tab-icon"><i class="bx bx-user-pin font-18 me-1"></i>
                            </div>
                            <div class="tab-title">Personal Details</div>
                        </div>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a wire:click.prevent="selectTab('update_password')" class="nav-link {{ $tab == 'update_password' ? 'active' : '' }}" data-bs-toggle="pill" href="#primary-pills-profile" role="tab" aria-selected="false" tabindex="-1">
                        <div class="d-flex align-items-center">
                            <div class="tab-icon"><i class="bx bx-message-alt-dots font-18 me-1"></i>
                            </div>
                            <div class="tab-title">Update Password</div>
                        </div>
                    </a>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade {{ $tab == 'personal_details' ? 'active show' : '' }}" id="primary-pills-home" role="tabpanel">
                    <div class="p-2">
                        <form wire:submit.prevent="updatePersonalDetails">
                            @csrf
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">First Name <span style="color: red;">*</span></label>
                                    <input type="text" class="form-control" placeholder="First Name" id="focusMe" wire:model="firstname" required>
                                    @error('firstname')
                                        <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Middle Name</label>
                                    <input type="text" class="form-control" placeholder="Middle Name" wire:model="middlename">
                                    @error('middlename')
                                        <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Last Name <span style="color: red;">*</span></label>
                                    <input type="text" class="form-control" placeholder="Last Name" wire:model="lastname" required>
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
                                    <label class="form-label">Other Extension</label>
                                    <input type="text" class="form-control" placeholder="Other Extension" wire:model="other_ext">
                                    @error('other_ext')
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
                                <div class="col-md-6 mb-3">
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
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="d-md-flex d-grid align-items-center gap-3 justify-content-end">
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="tab-pane fade {{ $tab == 'update_password' ? 'active show' : '' }}" id="primary-pills-profile" role="tabpanel">
                    <div class="p-2">
                        <form wire:submit.prevent="updatePassword">
                            @csrf
                            <div class="row mb-3">
                                <label for="current_password" class="col-sm-3 col-form-label">Current Password <span style="color: red;">*</span></label>
                                <div class="col-sm-9">
                                    <div class="input-group" id="show_hide_current_password">
                                        <input type="password" class="form-control border-end-0" id="current_password" placeholder="Current Password" wire:model='current_password'> <a href="javascript:;" class="input-group-text bg-transparent"><i class="bx bx-hide"></i></a>
                                    </div>
                                    @error('current_password')
                                        <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="new_password" class="col-sm-3 col-form-label">New Password <span style="color: red;">*</span></label>
                                <div class="col-sm-9">
                                    <div class="input-group" id="show_hide_new_password">
                                        <input type="password" class="form-control border-end-0" id="new_password" placeholder="New Password" wire:model='new_password'> <a href="javascript:;" class="input-group-text bg-transparent"><i class="bx bx-hide"></i></a>
                                    </div>
                                    @error('new_password')
                                        <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="new_password_confirmation" class="col-sm-3 col-form-label">Confirm New Password <span style="color: red;">*</span></label>
                                <div class="col-sm-9">
                                    <div class="input-group" id="show_hide_new_password_confirmation">
                                        <input type="password" class="form-control border-end-0" id="new_password_confirmation" placeholder="Retype New Password" wire:model='new_password_confirmation'> <a href="javascript:;" class="input-group-text bg-transparent"><i class="bx bx-hide"></i></a>
                                    </div>
                                    @error('new_password_confirmation')
                                        <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="d-md-flex d-grid align-items-center gap-3 justify-content-end">
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            showHideInput();
            personalDetailsSelect2();
        });

        function showHideInput(){
            $("#show_hide_current_password a").on('click', function (event) {
                event.preventDefault();
                if ($('#show_hide_current_password input').attr("type") == "text") {
                    $('#show_hide_current_password input').attr('type', 'password');
                    $('#show_hide_current_password i').addClass("bx-hide");
                    $('#show_hide_current_password i').removeClass("bx-show");
                } else if ($('#show_hide_current_password input').attr("type") == "password") {
                    $('#show_hide_current_password input').attr('type', 'text');
                    $('#show_hide_current_password i').removeClass("bx-hide");
                    $('#show_hide_current_password i').addClass("bx-show");
                }
            });
            
            $("#show_hide_new_password a").on('click', function (event) {
                event.preventDefault();
                if ($('#show_hide_new_password input').attr("type") == "text") {
                    $('#show_hide_new_password input').attr('type', 'password');
                    $('#show_hide_new_password i').addClass("bx-hide");
                    $('#show_hide_new_password i').removeClass("bx-show");
                } else if ($('#show_hide_new_password input').attr("type") == "password") {
                    $('#show_hide_new_password input').attr('type', 'text');
                    $('#show_hide_new_password i').removeClass("bx-hide");
                    $('#show_hide_new_password i').addClass("bx-show");
                }
            });
            
            $("#show_hide_new_password_confirmation a").on('click', function (event) {
                event.preventDefault();
                if ($('#show_hide_new_password_confirmation input').attr("type") == "text") {
                    $('#show_hide_new_password_confirmation input').attr('type', 'password');
                    $('#show_hide_new_password_confirmation i').addClass("bx-hide");
                    $('#show_hide_new_password_confirmation i').removeClass("bx-show");
                } else if ($('#show_hide_new_password_confirmation input').attr("type") == "password") {
                    $('#show_hide_new_password_confirmation input').attr('type', 'text');
                    $('#show_hide_new_password_confirmation i').removeClass("bx-hide");
                    $('#show_hide_new_password_confirmation i').addClass("bx-show");
                }
            });
        }

        function personalDetailsSelect2(){
            $('#extname').select2( {
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
                theme: "bootstrap-5",
                width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
                closeOnSelect: true,
            });
            $('#sex').on('change', function (e) {
                @this.set('sex', $(this).val());
            });

            $('#civil_status').select2( {
                theme: "bootstrap-5",
                width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
                closeOnSelect: true,
            });
            $('#civil_status').on('change', function (e) {
                @this.set('civil_status', $(this).val());
            });
        }
    </script>
@endpush