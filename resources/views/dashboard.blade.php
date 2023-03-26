@inject('carbon', 'Carbon\Carbon')

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mon profil') }}
        </h2>
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Bonjour {{ auth()->user()->name }} ( {{ "@" . auth()->user()->username}} )
        </h2>
        <h4 class="font-semibold text-sm text-white leading-tight mt-10">{{ count($tweets) }} tweet(s)</h4>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="alert alert-success" id="notif">
                    {{ session('status') }}
                </div>
            @endif
            <div class="overflow-hidden sm:rounded-lg mb-4 w-full flex lg:flex-row flex-col">
                <div class="lg:w-2/3 w-full lg:order-1 order-2">
                

                    @if (count($tweets) >= 1)
                    <div class="overflow-hidden shadow-sm sm:rounded-lg w-full px-[5vw] grid md:grid-cols-2 grid-cols-1 gap-6">
                    
                        @foreach ($tweets as $tweet)
                           <div class="tweets bg-secondary p-[20px] relative">
                                <a href="/users/{{ $tweet->users_id }}/tweets" class="p-6 text-white">
                                    <h2 class="text-primary font-bold text-md mb-3">{{ $tweet->name }} ({{ "@". $tweet->username }})</h2>
                                    <p class="mb-3 text-sm break-all">{{ $tweet->content }}</p>
                                    <p class="text-sm">{{ $carbon::parse($tweet->created_at)->diffForHumans() }}</p>
                                
                                </a>
                                @if(auth()->user()->id == $tweet->users_id)
                                    <button type="button" class="absolute top-[20px] right-[20px] options-btn" data-target=".options-{{ $tweet->id }}">
                                        <iconify-icon icon="mdi:dots-vertical" class="text-white"></iconify-icon>
                                    </button>
                                    
                                    <div class="options-menu options-{{ $tweet->id }} absolute top-[50px] hidden">
                                        <a href="/tweets/delete/{{ $tweet->id }}" class="bg-primary w-10 h-10 block flex items-center justify-center rounded-lg border border-tertiary shadow-sm shadow-tertiary">
                                            <iconify-icon icon="iconoir:bin" class="text-tertiary"></iconify-icon>
                                        </a>
                                    </div>
                                   
                                @endif
                           </div>
                        @endforeach
                    </div>
                    <div class="mx-[5vw] my-[30px]">
                        {{ $tweets->render() }}
                    </div>
                    @else
                    <div class="">
                        Il n'y a aucun tweets pour le moment
                    </div>
                       
                    @endif
                    
                </div>

                <div class="lg:w-1/3 w-full lg:order-2 order-1 p-[20px]">
                    <form method="POST" action="{{ route('tweets.store') }}" class="md:w-2/3 w-full">
                        @csrf
                
                        <!-- Name -->
                        <div>
                            <x-input-label for="content" :value="__('Rediger')" class="text-white text-2xl mb-3"/>
                            <x-text-textarea id="content" class="block text-white mt-1 w-full border border-dashed border-secondary bg-transparent lg:aspect-square" name="content" :value="old('content')" required autofocus autocomplete="content"  maxlength="180" value="{{ old('username') }}"></x-text-textarea>
                            <x-input-error :messages="$errors->get('content')" class="mt-2" />
                        </div>
                
                       
                
                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4 bg-secondary2">
                                {{ __('Publier') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</x-app-layout>