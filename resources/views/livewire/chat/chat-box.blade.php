<div class="w-full overflow-hidden">
    <div class="border-b flex flex-col overflow-y-scroll grow h-full">
        {{-- Header --}}
        <div class="w-full sticky inset-x-0 flex top-0 bg-white border-b pt-0.5">
            <div class="flex items-center w-full px-2 lg:px-4 gap-2 md:gap-5">
                <a href="" class="shrink-0 lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                </a>

                {{-- Avatar --}}
                <div class="shrink-0">
                    <x-avatar class="h-9 w-9 lg:w-11 lg:h-11"></x-avatar>
                </div>

                <div class="font-bold truncate">{{ $selectedConversation->getReceiver()->name }}</div>
            </div>
        </div>

        {{-- Conent --}}
        <div
            class="flex flex-col gap-3 p-2 5 overflow-y-auto flex-grow overscroll-contain overflow-x-hidden w-full my-auto">
            @if ($loadMessages)
                @foreach ($loadMessages as $message)
                    <div @class([
                        'max-w-[85%] md:max-w-[78%] flex w-auto gap-2 relative mt-2',
                        'ml-auto' => $message->sender_id === auth()->id(),
                    ])>
                        {{-- Avatar --}}
                        <div @class(['shrink-0'])>
                            <x-avatar></x-avatar>

                        </div>

                        {{-- Message body --}}
                        <div @class([
                            'flex flex-wrap flex-col text-[15px] rounded-xl p-2.5 text-black bg-[#f6f6f8fb]',
                            'rounded-bl-none border border-gray-200/40' => !(
                                $message->sender_id === auth()->id()
                            ),
                            'rounded-br-none bg-blue-500/80 text-white' =>
                                $message->sender_id === auth()->id(),
                        ])>
                            <p class="whitespace-normal truncate text-sm md:text-base tracking-wide lg:tracking-normal">
                                {{ $message->body }}
                            </p>

                            <div class="ml-auto flex gap-2">
                                <p @class([
                                    'text-xs',
                                    'text-gray-200' => !($message->sender_id === auth()->id()),
                                    'text-white' => $message->sender_id === auth()->id(),
                                ])>
                                    2:25 pm
                                </p>

                                {{-- Message status, only show if message belongs auth --}}
                                @if ($message->sender_id === auth()->id())
                                    <div>
                                        @if ($message->isRead())
                                            {{-- double ticks --}}
                                            <span @class('text-white')>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-check-all" viewBox="0 0 16 16">
                                                    <path
                                                        d="M8.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L2.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093L8.95 4.992zm-.92 5.14.92.92a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 1 0-1.091-1.028L9.477 9.417l-.485-.486z" />
                                                </svg>
                                            </span>
                                        @else
                                            {{-- single ticks --}}
                                            <span @class('text-white')>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                                    <path
                                                        d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z" />
                                                </svg>
                                            </span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        {{-- Send message --}}
        <div class="shrink-0 z-10 bg-white inset-x-0">
            <div class="p-2 border-t">
                <form x-data="{ body: @entangle('body').defer }" @submit.prevent="$wire.sendMessage" method="POST" autocapitalize="off">
                    @csrf

                    <input type="hidden" autocomplete="false" style="display: none">

                    <div class="grid grid-cols-12">
                        <input x-model="body" type="text" name="" id="" autocomplete="off" autofocus
                            placeholder="Write your message here" maxlength="1700"
                            class="col-span-10 bg-gray-100 border-0 outline-0 focus:border-0 focus:ring-0 hover:ring-0 rounder-lg focus:outline-none">
                        <button type="submit" x-bind:disabled="!body.trim()" class="col-span-2">Send</button>
                    </div>
                </form>
                @error('body')
                    <p>{{ $error }}</p>
                @enderror
            </div>
        </div>
    </div>
</div>
