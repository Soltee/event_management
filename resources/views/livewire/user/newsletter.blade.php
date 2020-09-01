<div class="flex flex-col mb-8 relative">    

	  	<h3 class="text-white hover:opacity-75 mb-5 text-lg md:text-xl font-bold pr-3">Subscribe to our newsletter</h3> @if (session()->has('error'))

	        <div class="px-2 py-3 mb-3 rounded text-red-500 bg-red-100">

	            {{ session('error') }}

	        </div>

	    @endif    

	    @if (session()->has('success'))
		<div class=" flex flex-row justify-center items-center w-full mt-4">
  		
	  		<svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white"  viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
	  		<p class="ml-3 text-white">{{ session('success') }}</p>
		</div>
		@else
	  	<form wire:submit.prevent="subscribe"  method="POST" >
	  		@csrf
	      	<div class="mt-4 w-full flex flex-col ">
	          	<input id="email" wire:model="email" value="{{ old('email') }}" type="email" class="focus:outline-none  w-full bg-white rounded-t  px-6 py-3 sm:mb-0 border focus:border-custom-light-orange @error('email') border-red-500 @enderror" placeholder="Enter email..">
	          	<button type="submit" class="focus:outline-none w-full  bg-blue-500  hover:opacity-75 rounded-b md:uppercase text-white font-bold md:tracking-wide py-3 px-3 md:px-6 text-center cursor-pointer">Subscribe</button>
	      	</div>
	  	</form>

	@endif
</div>
