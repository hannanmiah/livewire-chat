<div class="grid grid-cols-12" data-chat-uuid="{{$chat->uuid}}" id="chat-container" x-data="chat"
     @user-typing.window="(e) => addUserTyping(e.detail)"
     @user-stopped-typing.window="(e) => removeUserTyping(e.detail)">
    <aside class="hidden md:block col-span-4 h-screen border-r border-gray-300">
        <livewire:components.navigation :key="$chat->messages->pluck('uuid')->join('-')"/>
    </aside>
    <main class="col-span-12 md:col-span-8 h-screen grid grid-rows-10 overflow-hidden">
        <livewire:components.header :chat="$chat"/>
        <div class="bg-slate-300 row-span-8 p-2 overflow-y-scroll" id="msg-view" x-ref="msg">
            @foreach($chat->messages as $message)
                @if($message->type == 0)
                    <div class="flex space-x-2 justify-center items-center" wire:key="{{$message->uuid}}">
                        <span
                            class="font-bold">{{$message->user_id == auth()->id() ? 'You': $message->user->name}}</span>
                        <span>{{$message->body}}</span>
                    </div>
                @else
                    <div
                        wire:key="{{$message->uuid}}"
                        id="msg-{{$message->id}}" @class(['chat','chat-start' => $message->user_id != auth()->id(), 'chat-end' => $message->user_id == auth()->id()])>
                        <div class="chat-image avatar">
                            <div class="w-10 rounded-full">
                                <img src="{{$message->user->avatar_url}}" alt="{{$message->user->name}}"/>
                            </div>
                        </div>
                        <div class="chat-bubble">{{$message->body}}</div>
                    </div>
                @endif
            @endforeach
            <template x-for="user in usersTyping">
                <div class="chat chat-start" x-key="user.uuid">
                    <div class="chat-image avatar">
                        <div class="w-10 rounded-full">
                            <img :src="user.avatar_url" :alt="user.name"/>
                        </div>
                    </div>
                    <div class="chat-bubble" x-text="user.name + ' is typing...'"></div>
                </div>
            </template>
        </div>
        <livewire:components.footer :chat="$chat"/>
    </main>
</div>

@push('scripts')
    <script data-navigate-once>
        window.onload = () => {
            const chatUUID = document.getElementById('chat-container').dataset.chatUuid
            joinChat(chatUUID)
        }
        document.addEventListener('alpine:init', () => {
            const chatUUID = document.getElementById('chat-container').dataset.chatUuid
            Alpine.store('auth', {
                init() {
                    this.user = {{ Js::from(auth()->user()) }}
                },
                user: {},
                isTyping: false,
                getUser() {
                    return this.user
                },
                setUser(user) {
                    this.user = user
                },
                startTyping() {
                    this.isTyping = true
                    Echo.join(`chats.${chatUUID}`)
                        .whisper('start-typing', {
                            user: this.user
                        })
                },
                stopTyping() {
                    this.isTyping = false
                    Echo.join(`chats.${chatUUID}`)
                        .whisper('stop-typing', {
                            user: this.user
                        })
                }
            })

            Alpine.data('chat', () => ({
                usersTyping: [],
                isTyping(user) {
                    return this.usersTyping.some(u => u.uuid === user.uuid)
                },
                addUserTyping(user) {
                    // check if exist or not
                    if (!this.isTyping(user)) {
                        this.usersTyping.push(user)
                        scrollMsgViewToBottom()
                    }
                },
                removeUserTyping(user) {
                    this.usersTyping = this.usersTyping.filter(u => u.uuid !== user.uuid)
                }
            }))
        })
        document.addEventListener('livewire:init', () => {
            console.log('livewire initialized')
        })
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('message-created', async () => {
                scrollMsgViewToBottom()
            })
        })
        document.addEventListener('livewire:navigated', () => {
            scrollMsgViewToBottom()
            const chatUUID = document.getElementById('chat-container').dataset.chatUuid
            joinChat(chatUUID)
        })

        document.addEventListener('DOMContentLoaded', () => {
            scrollMsgViewToBottom()
        })

        function scrollMsgViewToBottom() {
            const msg = document.getElementById('msg-view')
            // scroll msg-view to bottom
            msg.scrollTo(0, msg.scrollHeight)
        }

        function joinChat(chatUUID) {
            Echo.join(`chats.${chatUUID}`)
                .here((users) => {
                    console.log(users)
                })
                .joining((user) => {
                    console.log(user)
                })
                .leaving((user) => {
                    console.log(user)
                })
                .listen('ChatUpdated', (e) => {
                    Livewire.dispatch('message-created')
                })
                .listenForWhisper('start-typing', (e) => {
                    Livewire.dispatch('user-typing', e.user)
                })
                .listenForWhisper('stop-typing', (e) => {
                    Livewire.dispatch('user-stopped-typing', e.user)
                })
        }
    </script>
@endpush
