<div class="edit-delete-action">
    <a class="me-2 edit-icon p-2" href="{{ route('product-detail', ['uuid' => $row->uuid]) }}">
        <i data-feather="eye" class="action-eye"></i>
    </a>
    <a class="me-2 p-2" href="{{ route('product-edit-form', ['uuid' => $row->uuid]) }}">
        <i data-feather="edit" class="feather-edit"></i>
    </a>
    <button class="p-2 btn btn-link" type="button" onclick="deleteProduct('{{ $row->uuid }}')">
        <i data-feather="trash-2" class="feather-trash-2"></i>
    </a>
</div>
