<div>
    <div class="flex flex-col rounded shadow-sm bg-discord-gray-1 overflow-hidden">
        <div class="py-4 px-5 lg:px-6 w-full flex items-center justify-between border-b border-discord-gray-4">
            <div class="flex space-x-1">
                <h3 class="font-semibold">{{ __('Sticker') }}</h3>
                <span class="mt-0.5 text-sm">({{ sizeof($stickers) }})</span>
            </div>
            {{-- TODO: Check sticker endpoint CORS policy
            <div class="text-center sm:text-right">
                <button type="button" onclick="downloadStickers('{{ $guildId }}')" id="buttonDownloadAllStickers" class="inline-flex justify-center items-center gap-2 border font-semibold rounded px-2 py-1 leading-5 text-sm w-full border-discord-blurple bg-discord-blurple text-white hover:text-white hover:bg-[#4e5acb] hover:border-[#4e5acb] focus:ring-opacity-50 active:bg-[#414aa5] active:border-[#414aa5]">
                    <i class="fas fa-download"></i> {{ __('Download') }}
                </button>
            </div>
            --}}
        </div>
        <div class="p-5 lg:p-6 grow w-full">
            <div class="grid grid-cols-1 gap-x-6 gap-y-4">
                @foreach($stickers as $sticker)
                    <div class="w-full flex items-center">
                        <div class="w-16 mr-4">
                            <a href="{{ getStickerUrl($sticker['id']) }}" target="_blank">
                                <img
                                    src="{{ getStickerUrl($sticker['id']) }}"
                                    loading="lazy"
                                    alt="{{ $sticker['name'] }} Sticker"
                                    class="inline-block max-h-16 max-w-16"
                                />
                            </a>
                        </div>
                        <div>
                            <p>{{ $sticker['name'] }}</p>
                            <p class="text-gray-300 text-sm">{{ $sticker['description'] }}</p>
                            <p class="text-gray-400 text-sm">{{ __('Tags') }}: {{ $sticker['tags'] }}</p>
                            <p class="text-gray-500 text-sm">{{ $sticker['id'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{--
    <div class="modal fade" id="emojiDownloadModal" tabindex="-1" aria-labelledby="emojiDownloadModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-dark border-0">
                <div class="modal-header justify-content-center">
                    <h5 class="modal-title fw-bold" id="emojiDownloadModalLabel">{{ __('Legal Notice') }}</h5>
                </div>
                <div class="modal-body text-center">
                    {{ __('Stickers of some Servers could be protected by applicable copyright law.') }}<br>
                    {{ __('The stickers will be downloaded locally on your device and you have to ensure that you don\'t infrige anyones copyright while using them.') }}<br>
                    <b>{{ __('NO LIABILITY WILL BE GIVEN FOR ANY DAMAGES CAUSED BY USING THESE FILES') }}</b>
                </div>
                <div class="modal-footer bg-dark justify-content-center">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" onclick="downloadEmojis('{{ $guildData['id'] }}', urls)">{{ __('Confirm') }}</button>
                </div>
            </div>
        </div>
    </div>
    --}}

    {{-- TODO: Check sticker endpoint CORS policy
    <script>
        function downloadStickers(guildId) {
            document.getElementById('buttonDownloadAllStickers').disabled = true;
            document.getElementById('buttonDownloadAllStickers').innerHTML = '<i class="fas fa-spinner fa-spin"></i> {{ __('Downloading...') }}';

            var urls = [
                @foreach($stickers as $sticker)
                    '{{ getStickerUrl($sticker['id'], 1024, 'png') }}',
                @endforeach
            ];

            // https://gist.github.com/c4software/981661f1f826ad34c2a5dc11070add0f#gistcomment-3372574
            var zip = new JSZip();
            var count = 0;
            var filenameCounter = 0;
            var fileNames = [];
            for (var i = 0; i < urls.length; i++) {
                fileNames[i] = urls[i].split('/').pop().split('?')[0];
            }
            urls.forEach(function (url) {
                var filename = fileNames[filenameCounter];
                filenameCounter++;
                JSZipUtils.getBinaryContent(url, function (err, data) {
                    if (err) throw err;
                    zip.file(filename, data, {binary: true});
                    count++;
                    if (count === urls.length) {
                        zip.generateAsync({type: 'blob'}).then(function (content) {
                            saveAs(content, 'stickers_' + guildId + '.zip');
                            document.getElementById('buttonDownloadAllStickers').disabled = false;
                            document.getElementById('buttonDownloadAllStickers').innerHTML = '<i class="fas fa-download"></i> {{ __('Download') }}';
                        });
                    }
                });
            });
        }
    </script>
    --}}
</div>
