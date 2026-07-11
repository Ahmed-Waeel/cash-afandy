<x-layouts::dashboard>
    <x-form-card resource="roles" :entry="$role" :data="['permissions' => $permissions]" />
</x-layouts::dashboard>
