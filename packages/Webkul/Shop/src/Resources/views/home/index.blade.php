@php
    $channel = core()->getCurrentChannel();
@endphp

<!-- SEO Meta Content -->
@push ('meta')
    <meta
        name="title"
        content="{{ $channel->home_seo['meta_title'] ?? 'A.B DENTAIRE - Équipements & Produits Dentaires' }}"
    />

    <meta
        name="description"
        content="{{ $channel->home_seo['meta_description'] ?? 'Vente d\'équipements et produits dentaires professionnels pour dentistes et cliniques.' }}"
    />

    <meta
        name="keywords"
        content="{{ $channel->home_seo['meta_keywords'] ?? 'dentaire, équipements dentaires, produits dentaires, dentiste, clinique dentaire' }}"
    />
@endPush

@push('scripts')
    <script>
        localStorage.setItem('categories', JSON.stringify(@json($categories)));
    </script>
@endpush

<x-shop::layouts :hasFeature="false">
    <!-- Page Title -->
    <x-slot:title>
        {{  $channel->home_seo['meta_title'] ?? 'A.B DENTAIRE - Vente Équipements & Produits Dentaires' }}
    </x-slot>

    <!-- ============================================
         SECTION 1: HERO BANNER
         ============================================ -->
    <section class="relative bg-gradient-to-br from-brandNavy via-brandNavy to-brandBlue/30 text-white overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-20 left-10 w-72 h-72 bg-brandBlue rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-brandBlueLighter rounded-full blur-3xl"></div>
        </div>
        
        <div class="container mx-auto px-4 py-20 md:py-28 relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-8">
                    <span class="inline-flex items-center gap-2 px-4 py-2 bg-brandBlue/20 border border-brandBlue/50 rounded-full text-sm font-medium text-brandBlueLighter">
                        <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                        @lang('shop::app.home.dental.trusted-supplier')
                    </span>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight">
                        @lang('shop::app.home.dental.hero-title')
                    </h1>
                    <p class="text-xl text-gray-300 max-w-xl leading-relaxed">
                        @lang('shop::app.home.dental.hero-description')
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('shop.search.index') }}" class="inline-flex items-center gap-2 bg-brandBlue text-white px-8 py-4 rounded-full font-semibold hover:bg-brandBlueHover transition-all duration-300 shadow-lg shadow-brandBlue/30">
                            <span class="icon-cart text-xl"></span>
                            @lang('shop::app.home.dental.shop-now')
                        </a>
                        <a href="#categories" class="inline-flex items-center gap-2 border-2 border-white/50 text-white px-8 py-4 rounded-full font-semibold hover:bg-white hover:text-brandNavy transition-all duration-300">
                            @lang('shop::app.home.dental.browse-categories')
                            <span class="icon-arrow-down text-lg"></span>
                        </a>
                    </div>
                    
                    <!-- Quick Stats Row -->
                    <div class="flex flex-wrap gap-8 pt-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center">
                                <span class="icon-orders text-xl text-brandBlueLighter"></span>
                            </div>
                            <div>
                                <div class="text-2xl font-bold">500+</div>
                                <div class="text-sm text-gray-400">@lang('shop::app.home.dental.products')</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center">
                                <span class="icon-star-fill text-xl text-yellow-400"></span>
                            </div>
                            <div>
                                <div class="text-2xl font-bold">4.9/5</div>
                                <div class="text-sm text-gray-400">@lang('shop::app.home.dental.rating')</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center">
                                <span class="icon-users text-xl text-brandBlueLighter"></span>
                            </div>
                            <div>
                                <div class="text-2xl font-bold">1000+</div>
                                <div class="text-sm text-gray-400">@lang('shop::app.home.dental.clients')</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Hero Visual -->
                <div class="hidden lg:block relative">
                    <div class="absolute -inset-4 bg-gradient-to-br from-brandBlue/30 to-brandBlueLighter/20 rounded-3xl blur-2xl"></div>
                    <div class="relative bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-sm rounded-3xl p-8 border border-white/20">
                        <div class="grid grid-cols-2 gap-6">
                            <!-- Feature Cards -->
                            <div class="bg-white/10 backdrop-blur rounded-2xl p-6 border border-white/10 hover:border-brandBlue/50 transition-all duration-300">
                                <div class="w-14 h-14 rounded-xl bg-brandBlue/20 flex items-center justify-center mb-4">
                                    <span class="icon-box-fill text-3xl text-brandBlueLighter"></span>
                                </div>
                                <h3 class="font-semibold text-lg mb-2">@lang('shop::app.home.dental.equipment')</h3>
                                <p class="text-sm text-gray-400">@lang('shop::app.home.dental.equipment-desc')</p>
                            </div>
                            <div class="bg-white/10 backdrop-blur rounded-2xl p-6 border border-white/10 hover:border-brandBlue/50 transition-all duration-300">
                                <div class="w-14 h-14 rounded-xl bg-green-500/20 flex items-center justify-center mb-4">
                                    <span class="icon-checkout-address text-3xl text-green-400"></span>
                                </div>
                                <h3 class="font-semibold text-lg mb-2">@lang('shop::app.home.dental.consumables')</h3>
                                <p class="text-sm text-gray-400">@lang('shop::app.home.dental.consumables-desc')</p>
                            </div>
                            <div class="bg-white/10 backdrop-blur rounded-2xl p-6 border border-white/10 hover:border-brandBlue/50 transition-all duration-300">
                                <div class="w-14 h-14 rounded-xl bg-purple-500/20 flex items-center justify-center mb-4">
                                    <span class="icon-camera text-3xl text-purple-400"></span>
                                </div>
                                <h3 class="font-semibold text-lg mb-2">@lang('shop::app.home.dental.imaging')</h3>
                                <p class="text-sm text-gray-400">@lang('shop::app.home.dental.imaging-desc')</p>
                            </div>
                            <div class="bg-white/10 backdrop-blur rounded-2xl p-6 border border-white/10 hover:border-brandBlue/50 transition-all duration-300">
                                <div class="w-14 h-14 rounded-xl bg-orange-500/20 flex items-center justify-center mb-4">
                                    <span class="icon-gdpr-safe text-3xl text-orange-400"></span>
                                </div>
                                <h3 class="font-semibold text-lg mb-2">@lang('shop::app.home.dental.hygiene')</h3>
                                <p class="text-sm text-gray-400">@lang('shop::app.home.dental.hygiene-desc')</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Wave divider -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" class="w-full h-16 md:h-24">
                <path d="M0 60L60 52C120 44 240 28 360 24C480 20 600 28 720 40C840 52 960 68 1080 72C1200 76 1320 68 1380 64L1440 60V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0V60Z" fill="white"/>
            </svg>
        </div>
    </section>

    <!-- ============================================
         SECTION 2: TRUST BADGES
         ============================================ -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="group flex flex-col items-center text-center p-6 rounded-2xl hover:bg-brandGrayLight transition-all duration-300">
                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-brandBlue to-brandBlueLighter flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300 shadow-lg shadow-brandBlue/30">
                        <span class="icon-truck text-3xl text-white"></span>
                    </div>
                    <h3 class="font-bold text-lg text-brandNavy mb-2">@lang('shop::app.home.dental.free-shipping')</h3>
                    <p class="text-sm text-gray-500">@lang('shop::app.home.dental.free-shipping-desc')</p>
                </div>
                <div class="group flex flex-col items-center text-center p-6 rounded-2xl hover:bg-brandGrayLight transition-all duration-300">
                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300 shadow-lg shadow-green-500/30">
                        <span class="icon-checkout-address text-3xl text-white"></span>
                    </div>
                    <h3 class="font-bold text-lg text-brandNavy mb-2">@lang('shop::app.home.dental.certified')</h3>
                    <p class="text-sm text-gray-500">@lang('shop::app.home.dental.certified-desc')</p>
                </div>
                <div class="group flex flex-col items-center text-center p-6 rounded-2xl hover:bg-brandGrayLight transition-all duration-300">
                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300 shadow-lg shadow-purple-500/30">
                        <span class="icon-support text-3xl text-white"></span>
                    </div>
                    <h3 class="font-bold text-lg text-brandNavy mb-2">@lang('shop::app.home.dental.support')</h3>
                    <p class="text-sm text-gray-500">@lang('shop::app.home.dental.support-desc')</p>
                </div>
                <div class="group flex flex-col items-center text-center p-6 rounded-2xl hover:bg-brandGrayLight transition-all duration-300">
                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-orange-500 to-orange-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300 shadow-lg shadow-orange-500/30">
                        <span class="icon-orders text-3xl text-white"></span>
                    </div>
                    <h3 class="font-bold text-lg text-brandNavy mb-2">@lang('shop::app.home.dental.secure')</h3>
                    <p class="text-sm text-gray-500">@lang('shop::app.home.dental.secure-desc')</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================
         SECTION 3: PRODUCT CATEGORIES GRID
         ============================================ -->
    <section id="categories" class="py-20 bg-brandGrayLight">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <span class="inline-block px-4 py-2 bg-brandBlue/10 rounded-full text-sm font-semibold text-brandBlue mb-4">
                    @lang('shop::app.home.dental.our-categories')
                </span>
                <h2 class="text-3xl md:text-4xl font-bold text-brandNavy mb-4">@lang('shop::app.home.dental.categories-title')</h2>
                <p class="text-gray-600 max-w-2xl mx-auto text-lg">@lang('shop::app.home.dental.categories-subtitle')</p>
            </div>
            
            <!-- Category Cards Grid -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
                <a href="{{ route('shop.search.index') }}" class="group bg-white rounded-2xl p-6 text-center hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-brandBlue/30">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-brandBlue/10 flex items-center justify-center group-hover:bg-brandBlue group-hover:scale-110 transition-all duration-300">
                        <span class="icon-box-fill text-3xl text-brandBlue group-hover:text-white transition-colors"></span>
                    </div>
                    <h3 class="font-semibold text-brandNavy">@lang('shop::app.home.dental.cat-instruments')</h3>
                </a>
                <a href="{{ route('shop.search.index') }}" class="group bg-white rounded-2xl p-6 text-center hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-brandBlue/30">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-green-500/10 flex items-center justify-center group-hover:bg-green-500 group-hover:scale-110 transition-all duration-300">
                        <span class="icon-download text-3xl text-green-600 group-hover:text-white transition-colors"></span>
                    </div>
                    <h3 class="font-semibold text-brandNavy">@lang('shop::app.home.dental.cat-consumables')</h3>
                </a>
                <a href="{{ route('shop.search.index') }}" class="group bg-white rounded-2xl p-6 text-center hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-brandBlue/30">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-purple-500/10 flex items-center justify-center group-hover:bg-purple-500 group-hover:scale-110 transition-all duration-300">
                        <span class="icon-camera text-3xl text-purple-600 group-hover:text-white transition-colors"></span>
                    </div>
                    <h3 class="font-semibold text-brandNavy">@lang('shop::app.home.dental.cat-imaging')</h3>
                </a>
                <a href="{{ route('shop.search.index') }}" class="group bg-white rounded-2xl p-6 text-center hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-brandBlue/30">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-orange-500/10 flex items-center justify-center group-hover:bg-orange-500 group-hover:scale-110 transition-all duration-300">
                        <span class="icon-gdpr-safe text-3xl text-orange-600 group-hover:text-white transition-colors"></span>
                    </div>
                    <h3 class="font-semibold text-brandNavy">@lang('shop::app.home.dental.cat-hygiene')</h3>
                </a>
                <a href="{{ route('shop.search.index') }}" class="group bg-white rounded-2xl p-6 text-center hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-brandBlue/30">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-cyan-500/10 flex items-center justify-center group-hover:bg-cyan-500 group-hover:scale-110 transition-all duration-300">
                        <span class="icon-astreisk text-3xl text-cyan-600 group-hover:text-white transition-colors"></span>
                    </div>
                    <h3 class="font-semibold text-brandNavy">@lang('shop::app.home.dental.cat-prosthetics')</h3>
                </a>
                <a href="{{ route('shop.search.index') }}" class="group bg-white rounded-2xl p-6 text-center hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-brandBlue/30">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-rose-500/10 flex items-center justify-center group-hover:bg-rose-500 group-hover:scale-110 transition-all duration-300">
                        <span class="icon-heart text-3xl text-rose-600 group-hover:text-white transition-colors"></span>
                    </div>
                    <h3 class="font-semibold text-brandNavy">@lang('shop::app.home.dental.cat-orthodontics')</h3>
                </a>
            </div>
            
            <div class="text-center mt-10">
                <a href="{{ route('shop.search.index') }}" class="inline-flex items-center gap-2 bg-brandNavy text-white px-8 py-4 rounded-full font-semibold hover:bg-brandBlue transition-all duration-300">
                    @lang('shop::app.home.dental.view-all-categories')
                    <span class="icon-arrow-right text-lg"></span>
                </a>
            </div>
        </div>
    </section>

    <!-- ============================================
         SECTION 4: FEATURED PRODUCTS
         ============================================ -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row md:items-end md:justify-between mb-12">
                <div>
                    <span class="inline-block px-4 py-2 bg-brandBlue/10 rounded-full text-sm font-semibold text-brandBlue mb-4">
                        @lang('shop::app.home.dental.best-sellers')
                    </span>
                    <h2 class="text-3xl md:text-4xl font-bold text-brandNavy">@lang('shop::app.home.dental.featured-products')</h2>
                </div>
                <a href="{{ route('shop.search.index') }}" class="mt-4 md:mt-0 inline-flex items-center gap-2 text-brandBlue font-semibold hover:text-brandBlueHover transition-colors">
                    @lang('shop::app.home.dental.view-all-products')
                    <span class="icon-arrow-right"></span>
                </a>
            </div>
            
            <!-- Products Carousel -->
            <x-shop::products.carousel
                :title="''"
                :src="route('shop.api.products.index', ['limit' => 8, 'sort' => 'created_at', 'order' => 'desc'])"
                :navigation-link="route('shop.search.index')"
            />
        </div>
    </section>

    <!-- ============================================
         SECTION 5: PROMOTIONAL BANNERS
         ============================================ -->
    <section class="py-16 bg-brandGrayLight">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-2 gap-8">
                <!-- Promo Banner 1 -->
                <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-brandNavy to-brandBlue p-8 md:p-12 text-white group">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2 group-hover:scale-110 transition-transform duration-500"></div>
                    <div class="relative z-10">
                        <span class="inline-block px-3 py-1 bg-white/20 rounded-full text-sm font-medium mb-4">@lang('shop::app.home.dental.new-arrivals')</span>
                        <h3 class="text-2xl md:text-3xl font-bold mb-4">@lang('shop::app.home.dental.promo-equipment-title')</h3>
                        <p class="text-gray-300 mb-6 max-w-md">@lang('shop::app.home.dental.promo-equipment-desc')</p>
                        <a href="{{ route('shop.search.index') }}" class="inline-flex items-center gap-2 bg-white text-brandNavy px-6 py-3 rounded-full font-semibold hover:bg-gray-100 transition-colors">
                            @lang('shop::app.home.dental.shop-now')
                            <span class="icon-arrow-right"></span>
                        </a>
                    </div>
                </div>
                
                <!-- Promo Banner 2 -->
                <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-green-600 to-emerald-500 p-8 md:p-12 text-white group">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2 group-hover:scale-110 transition-transform duration-500"></div>
                    <div class="relative z-10">
                        <span class="inline-block px-3 py-1 bg-white/20 rounded-full text-sm font-medium mb-4">@lang('shop::app.home.dental.special-offer')</span>
                        <h3 class="text-2xl md:text-3xl font-bold mb-4">@lang('shop::app.home.dental.promo-consumables-title')</h3>
                        <p class="text-gray-200 mb-6 max-w-md">@lang('shop::app.home.dental.promo-consumables-desc')</p>
                        <a href="{{ route('shop.search.index') }}" class="inline-flex items-center gap-2 bg-white text-green-700 px-6 py-3 rounded-full font-semibold hover:bg-gray-100 transition-colors">
                            @lang('shop::app.home.dental.order-now')
                            <span class="icon-arrow-right"></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================
         SECTION 6: NEW ARRIVALS
         ============================================ -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row md:items-end md:justify-between mb-12">
                <div>
                    <span class="inline-block px-4 py-2 bg-green-500/10 rounded-full text-sm font-semibold text-green-600 mb-4">
                        @lang('shop::app.home.dental.just-arrived')
                    </span>
                    <h2 class="text-3xl md:text-4xl font-bold text-brandNavy">@lang('shop::app.home.dental.new-products')</h2>
                </div>
                <a href="{{ route('shop.search.index', ['new' => 1]) }}" class="mt-4 md:mt-0 inline-flex items-center gap-2 text-brandBlue font-semibold hover:text-brandBlueHover transition-colors">
                    @lang('shop::app.home.dental.view-all-new')
                    <span class="icon-arrow-right"></span>
                </a>
            </div>
            
            <!-- New Products Carousel -->
            <x-shop::products.carousel
                :title="''"
                :src="route('shop.api.products.index', ['limit' => 8, 'new' => 1])"
                :navigation-link="route('shop.search.index', ['new' => 1])"
            />
        </div>
    </section>

    <!-- ============================================
         SECTION 7: WHY CHOOSE US
         ============================================ -->
    <section class="py-20 bg-brandNavy text-white relative overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-1/4 w-96 h-96 bg-brandBlue rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-1/4 w-72 h-72 bg-brandBlueLighter rounded-full blur-3xl"></div>
        </div>
        
        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-2 bg-white/10 rounded-full text-sm font-semibold text-brandBlueLighter mb-4">
                    @lang('shop::app.home.dental.why-us')
                </span>
                <h2 class="text-3xl md:text-4xl font-bold mb-4">@lang('shop::app.home.dental.why-choose-title')</h2>
                <p class="text-gray-400 max-w-2xl mx-auto text-lg">@lang('shop::app.home.dental.why-choose-subtitle')</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center p-6">
                    <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-brandBlue/20 flex items-center justify-center">
                        <span class="icon-checkout-address text-4xl text-brandBlueLighter"></span>
                    </div>
                    <h3 class="text-xl font-bold mb-3">@lang('shop::app.home.dental.quality-title')</h3>
                    <p class="text-gray-400">@lang('shop::app.home.dental.quality-desc')</p>
                </div>
                <div class="text-center p-6">
                    <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-green-500/20 flex items-center justify-center">
                        <span class="icon-truck text-4xl text-green-400"></span>
                    </div>
                    <h3 class="text-xl font-bold mb-3">@lang('shop::app.home.dental.delivery-title')</h3>
                    <p class="text-gray-400">@lang('shop::app.home.dental.delivery-desc')</p>
                </div>
                <div class="text-center p-6">
                    <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-purple-500/20 flex items-center justify-center">
                        <span class="icon-support text-4xl text-purple-400"></span>
                    </div>
                    <h3 class="text-xl font-bold mb-3">@lang('shop::app.home.dental.expert-title')</h3>
                    <p class="text-gray-400">@lang('shop::app.home.dental.expert-desc')</p>
                </div>
                <div class="text-center p-6">
                    <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-orange-500/20 flex items-center justify-center">
                        <span class="icon-dollar-sign text-4xl text-orange-400"></span>
                    </div>
                    <h3 class="text-xl font-bold mb-3">@lang('shop::app.home.dental.price-title')</h3>
                    <p class="text-gray-400">@lang('shop::app.home.dental.price-desc')</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================
         SECTION 8: TESTIMONIALS
         ============================================ -->
    <section class="py-20 bg-brandGrayLight">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <span class="inline-block px-4 py-2 bg-brandBlue/10 rounded-full text-sm font-semibold text-brandBlue mb-4">
                    @lang('shop::app.home.dental.testimonials')
                </span>
                <h2 class="text-3xl md:text-4xl font-bold text-brandNavy mb-4">@lang('shop::app.home.dental.testimonials-title')</h2>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow">
                    <div class="flex items-center gap-1 mb-4">
                        <span class="icon-star-fill text-yellow-400"></span>
                        <span class="icon-star-fill text-yellow-400"></span>
                        <span class="icon-star-fill text-yellow-400"></span>
                        <span class="icon-star-fill text-yellow-400"></span>
                        <span class="icon-star-fill text-yellow-400"></span>
                    </div>
                    <p class="text-gray-600 mb-6 italic">"@lang('shop::app.home.dental.testimonial-1')"</p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-brandBlue/10 flex items-center justify-center">
                            <span class="icon-users text-xl text-brandBlue"></span>
                        </div>
                        <div>
                            <div class="font-semibold text-brandNavy">Dr. Ahmed M.</div>
                            <div class="text-sm text-gray-500">@lang('shop::app.home.dental.dentist')</div>
                        </div>
                    </div>
                </div>
                
                <!-- Testimonial 2 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow">
                    <div class="flex items-center gap-1 mb-4">
                        <span class="icon-star-fill text-yellow-400"></span>
                        <span class="icon-star-fill text-yellow-400"></span>
                        <span class="icon-star-fill text-yellow-400"></span>
                        <span class="icon-star-fill text-yellow-400"></span>
                        <span class="icon-star-fill text-yellow-400"></span>
                    </div>
                    <p class="text-gray-600 mb-6 italic">"@lang('shop::app.home.dental.testimonial-2')"</p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-green-500/10 flex items-center justify-center">
                            <span class="icon-users text-xl text-green-600"></span>
                        </div>
                        <div>
                            <div class="font-semibold text-brandNavy">Dr. Sarah L.</div>
                            <div class="text-sm text-gray-500">@lang('shop::app.home.dental.orthodontist')</div>
                        </div>
                    </div>
                </div>
                
                <!-- Testimonial 3 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow">
                    <div class="flex items-center gap-1 mb-4">
                        <span class="icon-star-fill text-yellow-400"></span>
                        <span class="icon-star-fill text-yellow-400"></span>
                        <span class="icon-star-fill text-yellow-400"></span>
                        <span class="icon-star-fill text-yellow-400"></span>
                        <span class="icon-star-fill text-yellow-400"></span>
                    </div>
                    <p class="text-gray-600 mb-6 italic">"@lang('shop::app.home.dental.testimonial-3')"</p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-purple-500/10 flex items-center justify-center">
                            <span class="icon-users text-xl text-purple-600"></span>
                        </div>
                        <div>
                            <div class="font-semibold text-brandNavy">@lang('shop::app.home.dental.clinic-name')</div>
                            <div class="text-sm text-gray-500">@lang('shop::app.home.dental.dental-clinic')</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================
         SECTION 9: CALL TO ACTION
         ============================================ -->
    <section class="py-20 bg-gradient-to-r from-brandNavy via-brandNavy to-brandBlue text-white relative overflow-hidden">
        <!-- Decorative elements -->
        <div class="absolute top-0 left-0 w-full h-full opacity-10">
            <div class="absolute top-10 left-10 w-40 h-40 border-2 border-white rounded-full"></div>
            <div class="absolute bottom-10 right-10 w-60 h-60 border-2 border-white rounded-full"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-80 h-80 border border-white/50 rounded-full"></div>
        </div>
        
        <div class="container mx-auto px-4 text-center relative z-10">
            <h2 class="text-3xl md:text-5xl font-bold mb-6">@lang('shop::app.home.dental.cta-title')</h2>
            <p class="text-xl text-gray-300 mb-10 max-w-3xl mx-auto">@lang('shop::app.home.dental.cta-description')</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('shop.customers.register.index') }}" class="inline-flex items-center gap-2 bg-white text-brandNavy px-10 py-4 rounded-full font-bold text-lg hover:bg-gray-100 transition-all duration-300 shadow-xl">
                    @lang('shop::app.home.dental.create-account')
                    <span class="icon-arrow-right"></span>
                </a>
                <a href="{{ route('shop.home.index') }}/page/contact-us" class="inline-flex items-center gap-2 border-2 border-white text-white px-10 py-4 rounded-full font-bold text-lg hover:bg-white hover:text-brandNavy transition-all duration-300">
                    <span class="icon-email"></span>
                    @lang('shop::app.home.dental.contact-us')
                </a>
            </div>
            
            <!-- Contact Info -->
            <div class="mt-16 flex flex-wrap justify-center gap-8 text-gray-300">
                <div class="flex items-center gap-3">
                    <span class="icon-email text-2xl text-brandBlueLighter"></span>
                    <span>contact@abdentaire.com</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="icon-phone text-2xl text-brandBlueLighter"></span>
                    <span>+213 555 123 456</span>
                </div>
            </div>
        </div>
    </section>
</x-shop::layouts>
