   <header class="header">
       <div class="container">
           <div class="row">
               <div class="col-lg-2">
                   <div class="header__logo">
                       <a href="{{ route('client.home') }}">
                           <img src="{{ asset('assets/client/img/ChatGPT Image 15_59_04 19 thg 6, 2025.png') }}"
                               alt="">
                       </a>
                   </div>
               </div>
               <div class="col-lg-8">
                   <div class="header__nav">
                       <nav class="header__menu mobile-menu">
                           <ul>
                               <li class="active"><a href="{{ route('client.home') }}">Trang chủ</a></li>
                               <li><a href="{{ route('client.movie') }}">Phim lẻ</a></li>
                               <li><a href="{{ route('client.series') }}">Phim bộ</a></li>
                               <li><a href="">Thể loại <span class="arrow_carrot-down"></span></a>
                                   <ul class="dropdown">
                                       @foreach ($genres as $genre)
                                           <li>
                                               <a href="{{ route('genres.index', ['genre' => $genre->slug]) }}">
                                                   {{ $genre->name }}
                                               </a>
                                           </li>
                                       @endforeach


                                       {{-- <li><a href="./categories.html">Categories</a></li>
                                       <li><a href="./anime-details.html">Anime Details</a></li>
                                       <li><a href="./anime-watching.html">Anime Watching</a></li>
                                       <li><a href="./blog-details.html">Blog Details</a></li>
                                       <li><a href="./signup.html">Sign Up</a></li>
                                       <li><a href="./login.html">Login</a></li> --}}
                                   </ul>
                               </li>
                               <li><a href="">Quốc gia <span class="arrow_carrot-down"></span></a>
                                   <ul class="dropdown">
                                       @foreach ($countries as $country)
                                           <li>
                                               <a href="{{ route('client.country', $country->slug) }}">
                                                   {{ $country->name }}
                                               </a>
                                           </li>
                                       @endforeach


                                       {{-- <li><a href="./categories.html">Categories</a></li>
                                       <li><a href="./anime-details.html">Anime Details</a></li>
                                       <li><a href="./anime-watching.html">Anime Watching</a></li>
                                       <li><a href="./blog-details.html">Blog Details</a></li>
                                       <li><a href="./signup.html">Sign Up</a></li>
                                       <li><a href="./login.html">Login</a></li> --}}
                                   </ul>
                               </li>
                               <li><a href="">Năm <span class="arrow_carrot-down"></span></a>
                                   <ul class="dropdown">
                                       @foreach ($years as $year)
                                           <li>
                                               <a href="{{ route('client.year', ['year' => $year]) }}">
                                                   {{ $year }}
                                               </a>
                                           </li>
                                       @endforeach



                                   </ul>
                               </li>

                           </ul>
                       </nav>
                   </div>
               </div>
               <div class="col-lg-2">
                   <div class="header__right">
                       <a href="#" class="search-switch"><span class="icon_search"></span></a>

                       @guest
                           {{-- Chưa đăng nhập --}}
                           <a href="{{ route('login') }}"><span class="icon_profile"></span></a>
                       @else
                           {{-- Đã đăng nhập --}}
                           <div class="dropdown" style="display: inline-block; position: relative;">
                               <a href="#" onclick="event.preventDefault(); toggleDropdown()"
                                   style="cursor: pointer;">
                                   {{-- Avatar hoặc icon --}}
                                   @php
                                       $name = Auth::user()->name ?? 'U';
                                       $initial = strtoupper(mb_substr($name, 0, 1));
                                   @endphp

                                   <div
                                       style="width: 32px; height: 32px; border-radius: 50%; background-color: #007bff; color: white;
            display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 14px;">
                                       {{ $initial }}
                                   </div>
                               </a>
                               <div id="dropdown-menu"
                                   style="display: none; position: absolute; top: 100%; right: 0; background: white; border: 1px solid #ddd; padding: 10px;">
                                   <form action="{{ route('logout') }}" method="POST">
                                       @csrf

                                       <button type="submit" style="background: none; border: none; color: red;">Đăng
                                           xuất</button>
                                       @if ( auth()->user()->isAdmin())
                                           <a style="background: none; border: none; color: red;"  href="{{ route('admin.') }}">Quản trị</a>
                                       @endif
                                   </form>

                               </div>
                           </div>

                           <script>
                               function toggleDropdown() {
                                   const menu = document.getElementById('dropdown-menu');
                                   menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
                               }
                           </script>
                       @endguest
                   </div>
               </div>

           </div>
           <div id="mobile-menu-wrap"></div>
       </div>
   </header>
