<div class="sidebar-wrap">
    @include('social-btn')

    <div class="sidebar-widget">
        <div class="widget-tittle">
            <h2>
                {{ __('general.recent') }}
            </h2>
            <span></span>
        </div>
        <ul class="recent-post">
            @isset($latest)
                @foreach ($latest as $lat)
                    <li>
                        <div class="thumb">
                            <img loading="lazy" data-lazy="true"  src="{{ asset($lat->image) }}" alt="thumb">
                        </div>
                        <div class="recent-post-meta">
                            <h3><a href="{{ route(isset($health) ? 'health-infos.show' : 'get.new', $lat->id) }}">
                                    {{ $lat['title_' . app()->getLocale()] }}
                                </a></h3>
                            <a href="{{ route(isset($health) ? 'health-infos.archive' : 'news.archive', [$lat->updated_at->year, $lat->updated_at->format('m')])}}" class="date"><i class="far fa-calendar-alt"></i>
                                {{ $lat->updated_at->translatedFormat('d M Y') }}
                            </a>
                        </div>
                    </li>
                @endforeach
            @endisset
        </ul>
    </div>
    <!--/.recent-posts -->

    <div class="sidebar-widget">
        <div class="widget-tittle">
            <h2>
                {{ __('general.Archives') }}
            </h2>
            <span></span>
        </div>
        <ul class="categories archive">
            @php
                $dt = now();
            @endphp
            @isset($archives)
                @foreach ($archives as $arch)
                    @php
                        $dt->setYear($arch->year);
                        $dt->setMonth($arch->month);
                    @endphp

                    <li>
                        <a href="{{ route(isset($health) ? 'health-infos.archive' : 'news.archive', [$dt->year, $dt->format('m')]) }}">
                            {{ $dt->locale(app()->getLocale())->monthName }}
                            <span>
                                {{ $dt->year }}
                            </span>
                        </a>
                    </li>
                @endforeach
            @endisset
        </ul>
    </div>
    <!--/. archives-->
</div>
