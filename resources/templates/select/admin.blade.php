<div class="d-flex align-items-start gap-3">
    <x-avatar class="flex-shrink-0" :name="$item->name" :image="$item->profile_picture" />

    <div>
        <div class="fw-medium">{{ $item->name }}</div>
        <div class="text-secondary">{{ $item->email }}</div>
    </div>
</div>
