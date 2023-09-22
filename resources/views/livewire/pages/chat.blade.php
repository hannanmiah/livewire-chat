<div class="grid grid-cols-12" data-chat-uuid="{{$chat->uuid}}" id="chat-container" x-data="dataChat()"
     @user-typing.window="(e) => addUserTyping(e.detail)"
     @user-stopped-typing.window="(e) => removeUserTyping(e.detail)" @typing-started.window="startTyping"
     @typing-stopped.window="stopTyping" @refreshed.window="loading = false">
    <aside class="hidden md:block col-span-4 h-screen border-r border-gray-300">
        <livewire:components.navigation :key="$chat->messages->pluck('uuid')->join('-')"/>
    </aside>
    <main class="col-span-12 md:col-span-8 h-screen grid grid-rows-10 overflow-hidden">
        <livewire:components.header :chat="$chat"/>
        <div class="bg-slate-300 row-span-8 p-2 overflow-y-scroll" id="msg-view">
            <div class="flex justify-center" x-intersect="loadPage">
                <button class="btn glass" x-show="loading" x-transition>Load More...</button>
            </div>
            @foreach($messages as $message)
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
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('message-created', (e) => {
                console.log('message created', e)
            })
            scrollMsgViewToBottom()
        })

        document.addEventListener('livewire:navigated', () => {
            setTimeout(() => {
                scrollMsgViewToBottom()
            }, 0)
        })

        function scrollMsgViewToBottom() {
            const msg = document.getElementById('msg-view')
            // scroll msg-view to bottom
            msg.scrollTop = msg.scrollHeight;
        }

        function scrollMsgViewToTop() {
            const msg = document.getElementById('msg-view')
            // scroll msg-view to bottom
            msg.scrollTop = 0;
        }

        function scrollTo(height = 0) {
            const msg = document.getElementById('msg-view')
            msg.scrollTop = height
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
                    scrollMsgViewToBottom()
                })
                .listenForWhisper('stop-typing', (e) => {
                    Livewire.dispatch('user-stopped-typing', e.user)
                })
        }

        document.addEventListener('livewire:init', () => {
            console.log('livewire init')
        })

        function dataChat() {
            const chatUUID = document.getElementById('chat-container').dataset.chatUuid
            return {
                init() {
                    this.user = {{ Js::from(auth()->user()) }}
                    joinChat(chatUUID)
                    this.scrollBottom()
                },
                lastScroll: 0,
                page: 1,
                loading: false,
                user: {},
                usersTyping: [],
                startTyping(text = '') {
                    this.scrollBottom()
                    Echo.join(`chats.${chatUUID}`)
                        .whisper('start-typing', {
                            user: this.user,
                            text
                        })
                },
                stopTyping() {
                    Echo.join(`chats.${chatUUID}`)
                        .whisper('stop-typing', {
                            user: this.user
                        })
                },
                isTyping(user) {
                    return this.usersTyping.some(u => u.uuid === user.uuid)
                },
                addUserTyping(user) {
                    // check if exist or not
                    if (!this.isTyping(user)) {
                        this.usersTyping.push(user)
                    }
                },
                removeUserTyping(user) {
                    this.usersTyping = this.usersTyping.filter(u => u.uuid !== user.uuid)
                },
                loadPage() {
                    this.loading = true
                    this.page++
                    Livewire.dispatch('load-more', {limit: this.page * 10})
                    this.scrollTop()
                },
                scrollBottom() {
                    this.$nextTick(() => scrollMsgViewToBottom())
                },
                scrollTop() {
                    this.$nextTick(() => scrollMsgViewToTop())
                },
                scrollTo(height = 0) {
                    this.$nextTick(() => scrollTo(height))
                },
            }
        }

    </script>
@endpush
