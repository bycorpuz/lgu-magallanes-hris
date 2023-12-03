<div>
    <div class="card-body p-sm-5">
        <div class="">
            <div class="mb-3 text-center">
                <img src="/images/site/{{ getSiteSettings()->site_logo }}" width="150" alt="">
            </div>
            <div class="text-center mb-4">
                <h5 class="">{{ getSiteSettings()->site_name }}</h5>
                <p class="mb-0">Please fill the below details to create your account</p>
            </div>
            <div class="form-body">
                <form class="row g-3" wire:submit.prevent="store">
                    <div class="col-12">
                        <label for="inputName" class="form-label">Name</label>
                        <input wire:model='name' type="text" class="form-control" id="inputName" placeholder="Jhon C. Doe">
                        @error('name')
                            <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label for="inputUsername" class="form-label">Username</label>
                        <input wire:model='username' type="text" class="form-control" id="inputUsername" placeholder="jcdoe">
                        @error('username')
                            <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label for="inputEmailAddress" class="form-label">Email Address</label>
                        <input wire:model='email' type="email" class="form-control" id="inputEmailAddress" placeholder="jcdoe@user.com">
                        @error('email')
                            <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label for="inputChoosePassword" class="form-label">Password</label>
                        <div class="input-group" id="show_hide_password">
                            <input wire:model='password' type="password" class="form-control border-end-0" id="inputChoosePassword" placeholder="********"> <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
                        </div>
                        @error('password')
                            <p class="mt-0 mb-0 font-13 text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-12">
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Sign up</button>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="text-center ">
                            <p class="mb-0">Already have an account? <a href="/login">Sign in here</a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
