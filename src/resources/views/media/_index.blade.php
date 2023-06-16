<?php $media = $model->getMedia($collection ?? 'default') ?>

<x-appshell::card>
    <x-slot:title>
        {{ __('Images') }}
        <span class="badge rounded-pill text-bg-dark float-right">{{ $media->count() }}</span>
    </x-slot:title>

    @if($media->isNotEmpty())
        <div id="model-images" class="carousel slide" data-ride="carousel" data-interval="false">

            <ol class="carousel-indicators">
                @foreach($media as $medium)
                    <li data-target="#product-images" data-slide-to="{{ $loop->index }}"{{ $loop->first ? ' class="active"' : ''}}></li>
                @endforeach
            </ol>

            <div class="carousel-inner">
                @foreach($media as $medium)
                    <div class="carousel-item{{ $loop->first ? ' active' : ''}}">
                        <img class="d-block w-100" src="{{ $medium->getUrl('thumbnail') }}" alt="{{ $medium->name }}">
                    </div>
                @endforeach
            </div>

            <a class="carousel-control-prev" href="#model-images" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">{{ __('Previous') }}</span>
            </a>
            <a class="carousel-control-next" href="#model-images" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">{{ __('Next') }}</span>
            </a>
        </div>
    @else
        <div class="alert alert-secondary">{{ __('No image') }}</div>
    @endif
</x-appshell::card>
