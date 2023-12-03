<div>
    <div class="card-body p-sm-5">
        <div class="">
            <div class="mb-3 text-center">
                <img src="/images/site/{{ getSiteSettings()->site_logo }}" width="150" alt="">
            </div>
            <div class="text-center mb-4">
                <h5 class="">{{ getSiteSettings()->site_name }}</h5>
                <p class="mb-0">Please log in to your account</p>
            </div>
            <div class="form-body">
                <form class="row g-3" wire:submit.prevent="loginHandler">
                    @if (Session::get('fail'))
                        <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show py-2">
                            <div class="d-flex align-items-center">
                                <div class="font-35 text-white"><i class="bx bxs-message-square-x"></i>
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-0 text-white">Error</h6>
                                    <div class="text-white">{{ Session::get('fail') }}</div>
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @elseif (Session::get('success'))
                        <div class="alert alert-success border-0 bg-success alert-dismissible fade show py-2">
                            <div class="d-flex align-items-center">
                                <div class="font-35 text-white"><i class="bx bxs-check-circle"></i>
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-0 text-white">Success</h6>
                                    <div class="text-white">{{ Session::get('success') }}</div>
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
        
                    <div class="col-12">
                        <label for="usernameEmailInput" class="form-label">Email or Username</label>
                        <input type="text" wire:model="emailUsername" class="form-control" id="usernameEmailInput" placeholder="Enter Email or Username">
                    
                        @error('emailUsername')
                            <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                        @enderror
                    </div>
        
                    <div class="col-12">
                        <label for="passwordInput" class="form-label">Password</label>
                        <div class="input-group" id="show_hide_password">
                            <input type="password" wire:model="password" class="form-control border-end-0" id="passwordInput" placeholder="Enter Password"> <a href="javascript:;" class="input-group-text bg-transparent"><i class="bx bx-hide"></i></a>
                        </div>
                        
                        @error('password')
                            <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                        @enderror
                    </div>
        
                    <div class="col-md-6">
                        {{-- <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked">
                            <label class="form-check-label" for="flexSwitchCheckChecked">Remember Me</label>
                        </div> --}}
                    </div>
                    {{-- <div class="col-md-6 text-end">	<a href="">Forgot Password ?</a>
                    </div> --}}
                    <div class="col-12">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Sign in</button>
                            {{-- <a href="/register" class="btn btn-light"><i class="bx bx-user-pin me-1"></i>Register</a> --}}
                            <a href="/" class="btn btn-light"><i class="bx bx-arrow-back me-1"></i>Back to Website</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
