@extends('layouts.website.app')

@section('title')
    Item
@endsection

@section('styles')
    <style>
        .text-danger {
            color: #f32129;
        }

        .food-item {
            border: 1px solid;
            border-radius: 2px;
            display: inline-block;
            font-size: 8px;
            height: 13px;
            line-height: 11px;
            text-align: center;
            width: 13px;
        }

        [class*=" icofont-"],
        [class^=icofont-] {
            font-family: IcoFont !important;
            speak: none;
            font-style: normal;
            font-weight: 400;
            font-variant: normal;
            text-transform: none;
            white-space: nowrap;
            word-wrap: normal;
            direction: ltr;
            -webkit-font-feature-settings: "liga";
            -webkit-font-smoothing: antialiased;
        }

        h6 {
            font-family: inherit;
            font-weight: 600;
        }

        body.dm-light {
            background: #f5f5f5 !important;
        }

        .dot-borderd {
            border: 1px solid;
            width: 15px;
            height: 15px;
            text-align: center;
            border-radius: 3px;
            font-size: 35px;
            line-height: 7px;
        }
    </style>
@endsection

@section('pageName')

    <body class="page-product dm-dark">
    @endsection

    @section('content')
        <main class="page-main">
            <div class="section-first-screen">
                <div class="first-screen__bg"
                    style="background-image: url({{ asset('website-assets/img/pages/contacts/bg-first-screen.jpg') }})">
                </div>
                <div class="first-screen__content">
                    <div class="uk-container">
                        <div class="first-screen__box">
                            <h2 class="first-screen__title">
                                {{ app()->getLocale() == 'ar' ? $item['name_ar'] : $item['name_en'] }}</h2>
                            <div class="first-screen__breadcrumb">
                                <ul class="uk-breadcrumb">
                                    <li><a href="{{ route('home.page') }}">Home</a></li>
                                    <li><a
                                            href="{{ route('menu.page') }}">{{ app()->getLocale() == 'ar' ? $item['category']['name_ar'] : $item['category']['name_en'] }}</a>
                                    </li>
                                    <li><span>{{ app()->getLocale() == 'ar' ? $item['name_ar'] : $item['name_en'] }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-content" x-data="{
                items: [],
                activeItem: '',
                buy_items: {},
                addItem: function() {
                    const dough = document.querySelectorAll('[name=dough_type]');
                    let active = '';
            
                    for (let d of dough) {
                        if (d.checked) {
                            active = d;
                        }
                    }
            
                    this.items.push({
                        uid: Math.floor(Math.random() * 100000000),
                        item_id: {{ $item['id'] }},
                        title: '{{ app()->getLocale() == 'ar' ? $item['name_ar'] : $item['name_en'] }}',
                        info: '{{ app()->getLocale() == 'ar' ? $item['description_ar'] : $item['description_en'] }}',
                        category: '{{ app()->getLocale() == 'ar' ? $item['category']['name_ar'] : $item['category']['name_en'] }}',
                        calories: {{ $item->calories }},
                        dough: active.value,
                        real_price: {{ round($item->price, 2) }},
                        price: {{ round(isset($item['offer']) ? $item['offer']['offer_price'] : $item->price, 2) }},
                        offer_price: {{ isset($item['offer']) ? round($item['offer']['offer_price'], 2) : 0 }},
                        extras: [],
                        withouts: [],
                    });
                },
                removeItem: function(itemId) {
                    this.items.splice(
                        this.items.findIndex(x => x.uid === itemId),
                        1
                    );
            
                    const qty = document.querySelector('#quantity');
                    qty.value = parseInt(qty.value) - 1;
                },
                addToItem: function(type, id, name, price, itemId) {
                    this.items.map(x => {
                        if (x.uid === itemId) {
                            const found = x[type].findIndex(x => x.id === id);
                            if (found < 0) {
                                x[type].push({
                                    id: id,
                                    name: name,
                                    price: price
                                });
                            }
                        }
                        return x;
                    });
                },
                getItems: function() {
                    const it = JSON.parse(JSON.stringify(this.items));
                    it.map(x => {
                        x.extras = x.extras.map(ex => ex.id);
                        x.withouts = x.withouts.map(wi => wi.id);
                        return x;
                    });
                    return JSON.stringify(it);
                },
            }" x-on:add-item.window="addItem" x-init="addItem();
            activeItem = items[0].uid" x-ref="form">
                <div class="uk-margin-large-top uk-container">
                    <form id="addToCard" action="{{ route('add.cart') }}" method="POST" >
                        @csrf

                        <input type="hidden" name="item_id" value="{{ $item['id'] }}">
                        <input type='hidden' name='add_items' x-bind:value="getItems" />
                        <input type='hidden' name='quantity' x-bind:value="items.length" />
                         @if ($item['offer'])
                            <input type="hidden" name="offer_id" value="{{ $item['offer']['offer_id'] }}">
                            <input type="hidden" name="offer_price" value="{{ round($item['offer']['offer_price'], 2) }}">
                        @endif
                        <div class="uk-card uk-card-default uk-grid-collapse uk-child-width-1-2@s uk-margin " uk-grid>
                            <div class="uk-card-media-left uk-cover-container" style="height: 340px;">
                                <img loading="lazy" data-lazy="true"  src="{{ asset($item->image) }}" alt="pizza-big" uk-cover>
                            </div>
                            <div>
                                <div class="uk-card-body" style="padding: 15px 30px;">
                                    <h3 class="uk-card-title"
                                        data-uk-tooltip="title: {{ app()->getLocale() == 'ar' ? $item['name_ar'] : $item['name_en'] }}; pos: bottom-right"
                                        style="margin: 0">
                                        {{ app()->getLocale() == 'ar' ? $item['name_ar'] : $item['name_en'] }}
                                    </h3>
                                    <p style="margin: 0">
                                        {{ app()->getLocale() == 'ar' ? $item['description_ar'] : $item['description_en'] }}
                                    </p>

                                    <div class="product-full-card__category" style="margin: 0;margin-top: .5rem">
                                        <span>{{ __('general.Category') }}:
                                        </span><a
                                            href="{{ route('menu.page') }}">{{ app()->getLocale() == 'ar' ? $item['category']['name_ar'] : $item['category']['name_en'] }}</a>
                                    </div>
                                    <div class="product-full-card__category"><span>{{ __('home.Calories') }}:
                                            {{ $item->calories }}</span></div>
                                    <style>
                                        .dough label.active {
                                            border-color: #cc3333 !important;
                                            background-color: #cc3333 !important;
                                            background: #cc3333 !important;
                                            color: #fff !important;
                                        }

                                        .card-header.active {
                                            background: #cc3333;
                                            color: #fff !important;
                                        }

                                        .card-header.active button {
                                            color: #fff;
                                        }

                                        * {
                                            font-family: Cairo !important;
                                        }
                                    </style>

                                    <div class="btn-group btn-group-toggle dough" data-toggle="buttons" style="width: 60%;">
                                        @foreach ($item['dough_type'] as $dough)
                                            <label class="btn btn-light" for="{{ $dough['name_en'] }}"><input
                                                    id="{{ $dough['name_en'] }}" type="radio" name="dough_type"
                                                    value="{{ $dough['name_ar'] }},{{ $dough['name_en'] }}"
                                                    @if ($loop->first) checked @endif><span>{{ app()->getLocale() == 'ar' ? $dough->name_ar : $dough->name_en }}</span></label>
                                        @endforeach
                                    </div>

                                    <div class="product-full-card__inf mt-3">
                                        <div class="product-full-card__price" style="margin: 1rem;">
                                            <span>{{ __('home.Price') }}: </span><span class="value"
                                                @if ($item['offer']) style="text-decoration: line-through;font-size: 20px;" @endif>
                                                {{ round($item->price, 2) }} </span>
                                            @if ($item['offer'])
                                                <span style="font-size: 26px;color:#6dc405;text-decoration: none">
                                                    {{ round($item['offer']['offer_price'], 2) }} </span>
                                            @endif
                                            @lang('general.SR')
                                        </div>
                                        <div class="product-full-card__btns"><span class="counter"><span
                                                    class="minus">-</span><input type="text" name="quantity"
                                                    value="1" id="quantity"><span class="plus" x-data
                                                    x-on:click="$dispatch('add-item')">+</span></span>
                                            <button class="uk-button" type="submit">
                                                @if (app()->getLocale() == 'ar')
                                                    <span data-uk-icon="cart"></span> {{ __('home.Add to Cart') }}
                                                @else
                                                    {{ __('home.Add to Cart') }} <span data-uk-icon="cart"></span>
                                                @endif
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <hr class="uk-divider-icon">

                <div class="row px-lg-5" >
                    <div class="col-9">
                        @if ($item['category']['extras']->count() > 0)
                            <div class="uk-card uk-card-default">
                                <div class="uk-card-header">
                                    <h3 class="uk-card-title">
                                        {{ __('general.Extra') }}
                                    </h3>
                                </div>
                                <div class="uk-card-body" style="padding: 10px 15px;">
                                    <ul class="list-group list-group-flush">
                                        @foreach ($item['category']['extras'] as $extra)
                                            <li class="list-group-item px-0 pb-0">
                                                <div class="media">
                                                    <div class="mr-3">
                                                        {{-- <i class="icofont-ui-press text-danger food-item"></i> --}}
                                                        <div class="mr-2 text-danger align-items-center d-flex justify-content-center dot-borderd"
                                                            style="font-family: sans !important;">·</div>
                                                        <input type="checkbox" value="{{ $extra['id'] }}" name="extras[]"
                                                            class="d-none checkExtra" style="visibility: hidden" >
                                                    </div>
                                                    <div class="media-body">
                                                        <div class="media-body row">
                                                            <div class="col-10">
                                                                <h6 class="m-0"
                                                                    style="font-size: 14px;line-height: 1.8;">
                                                                    {{ app()->getLocale() == 'ar' ? $extra['name_ar'] : $extra['name_en'] }}
                                                                </h6>
                                                                <p class="text-gray m-0 d-flex justify-content-between align-items-center col-9 px-0 px-0"
                                                                    style="font-size: 11px;">
                                                                    <span>
                                                                        {{ __('home.Calories') }}:
                                                                        {{ $extra['calories'] }}
                                                                    </span>
                                                                    <span>
                                                                        ({{ round($extra['price'], 2) }}
                                                                        {{ __('general.SR') }})
                                                                    </span>
                                                                </p>
                                                            </div>
                                                            <div class="col-2">
                                                                <button type="button"
                                                                    class="btn btn-outline-secondary btn-sm btnAdd"
                                                                    x-on:click="addToItem(
                                                                    'extras',
                                                                    {{ $extra['id'] }},
                                                                    '{{ app()->getLocale() == 'ar' ? $extra['name_ar'] : $extra['name_en'] }}',
                                                                    {{ round($extra['price'], 2) }}
                                                                )">
                                                                    {{ __('general.ADD') }}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        @if ($item['category']['withouts']->count() > 0)
                            <div class="uk-card uk-card-default mt-4">
                                <div class="uk-card-header">
                                    <h3 class="uk-card-title">
                                        {{ __('general.Without') }}
                                    </h3>
                                </div>
                                <div class="uk-card-body" style="padding: 10px 15px;">
                                    <ul class="list-group list-group-flush">
                                        @foreach ($item['category']['withouts'] as $extra)
                                            <li class="list-group-item px-0 pb-0">
                                                <div class="media">
                                                    <div class="mr-3">
                                                        <div class="mr-2 text-success align-items-center d-flex justify-content-center dot-borderd"
                                                            style="font-family: sans !important;">·</div><input
                                                            type="checkbox" value="{{ $extra['id'] }}"
                                                            name="withouts[]" class="d-none checkExtra"
                                                            style="visibility: hidden">
                                                    </div>
                                                    <div class="media-body">
                                                        <div class="media-body row">
                                                            <div class="col-10">
                                                                <h6 class="m-0"
                                                                    style="font-size: 14px;line-height: 1.8;">
                                                                    {{ app()->getLocale() == 'ar' ? $extra['name_ar'] : $extra['name_en'] }}
                                                                </h6>
                                                                <p class="text-gray m-0 d-flex justify-content-between align-items-center col-9 px-0"
                                                                    style="font-size: 11px;">
                                                                    <span>
                                                                        {{ __('home.Calories') }}:
                                                                        {{ $extra['calories'] }}
                                                                    </span>
                                                                    <span>
                                                                        ({{ round($extra['price'], 2) }}
                                                                        {{ __('general.SR') }})
                                                                    </span>
                                                                </p>
                                                            </div>
                                                            <div class="col-2">
                                                                <button type="button"
                                                                    class="btn btn-outline-secondary btn-sm btnAdd"
                                                                    x-on:click="addToItem(
                                                                    'withouts',
                                                                    {{ $extra['id'] }},
                                                                    '{{ app()->getLocale() == 'ar' ? $extra['name_ar'] : $extra['name_en'] }}',
                                                                    {{ round($extra['price'], 2) }}
                                                                )">
                                                                    {{ __('general.ADD') }}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="col-3">
                        <div style="position: sticky; top: 0;">
                            <div class="uk-card uk-card-default">
                                <div class="uk-card-header">
                                    <h3 class="uk-card-title text-center">
                                        {{ 'Order Details' }}
                                    </h3>
                                </div>
                                <div id="accordion">
                                    <template x-for="(item, inx) in items" :key="item.uid">
                                        <div class="card mb-2">
                                            <div class="card-header" x-bind:id="'heading' + item.uid"
                                                x-bind:class="{ 'active': activeItem === item.uid }">
                                                <h5 class="mb-0 row">
                                                    <button class="btn btn-link col-9"
                                                        style="text-align: start;text-indent: .5rem"
                                                        data-toggle="collapse" x-bind:data-target="'#collapse' + item.uid"
                                                        aria-expanded="false" x-bind:aria-controls="'#collapse' + item.uid"
                                                        x-on:click="activeItem = item.uid">
                                                        <span
                                                            x-text="item.title + '#' + (item.uid.toString()).substr(5)"></span>
                                                    </button>
                                                    <div class="col-3" style="text-align: end">
                                                        <button type="button" x-on:click.prevent="removeItem(item.uid)"
                                                            class="btn btn-danger p-1 rounded" uk-icon="trash"></button>
                                                    </div>
                                                </h5>
                                            </div>

                                            <div x-bind:id="'collapse' + item.uid" class="collapse"
                                                x-bind:aria-labelledby="'heading' + item.uid" data-parent="#accordion">
                                                <div class="card-body p-0">
                                                    <div class="">
                                                        <ul class="list-group list-group-flush">
                                                            <template x-for="ex in item.extras"
                                                                :key="item.extras.length * Math.random()">
                                                                <li class="list-group-item"
                                                                    style="padding: 0.3rem 0.5rem;">
                                                                    <div
                                                                        class="w-full p-1 d-flex align-items-center justify-content-between">
                                                                        <div class="text-lg d-flex align-items-center">
                                                                            <span
                                                                                class="mr-2 text-danger align-items-center d-flex justify-content-center dot-borderd"
                                                                                style="font-family: sans !important;">·</span>
                                                                            {{-- </span> --}}
                                                                            <span class="text-lg text-black"
                                                                                x-text="ex.name"></span>
                                                                        </div>
                                                                        <div>
                                                                            (<span class="text-gray"
                                                                                x-text="ex.price"></span>
                                                                            {{ __('general.SR') }})
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </template>
                                                            <template x-for="ex in item.withouts"
                                                                :key="item.withouts.length * Math.random()">
                                                                <li class="list-group-item"
                                                                    style="padding: 0.3rem 0.5rem;">
                                                                    <div
                                                                        class="w-full p-1 d-flex align-items-center justify-content-between">
                                                                        <div class="text-lg d-flex align-items-center">
                                                                            <span
                                                                                class="mr-2 text-success align-items-center d-flex justify-content-center dot-borderd"
                                                                                style="font-family: sans !important;">·</span>
                                                                            {{-- </span> --}}
                                                                            <span class="text-lg text-black"
                                                                                x-text="ex.name"></span>
                                                                        </div>
                                                                        <div>
                                                                            (<span class="text-gray"
                                                                                x-text="ex.price"></span>
                                                                            {{ __('general.SR') }})
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </template>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </template>
                                </div>
                            </div>

                            {{-- order details --}}
                            <div class="uk-card uk-card-default">
                                <div class="card-body" style="line-height: .75rem;">
                                    <p>
                                        {{__('general.over_all')}}: (<span
                                            x-text="(
                                        (items.reduce((a, b) => {
                                            return a + b.real_price + b.extras.reduce((ea, eb) => ea+eb.price, 0) + b.withouts.reduce((ea, eb) => ea+eb.price, 0);    
                                        }, 0))
                                    ).toFixed(2)"></span>
                                        SA)
                                    </p>
                                    <p>
                                        {{__('general.Total')}}: (<span
                                            x-text="(
                                        (items.reduce((a, b) => {
                                            return a + b.real_price + b.extras.reduce((ea, eb) => ea+eb.price, 0) + b.withouts.reduce((ea, eb) => ea+eb.price, 0);    
                                        }, 0))
                                    ).toFixed(2)"></span>
                                        SA)
                                    </p>
                                    <hr>
                                    <h4 class="p-0 m-0">
                                        {{__('general.to_pay')}}: (<span
                                            x-text="(
                                        (items.reduce((a, b) => {
                                            return a + b.price + b.extras.reduce((ea, eb) => ea+eb.price, 0) + b.withouts.reduce((ea, eb) => ea+eb.price, 0);    
                                        }, 0))
                                    ).toFixed(2)"></span>
                                        SA)
                                    </h4>
                                </div>
                                <div class="card-footer text-center">
                                    <button class="uk-button" type="submit">
                                        {{__('general.to_pay')}} (<span
                                            x-text="(
                                        (items.reduce((a, b) => {
                                            return a + b.price + b.extras.reduce((ea, eb) => ea+eb.price, 0) + b.withouts.reduce((ea, eb) => ea+eb.price, 0);    
                                        }, 0))
                                    ).toFixed(2)"></span>
                                        SA)
                                        <span class="fa fa-arrow-right"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            </div>
            </div>

            </form>
            </div>
            </div>

        </main>
    @endsection

    @section('scripts')
        <script>
            $('.btnAdd').click(function(e) {
                e.preventDefault();
                let selectele = $(this);
                if (selectele.next().find('.food-item').hasClass('text-danger')) {
                    selectele.next().find('.food-item').removeClass('text-danger').addClass('text-success');
                    selectele.next().find('.checkExtra').attr('checked', 'checked');
                } else if (selectele.next().find('.food-item').hasClass('text-success')) {
                    selectele.next().find('.food-item').removeClass('text-success').addClass('text-danger');
                    selectele.next().find('.checkExtra').attr('checked', '');
                }
            });
        </script>
    @endsection