{{-- Session 4: Blade Directives Reference Snippets --}}

{{-- 1. Conditional Rendering --}}
@if($userRole === 'admin')
    <span class="badge bg-danger">Administrator</span>
@elseif($userRole === 'editor')
    <span class="badge bg-warning">Editor</span>
@else
    <span class="badge bg-secondary">Subscriber</span>
@endif

{{-- 2. Loop with Loop Flags --}}
@foreach($items as $item)
    <p>
        Iteration: {{ $loop->iteration }} |
        Title: {{ $item['title'] }} |
        @if($loop->first) [First Item] @endif
        @if($loop->last) [Last Item] @endif
    </p>
@endforeach

{{-- 3. Forelse with Empty Fallback --}}
@forelse($emptyCollection as $entry)
    <div>{{ $entry }}</div>
@empty
    <div class="alert alert-info">No records available to display.</div>
@endforelse
