<?php 
include './db_connect.php'; 
?>
<style>
    .chat-container{
        height: 430px;
        width:350px;
        display:none;
    }
    p{
        font-size:.8rem;
    }
    small{
        font-size: .7rem;
    }
	.avatar {
	    width: 50px;
	    height: 50px;
        border: 3px solid;
        padding: 5px;
        border-radius:100%;
	}
    .avatar img{
        max-width: calc(100%);
        max-height: calc(100%);
        border-radius: 100%;
    }
    .user-chat-previous-message{
        max-width: 175px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
<input type="hidden" value="<?php echo $_SESSION['login_id'];?>" id="current-user-id"/>
<div class="position-fixed pr-3 pb-3 d-flex flex-column align-items-end" style="bottom:0;right:0;z-index:500">

    <!-- chat content -->
    <div class="chat-container mb-3 bg-white rounded shadow flex-column">
        <div class="p-2 border-bottom">
            <h5>Chats</h5>
        </div>
        <div class="p-2 border-bottom" id="chat-search-container">
            <input class="form-control" id="chat-search" placeholder="Search" onInput="Chat.onSearch()" autocomplete="off">
        </div>

        <div class="p-2 border-bottom" id="chat-selected-user" style="display:none">
            <div class="avatar d-flex align-items-center justify-content-center mr-3 overflow-hidden">
                <img src="assets/uploads/1602730260_avatar.jpg"/>
            </div>
            <div class="d-flex flex-column justify-content-center">
                <p class="mb-0 chat-selected-user-name">Mike Williams</p>
            </div>
            <div class="d-flex justify-content-end align-items-center" style="flex:1">
                <button class="btn" onClick="Chat.exitChat()">
                    <i class="bi bi-box-arrow-in-left"></i>
                </button>
            </div>
        </div>
        
        <div class="overflow-auto d-flex flex-column" id="chat-body" style="flex:1">
            <!-- <div class="user-chat-list border-bottom d-flex p-2" style="pointer:cursor" onClick="Chat.enterChat('2','Mike Williams','assets/uploads/1602730260_avatar.jpg')">
                <div class="avatar d-flex align-items-center justify-content-center mr-3 overflow-hidden">
                    <img src="assets/uploads/1602730260_avatar.jpg"/>
                </div>
                <div class="d-flex flex-column justify-content-center align-items-center">
                    <p class="mb-0 user-chat-name">Mike Williams<p>
                    <small class="user-chat-previous-message">:hello world</small>
                </div>
            </div> -->

            <div class="flex-column" style="height:100%;display:none" id="chat-messages-container">
                <div class="d-flex flex-column p-2 border-bottom overflow-auto" style="flex:1;gap:5px;" id="chat-messages">
                    <!-- <div class="sender-not-me d-flex">
                        <div class="rounded bg-light border p-2" style="overflow-wrap:break-word;max-width:175px;">
                            <small>Hello world</small>
                        </div>
                    </div>
                    <div class="sender-me d-flex justify-content-end">
                        <div class="rounded bg-primary border p-2" style="overflow-wrap:break-word;max-width:175px;">
                            <small class="text-white">Hello world</small>
                        </div>
                    </div> -->
                </div>
                <div class="p-2 border-bottom">
                    <div class="input-group">
                        <input class="form-control" id="draft-message" autocomplete="off" placeholder="Write your message...">
                        <div class="input-group-prepend">
                            <button class="btn btn-primary" onClick="Chat.sendMessage()"><i class="bi bi-send"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- chat button -->
    <button class="btn btn-primary rounded-circle fs-5 shadow-lg" onClick="toggleChatBox()">
        <i class="bi bi-chat" style="font-size:1.5rem;"></i>
    </button>

    <script>
        const toggleChatBox = () => {
            const container = document.querySelector('.chat-container')

            container.style.display = container.style.display === 'none' ? 'flex' : 'none'
        }

        const Chat = {
            selectedUser : null, // user that has been selected if none value is null else it is an object consist of name, image and id
            messages: [], // list of message from the convo with the selectedUser
            chatHistory: [], // list of users kung san may convo history na
            searchResults: [], // search results from the search bar
            containerDefinition: "history", // define the chat content - "history" or "search_result"
            isBodyLoading: false, // activates body load indicator (im lazy asf might not gonna use it anymore)
            currentUserId: () => document.querySelector('#current-user-id').value,
            exitChat: async () => {
                if(Chat.containerDefinition === "history") await Chat.fetchUserHistory()
                if(Chat.containerDefinition === "search_result") await Chat.fetchSearchUsers()

                document.querySelector('#chat-search-container').style.display = 'block'
                document.querySelector('#chat-selected-user').style.display = 'none'
                document.querySelector('#chat-messages-container').style.display = 'none'
                document.querySelector('#chat-messages').innerHTML = ''
                
                Chat.messages = []
                Chat.selectedUser = null
            },
            enterChat: async (id, name, image) => {
                Chat.selectedUser = { id, name, image }

                document.querySelectorAll('.user-chat-list').forEach(e => e.remove())
                document.querySelector('#chat-search-container').style.display = 'none'
                document.querySelector('#chat-selected-user').style.display = 'flex'
                document.querySelector('#chat-selected-user img').src = `./admin/assets/uploads/${image}`
                document.querySelector('#chat-selected-user .chat-selected-user-name').textContent = name
                document.querySelector('#chat-messages-container').style.display = 'flex'

                await Chat.fetchMessages()
            },
            sendMessage: async () => {
                const message = document.querySelector('#draft-message')

                if(!message.value?.trim().length) return

                const response = await fetch('../chat/actions/sendMessage.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        receiver_id: Chat.selectedUser.id,
                        message: message.value?.trim(),
                        sender_id: Chat.currentUserId()
                    }),
                })

                const data = await response.json()

                message.value = ''
                console.log(data)
            },
            fetchMessages: async () => {
                if(!Chat.selectedUser?.id) return

                const messagesContainer = document.querySelector('#chat-messages')
                const api = await fetch('../chat/actions/messages.php?user_id='+Chat.currentUserId()+'&friend_id='+Chat.selectedUser.id)
                const res = await api.json()

                const isGoingToScrollDown = res.messages.length !== Chat.messages.length
                Chat.messages = typeof res === 'object' && !!res.messages ? res.messages : []
                                
                messagesContainer.innerHTML = '';

                for (const message of Chat.messages) {
                    if(message.sender_id != Chat.currentUserId()){
                        const messageElement = document.createElement('div')
                        messageElement.classList.add('sender-not-me', 'd-flex')

                        const messageContent = document.createElement('div')
                        messageContent.classList.add('rounded', 'bg-light', 'border', 'p-2')
                        messageContent.style.overflowWrap = 'break-word'
                        messageContent.style.maxWidth = '175px'
 
                        const messageText = document.createElement('small')
                        messageText.textContent = message.message

                        messageContent.appendChild(messageText)
                        messageElement.appendChild(messageContent)
                        messagesContainer.appendChild(messageElement)
                    }
                    else {
                        const messageElement = document.createElement('div')
                        messageElement.classList.add('sender-me', 'd-flex', 'justify-content-end')

                        const messageContent = document.createElement('div')
                        messageContent.classList.add('rounded', 'bg-primary', 'border', 'p-2')
                        messageContent.style.overflowWrap = 'break-word'
                        messageContent.style.maxWidth = '175px'

                        const messageText = document.createElement('small')
                        messageText.classList.add('text-white')
                        messageText.textContent = message.message

                        messageContent.appendChild(messageText)
                        messageElement.appendChild(messageContent)
                        messagesContainer.appendChild(messageElement)
                    }
                }

                if (isGoingToScrollDown) messagesContainer.scrollTop = messagesContainer.scrollHeight

                setTimeout(() => {
                    Chat.fetchMessages()
                }, 500);
            },
            fetchSearchUsers: async () => {
                Chat.isBodyLoading = true

                const searchBar = document.querySelector("#chat-search")
                const api = await fetch('../chat/actions/search.php?search='+searchBar.value?.trim())
                const res = await api.json()

                Chat.searchResults = typeof res === 'object' ? res : []
                Chat.initDisplayList()
                Chat.isBodyLoading = false
            },
            fetchUserHistory: async () => {
                Chat.isBodyLoading = true

                const api = await fetch('../chat/actions/chatHistory.php?user_id='+Chat.currentUserId())
                const res = await api.json()

                Chat.chatHistory = typeof res === 'object' && !!res.users ? res.users : []
                Chat.initDisplayList()
                Chat.isBodyLoading = false
            },
            onSearch: async () => {
                const searchBar = document.querySelector("#chat-search")

                if(searchBar.value?.trim().length < 3){
                    Chat.containerDefinition = "history"
                    await Chat.fetchUserHistory()
                    return
                }
                
                Chat.containerDefinition = "search_result"
                await Chat.fetchSearchUsers()
                return
            },
            initDisplayList: () => {
                document.querySelectorAll('.user-chat-list').forEach(e => e.remove())
                document.querySelector('.no-result-indicator')?.remove()

                const container = document.querySelector('#chat-body')

                switch(Chat.containerDefinition){
                    case 'search_result':
                        if(!Chat.searchResults.length) return container.innerHTML = container.innerHTML+'<small class="text-center text-muted d-block py-3 no-result-indicator">No results</small>'

                        for(const user of Chat.searchResults){
                            const userChatList = document.createElement('div')
                            userChatList.classList.add('user-chat-list', 'border-bottom', 'd-flex', 'p-2')
                            userChatList.style.cursor = 'pointer'
                            userChatList.addEventListener('click', ()=> Chat.enterChat(user.id, user.name, user.avatar))

                            const avatarContainer = document.createElement('div')
                            avatarContainer.classList.add('avatar', 'd-flex', 'align-items-center', 'justify-content-center', 'mr-3', 'overflow-hidden')
                            const avatarImage = document.createElement('img')
                            avatarImage.src = `assets/uploads/${user.avatar}`
                            avatarContainer.appendChild(avatarImage)

                            const userInfoContainer = document.createElement('div')
                            userInfoContainer.classList.add('d-flex', 'flex-column', 'justify-content-center', 'align-items-center')
                            const userName = document.createElement('p')
                            userName.classList.add('mb-0', 'user-chat-name')
                            userName.textContent = user.name
                            userInfoContainer.appendChild(userName)

                            userChatList.appendChild(avatarContainer)
                            userChatList.appendChild(userInfoContainer)

                            // Append the user chat list to the container
                            container.appendChild(userChatList)
                        }

                        break;
                    case 'history':
                        if(!Chat.chatHistory.length) return container.innerHTML = container.innerHTML+'<small class="text-center text-muted d-block py-3  no-result-indicator">No Chat history yet.</small>'

                        for(const user of Chat.chatHistory){
                            const userChatList = document.createElement('div')
                            userChatList.classList.add('user-chat-list', 'border-bottom', 'd-flex', 'p-2')
                            userChatList.style.cursor = 'pointer'
                            userChatList.addEventListener('click', ()=> Chat.enterChat(user.id, user.name, user.avatar))

                            const avatarContainer = document.createElement('div')
                            avatarContainer.classList.add('avatar', 'd-flex', 'align-items-center', 'justify-content-center', 'mr-3', 'overflow-hidden')
                            const avatarImage = document.createElement('img')
                            avatarImage.src = `assets/uploads/${user.avatar}`
                            avatarContainer.appendChild(avatarImage)

                            const userInfoContainer = document.createElement('div')
                            userInfoContainer.classList.add('d-flex', 'flex-column', 'justify-content-center')
                            const userName = document.createElement('p')
                            userName.classList.add('mb-0', 'user-chat-name')
                            userName.textContent = user.name

                            const userMessage = document.createElement('small')
                            userMessage.classList.add('user-chat-previous-message')
                            userMessage.textContent = `: ${user.latest_message}`
                            userInfoContainer.appendChild(userName)
                            userInfoContainer.appendChild(userMessage)

                            userChatList.appendChild(avatarContainer)
                            userChatList.appendChild(userInfoContainer)

                            // Append the user chat list to the container
                            container.appendChild(userChatList)
                        }
                        break;
                }
            }
        }

        const repeatCalls = async () => {
            if(!!!Chat.selectedUser && Chat.containerDefinition === 'history') await Chat.fetchUserHistory()

            setTimeout(() => {
                repeatCalls()
            }, 500)
        }
        
        repeatCalls()
    </script>
</div>