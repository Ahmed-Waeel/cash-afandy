<x-layouts::dashboard>
    <x-form-card resource="static-pages" :entry="$staticPage">
        <x-slot:header>
            <x-translatable-switcher />
        </x-slot:header>
    </x-form-card>
</x-layouts::dashboard>
