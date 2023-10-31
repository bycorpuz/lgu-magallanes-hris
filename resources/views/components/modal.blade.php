<div 
    x-data="{
        showModal: @entangle($attributes->wire('model')),
        modalTitle: @entangle('modalTitle'),
        modalSize: @entangle('modalSize'),
        modalAction: @entangle('modalAction')
    }"
    x-show="showModal"
    x-trap="showModal"
    x-on:keydown.escape.window="showModal = false"
>
    <div class="modal-backdrop fade show"></div>
    <div class="modal fade show" tabindex="-1" style="display: block;" aria-modal="true" role="dialog">
        <div class="modal-dialog" :class="modalSize">
            <div class="modal-content">
                <form wire:submit.prevent="{{ $modalAction == 'Create' ? 'store' : ($modalAction == 'Update' ? 'update' : 'delete') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" x-text="modalTitle">Modal title</h5>
                        <button type="button" class="btn-close" aria-label="Close" @click="showModal=false"></button>
                    </div>
                    <div class="modal-body">
                        {{ $slot }}
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" x-text="modalAction === 'Delete' ? 'Yes, Delete it.' : modalAction">Modal Action</button>
                        <button type="button" class="btn btn-secondary" @click="showModal=false">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>