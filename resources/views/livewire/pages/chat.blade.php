<main class="col-span-6 h-screen grid grid-rows-10 overflow-hidden">
    <livewire:components.header :chat="$chat"/>
    <div class="bg-slate-300 row-span-8 p-2 overflow-y-scroll">
        @foreach($chat->messages as $message)
            @if($message->type == 0)
                <div class="flex space-x-2 justify-center items-center" wire:key="{{$message->uuid}}">
                    <span class="font-bold">{{$message->user_id == auth()->id() ? 'You': $message->user->name}}</span>
                    <span>{{$message->body}}</span>
                </div>
            @else
                @if($message->user_id != auth()->id())
                    <div class="chat chat-start" wire:key="{{$message->uuid}}">
                        <div class="chat-image avatar">
                            <div class="w-10 rounded-full">
                                <img src="{{$message->user->avatar_url}}"/>
                            </div>
                        </div>
                        <div class="chat-bubble">{{$message->body}}</div>
                    </div>
                @else
                    <div class="chat chat-end" wire:key="{{$message->uuid}}">
                        <div class="chat-image avatar">
                            <div class="w-10 rounded-full">
                                <img src="{{$message->user->avatar_url}}"/>
                            </div>
                        </div>
                        <div class="chat-bubble">{{$message->body}}</div>
                    </div>
                @endif
            @endif
        @endforeach
    </div>
    <livewire:components.footer :chat="$chat"/>
</main>
