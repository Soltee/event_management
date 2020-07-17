@extends('layouts.admin')

@section('content')
    <div class="px-3 md:px-6 pb-6">

        <p class="my-2 text-red-600">{{ session('success') }}</p>
        <p class="my-2 text-red-600">{{ session('error') }}</p>

         @if ($errors->any())
		    <div class="alert alert-danger">
		        <ul>
		            @foreach ($errors->all() as $error)
		                <li>{{ $error }}</li>
		            @endforeach
		        </ul>
		    </div>
		@endif
        <form method="POST" action="{{ route('speaker.store') }}" enctype="multipart/form-data">
        	@csrf
	       	<div class="flex justify-between items-center  mb-6">
	       		<div class="flex items-center">
	       			<a href="{{ route('speakers') }}" class=" text-md font-md text-gray-900   mr-5  hover:opacity-75">Back</a>
	       			<h3 class="text-gray-900 text-lg ">Add Speaker</h3>
	       		</div>

				<button type="submit" class="px-6 py-3  rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white">
	    			Publish
	    		</button>	

	    	
	    	</div>

		 
		 	<div class="flex justify-between flex-col md:flex-row">
    			<div class="flex flex-col md:mr-4 w-full md:w-1/2">

    				<h4 class="text-md mb-3 ">1. General Info</h4>
    				<div class="flex flex-wrap mb-6">
                        <label for="first_name" class="block text-gray-700 text-sm font-bold mb-2">
                            {{ __('First name') }}
                        </label>

                        <input id="first_name" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('first_name') border-red-500 @enderror " name="first_name" value="{{ old('first_name') }}"  autofocus placeholder="">

                        @error('first_name')
                            <p class="text-red-500 text-xs italic mt-4">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div class="flex flex-wrap mb-6">
                        <label for="last_name" class="block text-gray-700 text-sm font-bold mb-2">
                            {{ __('Last name') }}
                        </label>

                        <input id="last_name" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('last_name') border-red-500 @enderror " name="last_name" value="{{ old('last_name') }}"  autofocus placeholder="">

                        @error('last_name')
                            <p class="text-red-500 text-xs italic mt-4">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="flex flex-wrap mb-6">
                        <label for="email" class="block text-gray-700 text-sm font-bold mb-2">
                            {{ __('Email') }}
                        </label>

                        <input id="email" type="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror " name="email" value="{{ old('email') }}"  autofocus placeholder="">

                        @error('email')
                            <p class="text-red-500 text-xs italic mt-4">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="flex flex-wrap mb-6">
                        <label for="about" class="block text-gray-700 text-sm font-bold mb-2">
                            {{ __('About') }}
                        </label>

                         <textarea id="about" type="about" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('about') border-red-500 -40 @enderror " name="about" value=""  rows="10">
                        	
                        	{{ old('about') }}
                        </textarea>

                        @error('about')
                            <p class="text-red-500 text-xs italic mt-4">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="flex flex-wrap mb-6">
                        <label for="twitter_link" class="block text-gray-700 text-sm font-bold mb-2">
                            {{ __('twitter_link') }}
                        </label>

                        <input id="twitter_link" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('twitter_link') border-red-500 @enderror " name="twitter_link" value="{{ old('twitter_link') }}"  autofocus placeholder="">

                        @error('twitter_link')
                            <p class="text-red-500 text-xs italic mt-4">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="flex flex-wrap mb-6">
                        <label for="linkedin_link" class="block text-gray-700 text-sm font-bold mb-2">
                            {{ __('linkedin_link') }} ( Optional )
                        </label>

                        <input id="linkedin_link" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('linkedin_link') border-red-500 @enderror " name="linkedin_link" value="{{ old('linkedin_link') }}"  autofocus placeholder="">

                        @error('linkedin_link')
                            <p class="text-red-500 text-xs italic mt-4">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    
	            </div>
    			<div class="flex flex-col md:mr-4 w-full md:w-1/2">
    				<h4 class="text-md mb-3 ">2. Avatar </h4>
    				<div class="flex flex-wrap mb-6">

                        <input id="avatar" type="file" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('avatar') border-red-500 @enderror " name="avatar" value="{{ old('avatar') }}"  autofocus placeholder="">

                        @error('avatar')
                            <p class="text-red-500 text-xs italic mt-4">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <img id="avatarImage" class="mb-6 rounded object-cover object-center">
                    
    				<h4 class="text-md mb-3 ">3. Event </h4>
                    <div class="flex flex-wrap mb-6">
                        <div class="inline-block relative w-full">
							<select name="category" class="block appearance-none w-full bg-white border-r-lg border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
							  	@forelse($events as $event)
							    	<option value="{{ $event->id }}">{{ $event->title }}</option>
							    @empty
							    @endforelse

						    </select>
						    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
						    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
						    </div>
						</div>

                        <div id="allEvents" class="inline-block relative w-full">
						  	
						</div>

                        @error('event')
                            <p class="text-red-500 text-xs italic mt-4">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
		    	</div>
		    </div>
		</form>
    </div>
@endsection

@push('scripts')

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>	
	<script>

        document.addEventListener("DOMContentLoaded", function(){
        	let allEvents = document.getElementById('allEvents');

        	let events = await axios.get(`/admin/api/events`)
        		.then((res) => { 
                    if(res.status === 200){
                        let e     = res.events;
                        let prev  = res.prev;
                        let next  = res.next;

                        e.forEach((event) => {
                        	allEvents.append(`
                        		<div class="flex items-center">
	                    			<input id="event" type="radio" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('event') border-red-500 @enderror " name="event" value="${event.id}"  autofocus placeholder="">
	                    			<span class="mr-2 px-5 py-2 rounded-lg  border-2 border-white text-gray-900 cursor-pointer hover:font-bold">
	                    				${event.title}
	                    			</span>
	                    		</div>
	                    	`);
                        });
                    	
                       
                    } else {
                        swal("There was some server problem. Try again later.");
                    } 

                })
                .catch((error) => {

                    // swal("Server Error!");
                    
                });


        	//Avatar Show On Choose
            
			let readImage = document.getElementById('avatarImage');

			var file = document.querySelector('input[type=file]');
			file.addEventListener('change', function(e){

				var reader = new FileReader(); // Creating reader instance from FileReader() API

				reader.addEventListener("load", function () { // Setting up base64 URL on image
				    readImage.classList.add('h-40');
	            	readImage.src = reader.result;

				}, false);

				reader.readAsDataURL(e.target.files[0]);
				console.log(readImage);
			});  // File refrence

		});		
		
	</script>

@endpush