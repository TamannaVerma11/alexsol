</div>
<!--End of main container fluid-->
<div class="container-fluid footer-container">
<div class="row footer-row">
    <div class="col-6">
        <div class="footer-menu">
            <ul>
                <a href="{{route('tos', app()->getLocale())}}">
                    <li>{{ trans('index.footer_phrase1') }}</li>
                </a>
            </ul>
        </div>
    </div>
    <div class="col-6">
        <div class="input-group footer-lang">
            <div class="input-group-prepend">
                <div class="input-group-text"><i class="fas fa-language"></i></div>
            </div>
            <select id="" class="form-control form-control-sm" onchange="changeLanguage(this.value)">
                @forelse ($languages as $language)
                    <option
                        {{ app()->getLocale() ? (app()->getLocale() == $language->language_code ? 'selected' : '') : '' }}
                        value="{{ $language->language_code }}">{{ $language->name }}
                    </option>
                @empty
                @endforelse
            </select>
        </div>
    </div>
</div>
</div
