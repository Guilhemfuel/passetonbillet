<div class="section-footer">
    <div class="container">
        <p class="text-center text-white pt-4">PasseTonBillet ©</p>
        <div class="footer-content row">

            <div class="text-white col-sm-11 col-10">
                <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-4 col-12">
                        <a class="text-white" href="{{route("about.page")}}">@lang('welcome.footer.about')</a>
                    </div>
                    <div class="col-sm-4 col-12">
                        <a class="text-white" href="#" onclick="e.preventDefault();$crisp.push(['do', 'chat:open'])">@lang('welcome.footer.help')</a>
                    </div>
                    <div class="col-sm-4 col-12">
                        <a href="{{route('contact.page')}}" class="text-white">@lang('welcome.footer.contact')</a>
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