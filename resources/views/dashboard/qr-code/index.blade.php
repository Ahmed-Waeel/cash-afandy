<x-layouts::dashboard>
    @push('styles')
        <style>
            #qrcode {
                display: flex;
                justify-content: center;
            }

            #qrcode img,
            #qrcode canvas {
                max-width: 100% !important;
                max-height: 100% !important;
            }
        </style>
    @endpush

    <x-form class="card" qrcode-form>
        <div class="card-header">
            <div class="card-title">{{ __('Generate QR Code') }}</div>
        </div>

        <div class="card-body">
            <div class="mb-3">
                <x-input name="content" :value="app_name()" :title="__('Enter text to generate QR code')" />
            </div>

            <div class="row">
                <div class="col-12 col-md-6 mb-3">
                    <x-color-picker name="background" value="#ffffff" :title="__('Background Color')" />
                </div>

                <div class="col-12 col-md-6 mb-3">
                    <x-color-picker name="foreground" value="#000000" :title="__('Foreground Color')" />
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-6 mb-3">
                    <x-select name="size" :value="512" :title="__('Size')" :options="[
                        128 => '128px',
                        256 => '256px',
                        512 => '512px',
                        1024 => '1024px',
                    ]" />
                </div>

                <div class="col-12 col-md-6 mb-3">
                    <x-select name="level" :value="'H'" :title="__('Level')" :options="[
                        'L' => __('Low'),
                        'M' => __('Medium'),
                        'Q' => __('Quartile'),
                        'H' => __('High'),
                    ]" />
                </div>
            </div>
        </div>

        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary">{{ __('Generate') }}</button>
        </div>
    </x-form>

    @push('scripts')
        <script src="{{ hashed_asset('vendor/qrcode/qrcode.min.js') }}"></script>

        <script>
            $('[qrcode-form]').on('submit', function(event) {
                event.preventDefault();
                event.stopPropagation();

                if (!$('[name="content"]').val()) {
                    return toastify().error('{{ __('Please enter text to generate QR code') }}');
                }

                $.confirm({
                    title: '{{ __('QR Code') }}',
                    content: `<div id="qrcode" class="border rounded p-3"></div>`,
                    buttons: {
                        close: {
                            text: '{{ __('Close') }}',
                            btnClass: 'btn-secondary',
                        },
                        confirm: {
                            text: '{{ __('Download') }}',
                            btnClass: 'btn btn-primary',
                            action: function() {
                                const canvas = $('#qrcode canvas').get(0);
                                const image = canvas.toDataURL('image/png');

                                $('<a>').attr('href', image).attr('download', 'qr-code.png').get(0).click();
                            },
                        },
                    },
                    onOpenBefore: function() {
                        const container = this.$content.find('#qrcode');

                        generateQrCode(container.get(0));
                        container.css('background-color', $('[name="background"]').val());
                    },
                });
            });

            function generateQrCode(element) {
                try {
                    const qrCode = new QRCode(element, {
                        width: $('[name="size"]').val(),
                        height: $('[name="size"]').val(),
                        colorDark: $('[name="foreground"]').val(),
                        colorLight: $('[name="background"]').val(),
                        correctLevel: QRCode.CorrectLevel[$('[name="level"]').val()],
                    });

                    qrCode.makeCode($('[name="content"]').val());
                } catch (error) {
                    toastify().error('{{ __('Failed to generate QR code') }}');
                }
            }
        </script>
    @endpush
</x-layouts::dashboard>
