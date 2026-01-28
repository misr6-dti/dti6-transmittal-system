<tr class="office-row" data-office-id="{{ $office->id }}" @if($level > 0) data-parent-id="{{ $office->parent_id }}" style="display: none;" @endif>
    <td class="ps-4 office-indent-level-{{ $level }}">
        <div class="office-name-cell">
            @if($office->children && $office->children->count() > 0)
                <div class="office-expand-icon" data-office-id="{{ $office->id }}" title="Toggle sub-offices">
                    <i class="bi bi-chevron-right"></i>
                </div>
            @else
                <div style="width: 24px;"></div>
            @endif
            <div>
                <div class="fw-bold text-dark">{{ $office->name }}</div>
                @if($office->parent)
                    <small class="text-muted">
                        <i class="bi bi-diagram-3"></i> Child of {{ $office->parent->name }}
                    </small>
                @endif
            </div>
        </div>
    </td>
    <td>
        <code class="text-muted">{{ $office->code }}</code>
    </td>
    <td>
        <span class="badge office-type-badge @switch($office->type)
            @case('Regional')
                bg-primary
            @break
            @case('Provincial')
                bg-info
            @break
            @case('Negosyo Center')
                bg-success
            @break
            @case('Provincial Office Division')
                bg-warning text-dark
            @break
            @default
                bg-secondary
        @endswitch">
            {{ $office->type }}
        </span>
    </td>
    <td class="text-end pe-4">
        <div class="btn-group btn-group-sm">
            <a href="{{ route('admin.offices.edit', $office) }}" class="btn btn-outline-navy" title="Edit">
                <i class="bi bi-pencil"></i>
            </a>
            <button type="button" 
                class="btn btn-outline-danger" 
                title="Delete Office"
                data-bs-toggle="modal" 
                data-bs-target="#confirmationModal"
                data-action="{{ route('admin.offices.destroy', $office) }}"
                data-method="DELETE"
                data-title="Delete Office"
                data-message="Are you sure you want to delete the '{{ $office->name }}' office?@if($office->children && $office->children->count() > 0) This office has {{ $office->children->count() }} sub-office(s).@endif"
                data-btn-class="btn-danger"
                data-btn-text="Delete">
                <i class="bi bi-trash"></i>
            </button>
        </div>
    </td>
</tr>

@if($office->children && $office->children->count() > 0)
    @foreach($office->children as $child)
        @include('admin.offices.partials.office-row', ['office' => $child, 'level' => $level + 1])
    @endforeach
@endif
