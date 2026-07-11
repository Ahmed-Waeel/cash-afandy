<div class="row">
    <div class="col-12 col-md-6 mb-3">
        <x-input name="first_name" :title="__('First name')" :value="old('first_name', $entry?->first_name)" validation="required" />
    </div>

    <div class="col-12 col-md-6 mb-3">
        <x-input name="last_name" :title="__('Last name')" :value="old('last_name', $entry?->last_name)" validation="required" />
    </div>
</div>

@if (! $entry)
    <div class="mb-3">
        <x-input type="email" name="email" :title="__('Email')" :value="old('email')" validation="required|email" />
    </div>
@endif
