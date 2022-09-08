<div>
    @foreach($banners as $banner)
        <div class="banner text-center" id="banner_{{ $banner['id'] }}" style="display: none;">
            <span class="align-middle">{!! $banner['text'] !!}</span>
            <a role="button" href="{{ $banner['buttonUrl'] }}" target="{{ $banner['buttonTarget'] }}" class="btn banner-btn-outline-light ms-2" aria-label="Close">{{ $banner['buttonText'] }}</a>
            <button type="button" class="btn btn-close btn-close-white float-end mt-1" aria-label="Close" onclick="dismissBanner('{{ $banner['id'] }}')"></button>
        </div>
    @endforeach

    <script>
        const banners = [
            @foreach($banners as $banner)
                @if($banner['requiredAuth'])
                    @auth
                        '{{ $banner['id'] }}',
                    @endauth
                @else
                '{{ $banner['id'] }}',
                @endif
            @endforeach
        ];

        const storageBanners = JSON.parse(localStorage.getItem('dismissed-banners')) ?? [];
        for(const id of banners) {
            if(!storageBanners.includes(id)) {
                const bannerElement = document.getElementById('banner_' + id);
                if(bannerElement) bannerElement.style.display = ''
                break;
            }
        }

        function dismissBanner(id) {
            const bannerElement = document.getElementById('banner_' + id);
            const storageBanners = JSON.parse(localStorage.getItem('dismissed-banners')) ?? [];
            storageBanners.push(id);
            localStorage.setItem('dismissed-banners', JSON.stringify(storageBanners));
            if(bannerElement) bannerElement.style.display = 'none'
        }
    </script>
</div>
