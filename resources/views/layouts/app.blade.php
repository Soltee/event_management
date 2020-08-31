<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') </title>
    <link rel="icon" href="{{ asset('/img/logo.svg') }}">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @yield('head')
    <livewire:styles />
    <style>
      .sk-cube-grid {
          width: 40px;
          height: 40px;
          margin: 100px auto;
      }

      .sk-cube-grid .sk-cube {
          width: 33%;
          height: 33%;
          background-color: #EE6425;
          float: left;
          -webkit-animation: sk-cubeGridScaleDelay 1.3s infinite ease-in-out;
          animation: sk-cubeGridScaleDelay 1.3s infinite ease-in-out;
      }

      .sk-cube-grid .sk-cube1 {
          -webkit-animation-delay: 0.2s;
          animation-delay: 0.2s;
      }

      .sk-cube-grid .sk-cube2 {
          -webkit-animation-delay: 0.3s;
          animation-delay: 0.3s;
      }

      .sk-cube-grid .sk-cube3 {
          -webkit-animation-delay: 0.4s;
          animation-delay: 0.4s;
      }

      .sk-cube-grid .sk-cube4 {
          -webkit-animation-delay: 0.1s;
          animation-delay: 0.1s;
      }

      .sk-cube-grid .sk-cube5 {
          -webkit-animation-delay: 0.2s;
          animation-delay: 0.2s;
      }

      .sk-cube-grid .sk-cube6 {
          -webkit-animation-delay: 0.3s;
          animation-delay: 0.3s;
      }

      .sk-cube-grid .sk-cube7 {
          -webkit-animation-delay: 0s;
          animation-delay: 0s;
      }

      .sk-cube-grid .sk-cube8 {
          -webkit-animation-delay: 0.1s;
          animation-delay: 0.1s;
      }

      .sk-cube-grid .sk-cube9 {
          -webkit-animation-delay: 0.2s;
          animation-delay: 0.2s;
      }

      @-webkit-keyframes sk-cubeGridScaleDelay {

          0%,
          70%,
          100% {
              -webkit-transform: scale3D(1, 1, 1);
              transform: scale3D(1, 1, 1);
          }

          35% {
              -webkit-transform: scale3D(0, 0, 1);
              transform: scale3D(0, 0, 1);
          }
      }

      @keyframes sk-cubeGridScaleDelay {

          0%,
          70%,
          100% {
              -webkit-transform: scale3D(1, 1, 1);
              transform: scale3D(1, 1, 1);
          }

          35% {
              -webkit-transform: scale3D(0, 0, 1);
              transform: scale3D(0, 0, 1);
          }
      }

      a{scroll-behavior:  smooth;}
        .swiper-slide {
          text-align: center;
          font-size: 18px;
          background: #fff;
          /* Center slide text vertically */
          display: -webkit-box;
          display: -ms-flexbox;
          display: flex;
          -webkit-box-pack: center;
          -ms-flex-pack: center;
          justify-content: center;
          -webkit-box-align: center;
          -ms-flex-align: center;
          align-items: center;
        }

        img {
          max-width: 100%;
          height: auto;
        }

        .swiper-button-next, .swiper-button-prev{color:blue;}
    </style>
</head>
<body class="bg-gray-100 h-screen antialiased leading-none">
    <div>
        @if(Route::currentRouteName() == 'login' || Route::currentRouteName() == 'register')
        @else
            <nav class="px-6  py-8 max-w-screen-lg mx-auto">
                <div class="flex items-center justify-between">
                    <div class="mr-6">
                        <a href="{{ url('/') }}" class="text-lg font-semibold text-blue-900 no-underline">
                            {{ config('app.name', 'Laravel') }}
                        </a>
                    </div>
                    <div class="flex justify-end items-center">
                        <a class="no-underline   text-white text-sm px-4 py-3 bg-indigo-600 hover:opacity-75 rounded-lg mr-3" href="{{ route('events.all') }}">{{ __('Browse') }}</a>
                        @guest
                            <a class="no-underline hover:underline text-blue-900 text-sm p-3" href="{{ route('login') }}">{{ __('Login') }}</a>
                            
                        @else
                            
                          <div class="relative flex flex-row items-center text-right" 
                            x-data="{ open : false}">
                            <div class="flex items-center">
                              @if(auth()->user()->avatar)
                                <img  src="/storage/{{ auth()->user()->avatar }}" class="w-8 h-8 rounded-full object-cover object-center">
                                <svg
                                  x-on:click="open = !open;"
                                  class="ml-2 h-8 w-8 text-blue-600 cursor-pointer hover:text-blue-500" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" /></svg>
                              @else
                                <svg  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-blue-600 hover:text-blue-500 rounded-full object-cover object-center">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                <svg
                                  x-on:click="open = !open;"
                                  class="ml-2 h-8 w-8 text-blue-600 cursor-pointer hover:text-blue-500" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" /></svg>
                              @endif
                            </div>
                            <div 
                              x-show.transition.70ms="open"
                               class="absolute top-0 right-0 mt-10 px-2 py-1 rounded flex  flex-col border-gray-200 border z-20  bg-gray-100">
                                <a href="/home" class="no-underline hover:underline text-blue-600 text-sm  md:text-md hover:font-semibold p-3 {{ (Route::currentRouteName() == 'home') ? 'underline font-semibold' : ''}}">Dashboard</a>
                                <a href="/profile" class="no-underline hover:underline text-blue-600 text-sm  md:text-md hover:font-semibold p-3 {{ (Route::currentRouteName() == 'profile') ? 'underline font-semibold' : ''}}">Profile</a>
                                <a href="{{ route('user.logout') }}"
                                  class="no-underline hover:underline text-blue-600 text-sm md:text-md hover:font-semibold p-3"
                                  onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                                <form id="logout-form" action="{{ route('user.logout') }}" method="POST" class="hidden">
                                    {{ csrf_field() }}
                                </form>

                            </div>
                          </div>

                        @endguest
                    </div>
                </div>
            </nav>
        @endif

        @include('sweetalert::alert')
        <div class="max-w-screen-lg mx-auto px-6  py-2">


          @yield('content')
          @yield('authentication')
        </div>

      @if(Route::currentRouteName() == 'login' || Route::currentRouteName() == 'register')
      @else
        <footer>
            <div class="bg-gray-700">

              <div class="max-w-screen-lg mx-auto px-6 py-8">
                  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 relative">
                        
                      <livewire:user.newsletter/>
                                
                      <div class="">
                          <h3 class="text-white hover:opacity-75 mb-8 text-md  pr-3">Useful Links</h3>
                          
                          <div class="flex flex-col items-right md:justify-end w-full mt-4">
                              <li class="list-none mb-4 md:mb-2">
                                  <a href="/shoes" class="text-white hover:opacity-75">
                                      Events
                                  </a>
                              </li>
                              <li class="list-none mb-4 md:mb-2">
                                  <a href="/#" class="text-white hover:opacity-75">
                                      Privacy Policy
                                  </a>
                              </li>
                              <li class="list-none mb-4 md:mb-2">
                                  <a href="/#" class="text-white hover:opacity-75">
                                      Terms & Conditions
                                  </a>
                              </li>
                              <li class="list-none mb-4 md:mb-2">
                                  <a href="/#" class="text-white hover:opacity-75">
                                      How it Works
                                  </a>
                              </li>
                          </div>
                          
                      </div>
                      <div class="flex flex-col mb-8 ">
                          <h3 class="text-white hover:opacity-75 mb-4 text-md pr-3">About</h3>
                          <p class="text-white leading-relaxed">
                              Talk Events is a startup just 4 months in the business that assists people to find variety of free as well as paid events around the world.
                          </p>
                      </div>
                      
                  </div>
                  <div class="flex flex-row justify-between items-center mt-12">
                      <span class="font-sm text-sm text-white">&copy; Talk Events 2020</span>
                      <div class="flex items-center">
                        <a href="/#" class="text-white hover:opacity-75">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather w-6 h-6 md:ml-4 feather-twitter">
                                <path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path>
                            </svg>
                        </a>
                        <a href="/#" class="text-white hover:opacity-75">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather w-6 h-6 md:ml-4 feather-facebook">
                                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                            </svg>
                        </a>
            
                        <a href="/#" class="text-white hover:opacity-75">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather w-6 h-6 md:ml-4 feather-instagram">
                                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                            </svg>
                        </a>
                    </div>
                  </div>
              </div>
            
            </div>
        </footer>
        <a href="#" id="upTO" class="fixed bottom-0 right-0 mr-12 mb-12">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-indigo-500 hover:opacity-75 " viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <polyline points="16 12 12 8 8 12"></polyline>
                <line x1="12" y1="16" x2="12" y2="8"></line>
            </svg>
        </a>
      @endif
    </div>

    <script src="{{ asset('/js/debounce.min.js') }}"></script>
    <livewire:scripts />
    @stack('scripts')
    <script>
      document.addEventListener('DOMContentLoaded', function(){
          const upTO   = document.getElementById('upTO');
          function debounce(func, wait = 10, immediate = true) {
            var timeout;
            return function() {
                var context = this,
                    args = arguments;
                var later = function() {
                    timeout = null;
                    if (!immediate) func.apply(context, args);
                };
                var callNow = immediate && !timeout;
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
                if (callNow) func.apply(context, args);
            }
          }

      });
    </script>
</body>
</html>
