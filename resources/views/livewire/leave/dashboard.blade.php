<div class="row row-cols-1 row-cols-md-2 row-cols-xl-3">
    <div class="col">
        <div class="card radius-10 bg-primary bg-gradient">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-white">Total Leave Application</p>
                        <h4 class="my-1 text-white" wire:poll='leaveDataCounter("")'>{{ number_format($leaveCounter, 0) }}</h4>
                    </div>
                    <div class="text-white ms-auto font-35"><i class="bx bx-paper-plane"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card radius-10 bg-secondary bg-gradient">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-white">Total Pending</p>
                        <h4 class="my-1 text-white" wire:poll='leaveDataCounter("Pending")'>{{ number_format($leavePendingCounter, 0) }}</h4>
                    </div>
                    <div class="text-white ms-auto font-35"><i class="bx bx-message-square-edit"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card radius-10 bg-info bg-gradient">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-white">Total Processing</p>
                        <h4 class="my-1 text-white" wire:poll='leaveDataCounter("Processing")'>{{ number_format($leaveProcessingCounter, 0) }}</h4>
                    </div>
                    <div class="text-white ms-auto font-35"><i class="bx bx-message-square-detail"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card radius-10 bg-warning bg-gradient">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-white">Total Cancelled</p>
                        <h4 class="my-1 text-white" wire:poll='leaveDataCounter("Cancelled")'>{{ number_format($leaveCancelledCounter, 0) }}</h4>
                    </div>
                    <div class="text-white ms-auto font-35"><i class="bx bx-message-square-error"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card radius-10 bg-danger bg-gradient">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-white">Total Disapproved</p>
                        <h4 class="my-1 text-white" wire:poll='leaveDataCounter("Disapproved")'>{{ number_format($leaveDisapprovedCounter, 0) }}</h4>
                    </div>
                    <div class="text-white ms-auto font-35"><i class="bx bx-message-square-x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card radius-10 bg-success bg-gradient">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-white">Total Approved</p>
                        <h4 class="my-1 text-white" wire:poll='leaveDataCounter("Approved")'>{{ number_format($leaveApprovedCounter, 0) }}</h4>
                    </div>
                    <div class="text-white ms-auto font-35"><i class="bx bx-message-square-check"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>