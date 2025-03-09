@extends('layouts.baseTemplate')

@section('title', 'Messages - DevConnect')

@section('styles')
<style>
    .chat-height {
        height: calc(100vh - 240px);
    }
    .message-input {
        bottom: 0;
    }
    .message-bubble-sent {
        background-color: #3b82f6;
        color: white;
        border-radius: 18px 18px 0 18px;
    }
    .message-bubble-received {
        background-color: #e5e7eb;
        color: #1f2937;
        border-radius: 18px 18px 18px 0;
    }
    .messageSection{
        height: calc(100vh - 140px)
    }
</style>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8  ">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="flex messageSection">
            <!-- Connections Sidebar -->
            <div class="w-1/4 border-r border-gray-200">
                <div class="p-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-800">Connections</h2>
                  
                </div>
                
                <div class="overflow-y-auto chat-height">
                    <!-- Connection List -->
                   @if ($connections->count() > 0)
                   @foreach ($connections as $connection)
                   <div class="connection-active p-3 border-b border-gray-100 hover:bg-gray-50 cursor-pointer">
                    <a href="{{ route('message.user', $connection->id) }}" class="block">
                        <div class="flex items-center space-x-3">
                            <div class="relative">
                                <img src="{{ Storage::url($connection->image) }}" alt="{{ $connection->name }}" class="w-10 h-10 rounded-full">
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between">
                                    <h3 class="text-sm font-medium text-gray-900 truncate">{{ $connection->name }}</h3>
                                </div>

                            </div>
                        </div>
                    </a>
                   </div>
                   @endforeach
                       
                   @endif
                
                </div>
            </div>
            
            <!-- Chat Area -->
           @if(isset($talkedTo))
           <div class="w-3/4 flex flex-col">
            <!-- Chat Header -->
            <div class="p-4 border-b border-gray-200 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        <img src="{{ Storage::url($talkedTo -> image) }}" alt="User" class="w-10 h-10 rounded-full">
                    </div>
                    <div>
                        <a href="/profile/{{ $talkedTo -> id }}" class="font-medium text-gray-900">{{ $talkedTo -> name }}</a>
                    </div>
                </div>
               
            </div>
            
            <!-- Messages -->
            <div class="flex-1 overflow-y-auto p-4 chat-height flex flex-col-reverse">
                <div class="space-y-4 messages-chat">

                   @if (count($messages) > 0)
                   @foreach ($messages as $message )
                   <!-- Received Message -->
               <div class="flex items-end {{ $message -> sender_id == auth()->id() ? 'justify-end' : '' }}">
                   <div class="flex-shrink-0 mr-3">
                     @if ($message -> sender_id != auth()->id())
                         
                     <img src="{{ Storage::url($talkedTo -> image) }}" alt="{{ $talkedTo -> name }}" class="w-8 h-8 rounded-full">
                      
                     @endif
                   </div>
                   <div class="flex flex-col space-y-1 max-w-xs">
                       <div class="message-bubble-{{ $message -> sender_id == auth()->id() ? 'sent' : 'received'}}  p-3">
                           <p class="text-sm">{{$message -> message}}</p>
                       </div>
                       <span class="text-xs text-gray-500 ml-2">{{ $message -> created_at ->format('H:i') }}</span>
                   </div>
               </div>
               
             
              @endforeach
              @else
                <p class="text-center text-gray-500">No messages yet</p>
                   @endif
               
                </div>
            </div>
            
            <!-- Message Input -->
            <div class="border-t border-gray-200 p-4 message-input">
               <form  action="{{route('message.send',$talkedTo)}}" class="message-form" method="POST">
                @csrf
                <div class="flex items-end space-x-2">
                 
                    <div class="flex-1 relative">
                        <input name="message" type="text" placeholder="Type a message..." class="message-input-value w-full rounded-full pl-4 pr-12 py-2 border focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <button type="submit" class="p-2.5 rounded-full bg-blue-500 hover:bg-blue-600 text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </button>
                </div>
               </form>
            </div>
        </div>
        @else
        <div class="flex-1 flex items-center justify-center">
            <p class="text-gray-500">Select a connection to start messaging</p>
        </div>
           @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Scroll to bottom of messages on page load
        const chatContainer = document.querySelector('.chat-height');
        //    submit message
        let messagesDiv = document.querySelector('.messages-chat');
        let messageinput = document.querySelector('.message-input-value');
        
        // send message with ajax
        let messageForm = document.querySelector('.message-form'); 
        if(messageForm) {
            messageForm.addEventListener("submit", async function(e){
                e.preventDefault();
                let formData = new FormData(this);
                let response = await fetch(this.action, {
                    method: this.method,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: formData
                });

                if (response.ok) {
                    messageinput.value = '';
                    messagesDiv.innerHTML += `
                        <div class="flex items-end justify-end">
                            <div class="flex flex-col space-y-1 max-w-xs">
                                <div class="message-bubble-sent p-3">
                                    <p class="text-sm">${formData.get('message')}</p>
                                </div>
                                <span class="text-xs text-gray-500 ml-2">Now</span>
                            </div>
                        </div>
                    `;
                } else {
                    console.error('Error sending message');
                }
            });

        }

        // pusher real time messaging
          // pusher
    @php
      $userId = auth() -> check()? auth() -> user() -> id : 0;
  @endphp
  Pusher.logToConsole = false;

var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
  cluster: '{{ env('PUSHER_APP_CLUSTER') }}'
});

var channel = pusher.subscribe('message-channel');
channel.bind("Illuminate\\Notifications\\Events\\BroadcastNotificationCreated", function(data) {
    if (parseInt(data.user_id) == parseInt({{ $userId }}) ){
        messagesDiv.innerHTML += `
                        <div class="flex items-end ">
                            @if(isset($talkedTo))
                            <div class="flex-shrink-0 mr-3">
                             <img src="{{ Storage::url($talkedTo -> image) }}" alt="{{ $talkedTo -> name }}" class="w-8 h-8 rounded-full">
                             </div>
                            @endif
                            <div class="flex flex-col space-y-1 max-w-xs">
                                <div class="message-bubble-received p-3">
                                    <p class="text-sm">${data.message}</p>
                                </div>
                                <span class="text-xs text-gray-500 ml-2">Now</span>
                            </div>
                        </div>
                    `;
    }
});
    });
  
</script>
@endsection