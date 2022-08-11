@extends('layouts.website.app')

@section('title') {{__('general.Health Information')}} @endsection

@section('styles')
<style>
    .article .card {
        transition: all ease-in .4s;
    }
    .article .card:hover {
        box-shadow: 0 0 5px #000;
        transform: scale(1.1);
    }
</style>
@endsection

@section('pageName')
    <body class="page-blog dm-dark"> @endsection

    @section('content')
        <main class="page-main">
            <div class="section-first-screen">
                <div class="first-screen__bg"
                     style="background-image: url({{asset('website-assets/img/pages/home/health.jpg')}}"></div>
                <div class="first-screen__content">
                    <div class="uk-container">
                        <div class="first-screen__box">
                            <h2 class="first-screen__title">{{__('general.Health Information')}}</h2>
                            <div class="first-screen__breadcrumb">
                                <ul class="uk-breadcrumb">
                                    <li><a href="/">{{__('menu.Home')}}</a></li>
                                    <li><span>{{__('general.Health Information')}}</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-content">
                <div class="uk-margin-large-top uk-container">
                    <div class="uk-grid data-uk-grid container h-100 d-flex justify-content-center" >
                        <div class="uk-width-2-3@m align-self-md-center">
                            @if(isset($infos))
                                @foreach($infos as $info)
                                    {{-- <article class="article-intro">
                                   
                                        <div class="article-intro__body align text-center">
                                            <div class="article-intro__info">
                                               
                                                <div class="article-intro__date"><i
                                                        class="fas fa-calendar-alt"></i><span>{{$info->created_at}}</span>
                                                </div>
                                               
                                            </div>
                                            <h2 class="article-intro__title">           {{(app()->getLocale() == 'ar') ?$info->title_ar:$info->title_en}}</h2>
                                            <div class="article-intro__content">
                                                <div> {!! nl2br(e((app()->getLocale() == 'ar') ?$info ->description_ar:$info->description_en)) !!} </div>
                                            </div>
                                           
                                        </div>
                                    </article> --}}
                                    <article class="article">
                                        <div class="card mb-3 rounded">
                                            <img class="card-img-top" src="{{$info->image}}" alt="{{$info->title_en}}" style="max-height: 200px" />
                                            <div class="card-body">
                                              <h5 class="card-title">
                                                {{app()->getLocale() === 'ar' ? $info->title_ar : $info->title_en}}
                                              </h5>
                                              <p class="card-text text-muted">
                                                {{app()->getLocale() === 'ar' ? $info->description_ar : $info->description_en}}
                                              </p>
                                              <p class="card-text text-muted">
                                                <i class="fas fa fa-clock"></i>
                                                <small class="text-muted">
                                                {{$info->updated_at->diffForHumans()}}    
                                            </small></p>
                                            </div>
                                          </div>
                                    </article>
                                @endforeach
                            @endif
                            {{--                        <article class="article-intro">--}}
                            {{--                            <div class="article-intro__image">--}}
                            {{--                                <div class="video" data-uk-lightbox="video-autoplay:true; index: 1"><a href="https://www.youtube.com/watch?v=c2pz2mlSfXA" data-attrs="width: 1280; height: 720;"><img src="{{asset('website-assets/img/blog/img-blog-full-2.png')}}" alt="img-article"></a></div>--}}
                            {{--                            </div>--}}
                            {{--                            <div class="article-intro__body">--}}
                            {{--                                <div class="article-intro__info">--}}
                            {{--                                    <div class="article-intro__author"><i class="fas fa-user"></i><span>By Sam Joseph</span></div>--}}
                            {{--                                    <div class="article-intro__category"><i class="fas fa-folder-open"></i><span>Posted in FOOD</span></div>--}}
                            {{--                                    <div class="article-intro__date"><i class="fas fa-calendar-alt"></i><span>July 31, 2020</span></div>--}}
                            {{--                                    <div class="article-intro__comments"><i class="fas fa-comment"></i><span>210</span></div>--}}
                            {{--                                </div>--}}
                            {{--                                <h2 class="article-intro__title">Juicy White Meat With Light Bread</h2>--}}
                            {{--                                <div class="article-intro__content">--}}
                            {{--                                    <p>Incididunt ut labore et dolore magna aliqua enim ad minim veniam quisya nos exercitation ullamco laboris nisi ut aliquip ex ea com labmodo consequat dhuis irure dolor in reprehesa deritn volupta velit esse fst anim laborum.</p>--}}
                            {{--                                </div>--}}
                            {{--                                <div class="article-intro__bottom">--}}
                            {{--                                    <div class="article-intro__tags"><i class="fas fa-tags"></i><span>cheese, Pizza, Cookies, Bake</span></div>--}}
                            {{--                                    <div class="article-intro__more"><a class="uk-button" href="page-blog-article.html">Read More</a></div>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                            {{--                        </article>--}}
                            {{--                        <article class="article-intro">--}}
                            {{--                            <div class="article-intro__image">--}}
                            {{--                                <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1" data-uk-slideshow>--}}
                            {{--                                    <ul class="uk-slideshow-items">--}}
                            {{--                                        <li><img src="{{asset('website-assets/img/blog/img-blog-full-3.png')}}" alt data-uk-cover></li>--}}
                            {{--                                        <li><img src="{{asset('website-assets/img/blog/img-blog-full-2.png')}}" alt data-uk-cover></li>--}}
                            {{--                                        <li><img src="{{asset('website-assets/img/blog/img-blog-full-1.jpg')}}" alt data-uk-cover></li>--}}
                            {{--                                    </ul><a class="uk-position-center-left" href="#" data-uk-slidenav-previous data-uk-slideshow-item="previous"></a><a class="uk-position-center-right" href="#" data-uk-slidenav-next data-uk-slideshow-item="next"></a>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                            {{--                            <div class="article-intro__body">--}}
                            {{--                                <div class="article-intro__info">--}}
                            {{--                                    <div class="article-intro__author"><i class="fas fa-user"></i><span>By Sam Joseph</span></div>--}}
                            {{--                                    <div class="article-intro__category"><i class="fas fa-folder-open"></i><span>Posted in FOOD</span></div>--}}
                            {{--                                    <div class="article-intro__date"><i class="fas fa-calendar-alt"></i><span>July 31, 2020</span></div>--}}
                            {{--                                    <div class="article-intro__comments"><i class="fas fa-comment"></i><span>210</span></div>--}}
                            {{--                                </div>--}}
                            {{--                                <h2 class="article-intro__title">Juicy White Meat With Light Bread</h2>--}}
                            {{--                                <div class="article-intro__content">--}}
                            {{--                                    <p>Incididunt ut labore et dolore magna aliqua enim ad minim veniam quisya nos exercitation ullamco laboris nisi ut aliquip ex ea com labmodo consequat dhuis irure dolor in reprehesa deritn volupta velit esse fst anim laborum.</p>--}}
                            {{--                                </div>--}}
                            {{--                                <div class="article-intro__bottom">--}}
                            {{--                                    <div class="article-intro__tags"><i class="fas fa-tags"></i><span>cheese, Pizza, Cookies, Bake</span></div>--}}
                            {{--                                    <div class="article-intro__more"><a class="uk-button" href="page-blog-article.html">Read More</a></div>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                            {{--                        </article>--}}
                            {{--                        <article class="article-intro">--}}
                            {{--                            <div class="article-intro__image"><a href="page-blog-article.html"><img src="{{asset('website-assets/img/blog/img-blog-full-4.png')}}" alt="img-article"></a></div>--}}
                            {{--                            <div class="article-intro__body">--}}
                            {{--                                <div class="article-intro__info">--}}
                            {{--                                    <div class="article-intro__author"><i class="fas fa-user"></i><span>By Sam Joseph</span></div>--}}
                            {{--                                    <div class="article-intro__category"><i class="fas fa-folder-open"></i><span>Posted in FOOD</span></div>--}}
                            {{--                                    <div class="article-intro__date"><i class="fas fa-calendar-alt"></i><span>July 31, 2020</span></div>--}}
                            {{--                                    <div class="article-intro__comments"><i class="fas fa-comment"></i><span>210</span></div>--}}
                            {{--                                </div>--}}
                            {{--                                <h2 class="article-intro__title">The Ultimate King: Chicken Burger</h2>--}}
                            {{--                                <div class="article-intro__content">--}}
                            {{--                                    <p>Incididunt ut labore et dolore magna aliqua enim ad minim veniam quisya nos exercitation ullamco laboris nisi ut aliquip ex ea com labmodo consequat dhuis irure dolor in reprehesa deritn volupta velit esse fst anim laborum.</p>--}}
                            {{--                                </div>--}}
                            {{--                                <div class="article-intro__bottom">--}}
                            {{--                                    <div class="article-intro__tags"><i class="fas fa-tags"></i><span>cheese, Pizza, Cookies, Bake</span></div>--}}
                            {{--                                    <div class="article-intro__more"><a class="uk-button" href="page-blog-article.html">Read More</a></div>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                            {{--                        </article>--}}
                            {{--                            <ul class="uk-pagination uk-flex-center uk-margin-medium-top">--}}
                            {{--                                <li class="uk-active"><span>1</span></li>--}}
                            {{--                                <li><a href="#">2</a></li>--}}
                            {{--                                <li><a href="#">3</a></li>--}}
                            {{--                                <li class="uk-disabled"><span>...</span></li>--}}
                            {{--                                <li><a href="#"><span data-uk-pagination-next></span></a></li>--}}
                            {{--                            </ul>--}}
                            {{--                        </div>--}}
                            {{--                        <div class="uk-width-1-3@m">--}}
                            {{--                        <aside class="sidebar">--}}
                            {{--                            <div class="widjet widjet-search">--}}
                            {{--                                <form class="uk-search uk-search-default" action="#!"><button class="uk-search-icon-flip" data-uk-search-icon type="submit"></button><input class="uk-input uk-search-input uk-form-large" type="search" placeholder="Search blog ..."></form>--}}
                            {{--                            </div>--}}
                            {{--                            <div class="widjet widjet-category">--}}
                            {{--                                <div class="widjet__title">Categories</div>--}}
                            {{--                                <ul class="list-category">--}}
                            {{--                                    <li> <a href="page-blog.html"> <span class="title">Fresh Foods</span><span class="col">(30)</span></a></li>--}}
                            {{--                                    <li> <a href="page-blog.html"> <span class="title">Italian Pizza</span><span class="col">(5)</span></a></li>--}}
                            {{--                                    <li> <a href="page-blog.html"> <span class="title">Lifestyle</span><span class="col">(16)</span></a></li>--}}
                            {{--                                    <li> <a href="page-blog.html"> <span class="title">Street Food</span><span class="col">(47)</span></a></li>--}}
                            {{--                                    <li> <a href="page-blog.html"> <span class="title">Vegetarian & Meat</span><span class="col">(23)</span></a></li>--}}
                            {{--                                </ul>--}}
                            {{--                            </div>--}}
                            {{--                            <div class="widjet widjet-list-articles">--}}
                            {{--                                <div class="widjet__title">Popular Posts</div>--}}
                            {{--                                <ul class="list-articles">--}}
                            {{--                                    <li class="list-articles-item"><a class="list-articles-item__link" href="page-blog-article.html">--}}
                            {{--                                            <div class="list-articles-item__img"><img src="{{asset('website-assets/img/blog/img-article-thumb-1.jpg')}}" alt="article-thumb"></div>--}}
                            {{--                                            <div class="list-articles-item__info">--}}
                            {{--                                                <div class="list-articles-item__title">Soft & Freshly Baked Chocolate Cookies With Addons</div>--}}
                            {{--                                                <div class="list-articles-item__date">Posted: July 31, 2020</div>--}}
                            {{--                                            </div>--}}
                            {{--                                        </a></li>--}}
                            {{--                                    <li class="list-articles-item"><a class="list-articles-item__link" href="page-blog-article.html">--}}
                            {{--                                            <div class="list-articles-item__img"><img src="{{asset('website-assets/img/blog/img-article-thumb-2.jpg')}}" alt="article-thumb"></div>--}}
                            {{--                                            <div class="list-articles-item__info">--}}
                            {{--                                                <div class="list-articles-item__title">Some of the Best Pizza Toppings of World 2020</div>--}}
                            {{--                                                <div class="list-articles-item__date">Posted: July 31, 2020</div>--}}
                            {{--                                            </div>--}}
                            {{--                                        </a></li>--}}
                            {{--                                    <li class="list-articles-item"><a class="list-articles-item__link" href="page-blog-article.html">--}}
                            {{--                                            <div class="list-articles-item__img"><img src="{{asset('website-assets/img/blog/img-article-thumb-3.jpg')}}" alt="article-thumb"></div>--}}
                            {{--                                            <div class="list-articles-item__info">--}}
                            {{--                                                <div class="list-articles-item__title">Why You Should Take Desserts After Every Meal</div>--}}
                            {{--                                                <div class="list-articles-item__date">Posted: July 31, 2020</div>--}}
                            {{--                                            </div>--}}
                            {{--                                        </a></li>--}}
                            {{--                                    <li class="list-articles-item"><a class="list-articles-item__link" href="page-blog-article.html">--}}
                            {{--                                            <div class="list-articles-item__img"><img src="{{asset('website-assets/img/blog/img-article-thumb-3.jpg')}}" alt="article-thumb"></div>--}}
                            {{--                                            <div class="list-articles-item__info">--}}
                            {{--                                                <div class="list-articles-item__title">Fresh and Premium Sandwiches With Garlic Meat</div>--}}
                            {{--                                                <div class="list-articles-item__date">Posted: July 31, 2020</div>--}}
                            {{--                                            </div>--}}
                            {{--                                        </a></li>--}}
                            {{--                                </ul>--}}
                            {{--                            </div>--}}
                            {{--                            <div class="widjet widjet-tags-cloud">--}}
                            {{--                                <div class="widjet__title">All Tags</div>--}}
                            {{--                                <ul class="tags-list">--}}
                            {{--                                    <li><a href="#!">Lunch</a></li>--}}
                            {{--                                    <li> <a href="#!">Pizza</a></li>--}}
                            {{--                                    <li><a href="#!">Burger</a></li>--}}
                            {{--                                    <li><a href="#!">Noodles</a></li>--}}
                            {{--                                    <li> <a href="#!">Desserts</a></li>--}}
                            {{--                                    <li><a href="#!">Sushi</a></li>--}}
                            {{--                                    <li> <a href="#!">Fast Food</a></li>--}}
                            {{--                                    <li><a href="#!">Lifestyle</a></li>--}}
                            {{--                                </ul>--}}
                            {{--                            </div>--}}
                            {{--                            <div class="widjet widjet-gallery">--}}
                            {{--                                <div class="widjet__title">Food Gallery</div>--}}
                            {{--                                <div class="uk-grid uk-grid-small uk-child-width-1-3" data-uk-grid data-uk-lightbox>--}}
                            {{--                                    <div><img class="uk-width-1-1" src="{{asset('website-assets/img/blog/img-gallery-thumb-1.jpg')}}" alt="gallery"></div>--}}
                            {{--                                    <div><img class="uk-width-1-1" src="{{asset('website-assets/img/blog/img-gallery-thumb-2.jpg')}}" alt="gallery"></div>--}}
                            {{--                                    <div><img class="uk-width-1-1" src="{{asset('website-assets/img/blog/img-gallery-thumb-3.jpg')}}" alt="gallery"></div>--}}
                            {{--                                    <div><img class="uk-width-1-1" src="{{asset('website-assets/img/blog/img-gallery-thumb-4.jpg')}}" alt="gallery"></div>--}}
                            {{--                                    <div><img class="uk-width-1-1" src="{{asset('website-assets/img/blog/img-gallery-thumb-5.jpg')}}" alt="gallery"></div>--}}
                            {{--                                    <div><img class="uk-width-1-1" src="{{asset('website-assets/img/blog/img-gallery-thumb-6.jpg')}}" alt="gallery"></div>--}}
                            {{--                                    <div><img class="uk-width-1-1" src="{{asset('website-assets/img/blog/img-gallery-thumb-7.jpg')}}" alt="gallery"></div>--}}
                            {{--                                    <div><img class="uk-width-1-1" src="{{asset('website-assets/img/blog/img-gallery-thumb-8.jpg')}}" alt="gallery"></div>--}}
                            {{--                                    <div><img class="uk-width-1-1" src="{{asset('website-assets/img/blog/img-gallery-thumb-9.jpg')}}" alt="gallery"></div>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                            {{--                        </aside>--}}
                        </div>
                    </div>
                </div>
            </div>
        </main>
@endsection

@section('scripts')@endsection
