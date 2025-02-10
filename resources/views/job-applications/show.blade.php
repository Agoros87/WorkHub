<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Aplicación para: {{ $jobApplication->advertisement->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <livewire:job-application-status :jobApplication="$jobApplication" />
                <livewire:job-application-chat :jobApplication="$jobApplication" />
            </div>
        </div>
    </div>
</x-app-layout>
