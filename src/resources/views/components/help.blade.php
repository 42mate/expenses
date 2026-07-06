<div class="help">
    <a class="help-toggle" data-bs-toggle="modal" data-bs-target="#helpModal"
       role="button" aria-label="{{ __('Help') }}">
        <i class="fa-regular fa-circle-question"></i>
    </a>
</div>

<div class="modal fade" id="helpModal" tabindex="-1" aria-labelledby="helpModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="helpModalLabel">
                    <i class="fa-regular fa-circle-question me-1"></i> {{ __('Help') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
