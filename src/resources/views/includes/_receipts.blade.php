<label class="strong font-weight-bold mb-1" for="receipts">Receipts</label>
@if (!empty($model))
    <div class="receipts">
        @foreach($model->receipts as $receipt)
            <div class="receipt filepond--custom--preview-container">
                @if ($receipt->isImage())
                    <img src="{{ $receipt->url() }}" class="img-fluid mb-3" />
                @else
                    <a href="{{ $receipt->url() }}" target="_blank" class="mb-2 d-block">
                        <i class="fas fa-download"></i>&nbsp;
                        {{ basename($receipt->path) }}
                    </a>
                @endif
                <div class="filepond--custom-delete" data-delete-url="{{ route('receipt.delete', ['receipt' => $receipt]) }}">
                    X
                </div>
            </div>
        @endforeach
    </div>
@endif
<input type="file" name="receipts[]" class="filepond" multiple data-allow-reorder="true" data-state="{{ json_encode(old('receipts')) }}"/>
