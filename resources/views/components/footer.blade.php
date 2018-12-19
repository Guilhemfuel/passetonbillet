<div class="section-footer">
    <div class="container">
        <p class="text-center text-white pt-4">PasseTonBillet © - Les Billets des uns font le bonheur des autres</p>
        <div class="footer-content row">

            <div class="text-white col-sm-11 col-10">
                <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-4 col-12">
                        <a class="text-white" href="{{route("about.page")}}">@lang('welcome.footer.about')</a>
                    </div>
                    @if(Auth::check())
                        <div class="col-sm-4 col-12">
                            <a href="#" @click.prevent="openCrisp()"  class="text-white">@lang('welcome.footer.contact')</a>
                        </div>
                    @else
                        <div class="col-sm-4 col-12">
                            <a href="{{route('contact.page')}}" class="text-white">@lang('welcome.footer.contact')</a>
                        </div>
                    @endif
                    <div class="col-sm-4 col-12">
                        <a class="text-white" href="{{route('help.page')}}">@lang('welcome.footer.help')</a>
                    </div>
                    <div class="col-sm-4 col-12">
                        <a class="text-white" href="{{route('cgu.page')}}">@lang('welcome.footer.conditions')</a>
                    </div>
                    <div class="col-sm-4 col-12">
                        <a class="text-white" href="{{route('privacy.page')}}">@lang('welcome.footer.privacy')</a>
                    </div>
                </div>
                </div>
            </div>
            <div class="text-white col-sm-1 col-2">
                <p>
                    <a target="_blank" href="{{config('links.facebook')}}">
                        <i class="fa fa-2x fa-facebook text-white" aria-hidden="true"></i>
                    </a>
                    <a target="_blank" href="{{config('links.twitter')}}">
                        <i class="fa fa-2x fa-twitter text-white" aria-hidden="true"></i>
                    </a>
                </p>
            </div>

            <div class="col-12">
                <p class="text-disclaimer p-3 pb-0">@lang('welcome.footer.provider_disclaimer')</p>
            </div>

        </div>
    </div>
</div>
