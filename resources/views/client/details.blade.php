@extends('client.master')
@section('content')
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="./index.html"><i class="fa fa-home"></i> Trang chủ</a>
                        <a href="./categories.html">Thể loại</a>
                        <span>Chi tiết</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Anime Section Begin -->
    <section class="anime-details spad">
        <div class="container">
            <div class="anime__details__content">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="anime__details__pic "
                            style="background-image: url('{{ Storage::url($movie->thumbnail) }}');">
                            {{-- <div class="comment"><i class="fa fa-comments"></i> 11</div>
                            <div class="view"><i class="fa fa-eye"></i> 9141</div> --}}
                        </div>
                        {{-- @if ($movie->trailer_url)
                            <div class="movie-trailer my-4">
                                <h4>Trailer</h4>
                                <div class="embed-responsive embed-responsive-16by9">
                                    <iframe class="embed-responsive-item"
                                        src="{{ preg_replace('/watch\\?v=([a-zA-Z0-9_-]+)/', 'embed/$1', $movie->trailer_url) }}"
                                        allowfullscreen>
                                    </iframe>
                                </div>
                            </div>
                        @endif --}}
                    </div>
                    <div class="col-lg-9">
                        <div class="anime__details__text">
                            <div class="anime__details__title">
                                <h3>{{ $movie->title }}</h3>
                                <span>Đạo diễn: {{ $movie->director->name }}</span>
                            </div>
                            {{-- <div class="anime__details__rating">
                                <div class="rating">
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star-half-o"></i></a>
                                </div>
                                <span>1.029 Votes</span>
                            </div> --}}
                            <p>{{ $movie->description }}</p>

                            <div class="anime__details__widget">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <ul>
                                            <li><span>Thể loại:</span>
                                                @foreach ($movie->genres as $genre)
                                                    {{ $genre->name }} @if (!$loop->last)
                                                        ,
                                                    @endif
                                                @endforeach
                                            </li>
                                            <li><span>Quốc Gia:</span> {{ $movie->country->name }}</li>
                                            <li><span>Loại phim</span>
                                                @if ($movie->type == 'movie')
                                                    Phim lẻ
                                                @else
                                                    Phim bộ
                                                @endif

                                            </li>
                                            <li><span>Năm Phát hành:</span> {{ $movie->year }}</li>
                                            <li><span>Diễn Viên </span>
                                                @foreach ($movie->actors as $actor)
                                                    {{ $actor->name }} @if (!$loop->last)
                                                        ,
                                                    @endif
                                                @endforeach
                                            </li>
                                        </ul>
                                    </div>
                                    {{-- <div class="col-lg-6 col-md-6">
                                        <ul>
                                            <li><span>Thời gian</span> {{ $movie-> }}</li>
                                            <li><span>Rating:</span> 8.5 / 161 times</li>
                                            <li><span>Duration:</span> 24 min/ep</li>
                                            <li><span>Quality:</span> HD</li>
                                            <li><span>Views:</span> 131,541</li>
                                        </ul>
                                    </div> --}}
                                </div>
                            </div>
                            <div class="anime__details__btn">
                                <a href="#" class="follow-btn"><i class="fa fa-heart-o"></i> Follow</a>
                                <a href="{{ route('client.watch', $movie->slug) }}" class="watch-btn"><span>Watch Now</span>
                                    <i class="fa fa-angle-right"></i></a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <h4 style="color: white">Trailler:</h4>
            @if ($movie->trailer_url)
                <div class="anime__details__trailer" style="margin: 20px 0px;">
                    <div class="embed-responsive embed-responsive-16by9"
                        style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden;">
                        <iframe src="{{ getYoutubeEmbedUrl($movie->trailer_url) }}" frameborder="0" allowfullscreen
                            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
                        </iframe>
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-8 col-md-8">
                    <div class="anime__details__review">
                        <div class="section-title">
                            <h5>Reviews</h5>
                        </div>
                        <div id="commentList">
                            @foreach ($movie->comments()->with('user')->latest()->get() as $comment)
                                @include('client.components.comment-item', ['comment' => $comment])
                            @endforeach
                        </div>

                    </div>
                    <div class="anime__details__form">
                        <div class="section-title">
                            <h5>Your Comment</h5>
                        </div>
                        @auth
                            <form id="commentForm">
                                @csrf
                                <input type="hidden" name="movie_id" value="{{ $movie->id }}">
                                <textarea name="content" placeholder="Your Comment" required></textarea>
                                <button type="submit"><i class="fa fa-location-arrow"></i> Review</button>
                            </form>
                        @else
                            <p>Bạn cần <a href="{{ route('showLogin') }}">đăng nhập</a> để bình luận.</p>
                        @endauth

                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="anime__details__sidebar">
                        <div class="section-title">
                            <h5>you might like...</h5>
                        </div>
                        <div class="product__sidebar__view__item set-bg"
                            data-setbg="{{ asset('assets/client/img/sidebar/tv-1.jpg') }}">
                            <div class="ep">18 / ?</div>
                            <div class="view"><i class="fa fa-eye"></i> 9141</div>
                            <h5><a href="#">Boruto: Naruto next generations</a></h5>
                        </div>
                        <div class="product__sidebar__view__item set-bg"
                            data-setbg="{{ asset('assets/client/img/sidebar/tv-2.jpg') }}">
                            <div class="ep">18 / ?</div>
                            <div class="view"><i class="fa fa-eye"></i> 9141</div>
                            <h5><a href="#">The Seven Deadly Sins: Wrath of the Gods</a></h5>
                        </div>
                        <div class="product__sidebar__view__item set-bg"
                            data-setbg="{{ asset('assets/client/img/sidebar/tv-3.jpg') }}">
                            <div class="ep">18 / ?</div>
                            <div class="view"><i class="fa fa-eye"></i> 9141</div>
                            <h5><a href="#">Sword art online alicization war of underworld</a></h5>
                        </div>
                        <div class="product__sidebar__view__item set-bg"
                            data-setbg="{{ asset('assets/client/img/sidebar/tv-4.jpg') }}">
                            <div class="ep">18 / ?</div>
                            <div class="view"><i class="fa fa-eye"></i> 9141</div>
                            <h5><a href="#">Fate/stay night: Heaven's Feel I. presage flower</a></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#commentForm').submit(function(e) {
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: '{{ route('comments.store') }}',
                data: $(this).serialize(),
                success: function(response) {
                    $('#commentList').prepend(response.html); // Chèn bình luận mới
                    $('#commentForm')[0].reset(); // Xoá form
                },
                error: function() {
                    alert("Có lỗi xảy ra. Vui lòng thử lại.");
                }
            });
        });
    </script>
@endsection
