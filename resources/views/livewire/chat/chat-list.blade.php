<div x-data="{ type: 'all', query:@entangle('query') }" 
    x-init="setTimeout(()=>{
        conversationElement = document.getElementById('conversation_' + query);
        // scroll to the element
        if(conversationElement) {
            conversationElement.scrollIntoView({'behavior':'smooth'});
        }
    }),200"
    class="flex flex-col transition-all h-full overflow-hidden">
    {{-- Header --}}
    <div class=" px-3 z-10 bg-white sticky top-0 w-full py-2.5">
        <div class="border-b flex justify-between items-center pb-2">
            <div class="flex items-center gap-2">
                <div class="font-extrabold text-2xl">Chats</div>
            </div>

            <button>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="w-7 h-7"
                    viewBox="0 0 16 16">
                    <path
                        d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5" />
                </svg>
            </button>
        </div>
        {{-- Filters --}}
        <div class="flex items-center gap-3 p-2 bg-white">
            <button @click="type='all'" :class="{ 'bg-blue-100 border-0 text-black': type == 'all' }"
                class="inline-flex justify-center items-center rounded-full gap-x-1 text-xs font-medium px-3 lg:px-5 py-1 lg:py-2.5 border">All</button>
            <button @click="type='delete'" :class="{ 'bg-blue-100 border-0 text-black': type == 'delete' }"
                class="inline-flex justify-center items-center rounded-full gap-x-1 text-xs font-medium px-3 lg:px-5 py-1 lg:py-2.5 border">Deleted</button>
        </div>
    </div>

    {{-- Main --}}
    <div class="overflow-y-scroll overflow-hidden grow h-full relative" style="contain:content">
        {{-- Chat list --}}
        <ul class="p-2 grid w-full spacey-y-2">
            @if ($conversations)
                @foreach ($conversations as $key => $conversation)
                    <li
                        id="conversation-{{ $conversation->id }}" wire:key="{{ $conversation->id }}"
                        class="py-3 hover:bg-gray-100 rounded-2xl dark:hover:bg-gray-100/70 transition-colors duration-150 flex gap-4 relative w-full cursor-point px-2 {{ $conversation->id==$selectedConversation->id ? 'bg-gray-100/70' : '' }}">
                        <a href="#" class="shrink-0">
                            <x-avatar src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80"></x-avatar>
                        </a>
                        <aside class="grid grid-cols-12 w-full">
                            <a href="{{ route('chat', $conversation->id) }}"
                                class="col-span-11 border-b pb-2 border-gray-200 relative overflow-hidden truncate leading-5 w-full flex-nowrap p-1">
                                {{-- Name and date --}}
                                <div class="flex justify-between items-center-w-full">
                                    <h6 class="truncate font-medium tracking-wider text-gray-900">
                                        {{ $conversation->getReceiver()->name }}
                                    </h6>
                                    <small class="text-gray-700">{{ $conversation->messages?->last()?->created_at?->shortAbsoluteDiffForHumans() }}</small>
                                </div>
                                {{-- Message body --}}
                                <div class="flex items-center gap-x-2">
                                    {{-- double tick --}}
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-check-all" viewBox="0 0 16 16">
                                            <path
                                                d="M8.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L2.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093L8.95 4.992zm-.92 5.14.92.92a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 1 0-1.091-1.028L9.477 9.417l-.485-.486z" />
                                        </svg>
                                    </span>

                                    {{-- single tick --}}
                                    {{-- <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                    <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z"/>
                                  </svg>
                            </span> --}}

                                    <p class="grow truncate text-sm font-[100]">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                        incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                                        nostrud
                                        exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute
                                        irure
                                        dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
                                        pariatur.
                                        Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
                                        deserunt
                                        mollit anim id est laborum.
                                    </p>

                                    {{-- unread count --}}
                                    <span
                                        class="font-bold p-px px-2 text-xs shrink-0 rounded-full bg-red-500 text-white">5</span>
                                </div>
                            </a>

                            <div class="col-span-1 flex flex-col text-center my-auto">
                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        <button>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor"
                                                class="bi bi-three-dots-vertical w-7 h-7 text-gray-700"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0" />
                                            </svg>
                                        </button>
                                    </x-slot>

                                    <x-slot name="content">
                                        <div class="w-full p-1">
                                            <button
                                                class="flex items-center gap-3 w-full px-4 py-2 textsm leading-5 text-white hover:bg-gray-600 transition-all duration-150 ease-in-out focus:outline-none focus:bg-gray-600">
                                                <span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                        height="16" fill="currentColor" class="bi bi-person-circle"
                                                        viewBox="0 0 16 16">
                                                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                                                        <path fill-rule="evenodd"
                                                            d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                                                    </svg>
                                                </span>

                                                View Profile
                                            </button>
                                            <button
                                                class="flex items-center gap-3 w-full px-4 py-2 textsm leading-5 text-white hover:bg-gray-600 transition-all duration-150 ease-in-out focus:outline-none focus:bg-gray-600">
                                                <span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                        height="16" fill="currentColor" class="bi bi-trash-fill"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
                                                    </svg>
                                                </span>

                                                Delete
                                            </button>
                                        </div>
                                    </x-slot>
                                </x-dropdown>
                            </div>
                        </aside>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
</div>
