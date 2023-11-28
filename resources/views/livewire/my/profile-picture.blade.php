<div>
    <div class="card">
        <div class="card-body">
            <div class="d-flex flex-column align-items-center text-center">
                <img src="{{ asset('/images/users/'.$user->userPersonalInformations->picture) }}" id="userProfilePicture" alt="User" class="rounded-circle p-1 bg-primary" width="110">
                <div class="mt-3">
                    <h6 id="userProfileName">{{ getUserFullName($user->id) }}</h6>
                    <p class="text-secondary mb-1" id="userProfileEmail">{{ $user->email }}</p>
                    <p class="text-muted font-size-sm" id="userProfileUsername">{{ $user->username }}</p>
                    <button onclick="event.preventDefault();document.getElementById('userProfilePictureFile').click();" class="btn btn-primary" id="userProfilePictureChange">Change Profile Picture</button>
                    <input class="form-control d-none" style="opacity: 0;" type="file" name="userProfilePictureFile" id="userProfilePictureFile" accept="image/*">
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            $('input[type="file"][name="userProfilePictureFile"][id="userProfilePictureFile"]').ijaboCropTool({
                preview : '#userProfilePicture',
                setRatio:1,
                allowedExtensions: ['jpg', 'jpeg','png'],
                buttonsText:['CROP','QUIT'],
                buttonsColor:['#30bf7d','#ee5155', -15],
                processUrl:'{{ route("my-profile-change-profile-picture") }}',
                withCSRF:['_token','{{ csrf_token() }}'],
                onSuccess:function(message, element, status){
                    Livewire.dispatch('refreshHeaderInfo');
                    showNotification('success', message);
                },
                onError:function(message, element, status){
                    showNotification('error', message);
                }
            });
        });
    </script>
@endpush