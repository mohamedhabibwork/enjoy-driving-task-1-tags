<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Resources') }}
        </h2>
    </x-slot>

    @if($message = session('success'))

        <div class="bg-teal-100 text-teal-900 px-4 py-3 shadow-md" role="alert">
            <div class="flex">
                <div class="py-1">
                    <svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 20 20">
                        <path
                            d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-bold">{!! $message !!}</p>
                </div>
            </div>
        </div>
    @endif
    @if($message = session('error'))
        <div class="bg-red-100 text-red-900 px-4 py-3 shadow-md" role="alert">
            <div class="flex">
                <div class="py-1">
                    <svg class="fill-current h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 20 20">
                        <path
                            d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-bold">{!! $message !!}</p>
                </div>
            </div>
        </div>
    @endif
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="">
                    <section class="space-y-6">
                        <header class="flex justify-between">
                            <h2 class="flex text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Resources') }}
                            </h2>

                            <x-primary-button
                                x-data=""
                                class="flex"
                                x-on:click.prevent="$dispatch('open-modal', 'create-resources')"
                            >{{ __('Create Resource') }}</x-primary-button>

                        </header>
                        <x-modal name="create-resources" :show="$errors->isNotEmpty()" focusable>
                            <form method="post" action="{{ route('resources.store') }}" class="p-6">
                                @csrf

                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    {{ __('Create Resources') }}
                                </h2>

                                <div class="mt-6">
                                    <x-input-label for="name" value="{{ __('Name') }}" class="sr-only"/>

                                    <x-text-input
                                        id="name"
                                        name="name"
                                        type="text"
                                        class="mt-1 block w-3/4"
                                        placeholder="{{ __('Name') }}"
                                    />

                                    <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                                </div>
                                <div class="mt-6">
                                    <x-input-label for="name" value="{{ __('Name') }}" class="sr-only"/>

                                    <select
                                        id="tags"
                                        multiple
                                        name="tags[]"
                                        type="text"
                                        class="mt-1 block w-3/4"
                                    >
                                        @foreach($tags as $tag)
                                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                        @endforeach
                                    </select>

                                    <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                                </div>

                                <div class="mt-6 flex justify-end">
                                    <x-secondary-button x-on:click="$dispatch('close')">
                                        {{ __('Cancel') }}
                                    </x-secondary-button>

                                    <x-primary-button class="ml-3">
                                        {{ __('Create') }}
                                    </x-primary-button>
                                </div>
                            </form>
                        </x-modal>
                    </section>
                </div>
            </div>
            <div class="px-6 pt-4 pb-2">
                <h2 class="flex text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Related Tags') }}
                </h2>
                <form class="px-6 pt-4 pb-2" method="get" action="{{ route('resources.index') }}">
                    @foreach($relatedTags as $tag)
                        <div class="inline-block w-32">
                            <input type="checkbox" id="{{  $id = str($tag)->slug() }}" value="{{ $tag->id }}"
                                   name="tags[]" class="hidden peer"/>
                            <label for="{{ $id }}"
                                   class="peer-checked:bg-blue-300 peer-checked:text-blue-700 peer-checked:border-blue-200  inline-block bg-blue-200 rounded-full px-3 py-1 text-sm font-semibold text-blue-700 mr-2 mb-2">
                                <div class="block" title="{{ $tag->name }}">
                                    #{{ str($tag->name)->limit(10) }}
                                </div>
                            </label>
                        </div>
                    @endforeach
                    <div class="block border-t-2 border-gray-600">
                        <br>
                        <x-primary-button type="submit" class="ml-3">
                            {{ __('Filter') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
            <div class="px-6 pt-4 pb-2 ">
                @foreach($resources as $resource)
                    <div class="w-full mb-2">
                        <div class=" rounded-lg bg-gray-800 overflow-hidden shadow-lg">
                            <div class="px-6 py-4">
                                <div class="font-bold dark:text-white text-xl mb-2">{{ $resource->name }}</div>
                            </div>
                            <div class="px-6 pt-4 pb-2">
                                @foreach($resource->tags as $tag)
                                    <a href="{{ route('resources.index', ['tags'=>[$tag->id]]) }}"
                                       class="inline-block bg-blue-200 rounded-full px-3 py-1 text-sm font-semibold text-blue-700 mr-2 mb-2">
                                        #{{ $tag->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
