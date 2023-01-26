<div class="form-group">
    <div class="input-group">
        <span class="input-group-prepend">
            <span class="input-group-text">
                {!! icon('product') !!}
            </span>
        </span>
        {{ Form::text('name', null, [
                'class' => 'form-control form-control-lg' . ($errors->has('name') ? ' is-invalid' : ''),
                'placeholder' => __('Variant name')
            ])
        }}
        @if ($errors->has('name'))
            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
        @endif
    </div>
</div>

<hr>

<div class="form-row">
    <div class="form-group col-12 col-md-6 col-xl-4">
        <label class="form-control-label">{{ __('SKU') }}</label>
        <div class="input-group">
            <span class="input-group-prepend">
                <span class="input-group-text">
                    {!! icon('sku') !!}
                </span>
            </span>
            {{ Form::text('sku', null, [
                    'class' => 'form-control' . ($errors->has('sku') ? ' is-invalid' : ''),
                    'placeholder' => __('SKU (product code)')
                ])
            }}
        </div>
        @if ($errors->has('sku'))
            <input hidden class="form-control is-invalid">
            <div class="invalid-feedback">{{ $errors->first('sku') }}</div>
        @endif
    </div>

    <div class="form-group col-12 col-md-6 col-xl-4">
        <label class="form-control-label">{{ __('Stock') }}</label>
        <div class="input-group">
            <span class="input-group-prepend">
                <span class="input-group-text">
                    {!! icon('stock') !!}
                </span>
            </span>
            {{ Form::number('stock', null, [
                    'class' => 'form-control' . ($errors->has('stock') ? ' is-invalid' : ''),
                    'placeholder' => __('Product Stock Count')
                ])
            }}
        </div>
        @if ($errors->has('stock'))
            <input hidden class="form-control is-invalid">
            <div class="invalid-feedback">{{ $errors->first('stock') }}</div>
        @endif
    </div>

</div>

<div class="form-row">
    <div class="form-group col-12 col-md-6 col-xl-4">
        <label class="form-control-label">{{ __('Price') }}</label>
        <div class="input-group">
            {{ Form::text('price', null, [
                    'class' => 'form-control' . ($errors->has('price') ? ' is-invalid' : ''),
                    'placeholder' => __('Price')
                ])
            }}
            <span class="input-group-append">
                <span class="input-group-text">
                    {{ config('vanilo.foundation.currency.code') }}
                </span>
            </span>
        </div>
        @if ($errors->has('price'))
            <input type="hidden" class="form-control is-invalid">
            <div class="invalid-feedback">{{ $errors->first('price') }}</div>
        @endif
    </div>

    <div class="form-group col-12 col-md-6 col-xl-4">
        <label class="form-control-label text-muted">{{ __('Original Price') }} ({{ __('optional') }})</label>
        <div class="input-group">
            {{ Form::text('original_price', null, [
                    'class' => 'form-control' . ($errors->has('original_price') ? ' is-invalid' : ''),
                    'placeholder' => __('Aka "strikethrough" price')
                ])
            }}
            <span class="input-group-append">
                <span class="input-group-text">
                    {{ config('vanilo.foundation.currency.code') }}
                </span>
            </span>
        </div>
        @if ($errors->has('original_price'))
            <input type="hidden" class="form-control is-invalid">
            <div class="invalid-feedback">{{ $errors->first('original_price') }}</div>
        @endif
    </div>
</div>

<hr>

<div class="form-group">
    <label>{{ __('Description') }}</label>

    {{ Form::textarea('description', null,
            [
                'class' => 'form-control' . ($errors->has('description') ? ' is-invalid' : ''),
                'placeholder' => __('Type or copy/paste product description here')
            ]
    ) }}

    @if ($errors->has('description'))
        <div class="invalid-feedback">{{ $errors->first('description') }}</div>
    @endif
</div>

<hr>

<div class="form-group">
    <label class="form-control-label text-muted">{{ __('Short Description') }} ({{ __('optional') }})</label>
    {{ Form::textarea('excerpt', null, [
            'class' => 'form-control form-control-sm' . ($errors->has('excerpt') ? ' is-invalid' : ''),
            'placeholder' => __('Short Description'),
            'rows' => 4
        ])
    }}
    @if ($errors->has('excerpt'))
        <div class="invalid-feedback">{{ $errors->first('excerpt') }}</div>
    @endif
</div>
