<tr class="office-row" data-office-id="{{ $office->id }}" @if($level > 0) data-parent-id="{{ $office->parent_id }}" style="display: none;" @endif>
    <td class="pl-4 office-indent-level-{{ $level }}">
        <div class="office-name-cell">
            @if($office->children && $office->children->count() > 0)
                <div class="office-expand-icon" data-office-id="{{ $office->id }}" title="Toggle sub-offices">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </div>
            @else
                <div style="width: 24px;"></div>
            @endif
            <div>
                <div class="font-bold text-dark">{{ $office->name }}</div>
                @if($office->parent)
                    <small class="text-slate-500">
                        <svg class="w-3 h-3 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg> Child of {{ $office->parent->name }}
                    </small>
                @endif
            </div>
        </div>
    </td>
    <td>
        <code class="text-slate-500">{{ $office->code }}</code>
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
    <td class="text-end pr-4">
        <div class="btn-group btn-group-sm">
            <a href="{{ route('admin.offices.edit', $office) }}" class="px-3 py-2 bg-white border border-slate-200 text-navy rounded-xl hover:bg-slate-50 text-sm font-medium transition-colors" title="Edit">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
            </a>
            <button type="button" 
                class="px-3 py-2 bg-white border border-red-200 text-red-500 rounded-xl hover:bg-red-50 text-sm font-medium transition-colors" 
                title="Delete Office"
                data-bs-toggle="modal" 
                data-bs-target="#confirmationModal"
                data-action="{{ route('admin.offices.destroy', $office) }}"
                data-method="DELETE"
                data-title="Delete Office"
                data-message="Are you sure you want to delete the '{{ $office->name }}' office?@if($office->children && $office->children->count() > 0) This office has {{ $office->children->count() }} sub-office(s).@endif"
                data-btn-class="btn-danger"
                data-btn-text="Delete">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </button>
        </div>
    </td>
</tr>

@if($office->children && $office->children->count() > 0)
    @foreach($office->children as $child)
        @include('admin.offices.partials.office-row', ['office' => $child, 'level' => $level + 1])
    @endforeach
@endif
